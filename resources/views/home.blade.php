@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4">{{ __('home.name') }}</h1>
            <p class="lead">@lang('home.description')</p>
            <hr class="my-4">
            <p>@lang('home.project')</p>
            <a class="btn btn-primary btn-lg"
               href="https://github.com/Nemial/php-project-lvl4">@lang('home.button')</a>
        </div>
    </div>
@endsection
