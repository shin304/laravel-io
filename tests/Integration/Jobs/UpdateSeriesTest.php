<?php

namespace Tests\Integration\Jobs;

use App\Jobs\UpdateSeries;
use App\Models\Series;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UpdateSeriesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function we_can_update_a_series()
    {
        $user = $this->createUser();
        $series = Series::factory()->create(['author_id' => $user->id()]);

        $series = $this->dispatch(new UpdateSeries($series, ['title' => 'Title']));

        $this->assertEquals('Title', $series->title());
    }
}
