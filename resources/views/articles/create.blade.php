@title('Write your article')

@extends('layouts.default')

@section('subnav')
    <div class="bg-white border-b">
        <div class="container mx-auto flex justify-between items-center px-4">
            <h1 class="text-xl py-4 text-gray-900">
                <a href="{{ route('user.articles') }}">Your Articles</a>
                > {{ $title }}
            </h1>
        </div>
    </div>
@endsection

@section('content')
    <div class="container mx-auto p-4 flex justify-center">
        <div class="w-full md:w-2/3 xl:w-1/2">
            <div class="md:border-2 md:rounded md:bg-gray-100">
                @include('articles._form', [
                    'route' => ['articles.store'],
                ])
            </div>
        </div>
    </div>
@endsection
