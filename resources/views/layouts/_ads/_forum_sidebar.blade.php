@php($banner = Illuminate\Support\Arr::random(config('lio.ads')))

<a href="{{ $banner['url'] }}" target="_blank" rel="noopener noreferrer" onclick="fathom.trackGoal('{{ $banner['goal'] }}', 0);">
    <img class="my-4 mx-auto w-full" style="max-width:300px" src="{{ asset("/images/showcase/{$banner['image']}-small.png") }}" alt="{{ $banner['alt'] }}">
</a>

@include('layouts._ads._cta', ['text' => 'Your banner here too?'])
