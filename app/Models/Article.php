<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Helpers\HasLikes;
use App\Helpers\HasSlug;
use App\Helpers\HasTags;
use App\Helpers\HasTimestamps;
use App\Helpers\PreparesSearch;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

final class Article extends Model
{
    use HasFactory;
    use HasAuthor;
    use HasSlug;
    use HasLikes;
    use HasTimestamps;
    use HasTags;
    use PreparesSearch;
    use Searchable;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'title',
        'body',
        'original_url',
        'slug',
        'is_pinned',
        'tweet_id',
        'submitted_at',
        'approved_at',
        'shared_at',
    ];

    /**
     * {@inheritdoc}
     */
    protected $dates = [
        'submitted_at',
        'approved_at',
        'shared_at',
    ];

    /**
     * {@inheritdoc}
     */
    protected $with = [
        'authorRelation',
        'likesRelation',
        'tagsRelation',
    ];

    public function id(): int
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function body(): string
    {
        return $this->body;
    }

    public function excerpt(int $limit = 100): string
    {
        return Str::limit(strip_tags(md_to_html($this->body())), $limit);
    }

    public function originalUrl(): ?string
    {
        return $this->original_url;
    }

    public function canonicalUrl(): string
    {
        return $this->originalUrl() ?: route('articles.show', $this->slug);
    }

    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    public function updateSeries(Series $series = null): self
    {
        if ($series === null) {
            return $this->removeSeries();
        }

        return $this->addToSeries($series);
    }

    public function addToSeries(Series $series): self
    {
        $this->series()->associate($series);
        $this->save();

        return $this;
    }

    public function removeSeries(): self
    {
        $this->series()->dissociate();
        $this->save();

        return $this;
    }

    public function submittedAt(): ?Carbon
    {
        return $this->submitted_at;
    }

    public function approvedAt(): ?Carbon
    {
        return $this->approved_at;
    }

    public function isSubmitted(): bool
    {
        return ! $this->isNotSubmitted();
    }

    public function isNotSubmitted(): bool
    {
        return $this->submitted_at === null;
    }

    public function isApproved(): bool
    {
        return ! $this->isNotApproved();
    }

    public function isNotApproved(): bool
    {
        return $this->approved_at === null;
    }

    public function isPublished(): bool
    {
        return ! $this->isNotPublished();
    }

    public function isNotPublished(): bool
    {
        return $this->isNotSubmitted() || $this->isNotApproved();
    }

    public function isPinned(): bool
    {
        return (bool) $this->is_pinned;
    }

    public function isNotShared(): bool
    {
        return $this->shared_at === null;
    }

    public function isShared(): bool
    {
        return ! $this->isNotShared();
    }

    public function isAwaitingApproval(): bool
    {
        return $this->isSubmitted() && $this->isNotApproved();
    }

    public function isNotAwaitingApproval(): bool
    {
        return ! $this->isAwaitingApproval();
    }

    public function readTime()
    {
        $minutes = round(str_word_count($this->body()) / 200);

        return $minutes == 0 ? 1 : $minutes;
    }

    public function scopeSubmitted(Builder $query): Builder
    {
        return $query->whereNotNull('submitted_at');
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->whereNotNull('approved_at');
    }

    public function scopeNotApproved(Builder $query): Builder
    {
        return $query->whereNull('approved_at');
    }

    public function scopeAwaitingApproval(Builder $query): Builder
    {
        return $query->submitted()
            ->notApproved();
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->submitted()
            ->approved();
    }

    public function scopeNotPublished(Builder $query): Builder
    {
        return $query->where(function ($query) {
            $query->whereNull('submitted_at')
                ->orWhereNull('approved_at');
        });
    }

    public function scopeShared(Builder $query): Builder
    {
        return $query->whereNotNull('shared_at');
    }

    public function scopeNotShared(Builder $query): Builder
    {
        return $query->whereNull('shared_at');
    }

    public function scopeForTag(Builder $query, string $tag): Builder
    {
        return $query->whereHas('tagsRelation', function ($query) use ($tag) {
            $query->where('tags.slug', $tag);
        });
    }

    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderBy('is_pinned', 'desc')
            ->orderBy('submitted_at', 'desc');
    }

    public function scopePopular(Builder $query): Builder
    {
        return $query->withCount('likesRelation')
            ->orderBy('likes_relation_count', 'desc')
            ->orderBy('submitted_at', 'desc');
    }

    public function scopeTrending(Builder $query): Builder
    {
        return $query->withCount(['likesRelation' => function ($query) {
            $query->where('created_at', '>=', now()->subWeek());
        }])
            ->orderBy('likes_relation_count', 'desc')
            ->orderBy('submitted_at', 'desc');
    }

    public function previousInSeries(): ?self
    {
        return $this->series
            ->articles()
            ->published()
            ->where('submitted_at', '<', $this->submittedAt())
            ->orderByDesc('submitted_at')
            ->first();
    }

    public function nextInSeries(): ?self
    {
        return $this->series
            ->articles()
            ->published()
            ->where('submitted_at', '>', $this->submittedAt())
            ->orderBy('submitted_at')
            ->first();
    }

    public function shouldBeSearchable()
    {
        return $this->isPublished();
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id(),
            'title' => $this->title(),
            'body' => $this->body(),
            'slug' => $this->slug(),
        ];
    }

    public function splitBody($value)
    {
        return $this->split($value);
    }

    public function markAsShared()
    {
        $this->update([
            'shared_at' => now(),
        ]);
    }

    public static function nextForSharing(): ?self
    {
        return self::notShared()
            ->published()
            ->orderBy('submitted_at', 'asc')
            ->first();
    }
}
