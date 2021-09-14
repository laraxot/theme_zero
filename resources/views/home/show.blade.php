@extends('pub_theme::layouts.app')
@section('content')
<div class="content">

    <div class="title m-b-md">
        Laravel
        <p class="versioninfo">Version {{ app()->version() }}</p>
    </div>

    <div class="links">
        <a href="https://laravel.com/docs">Documentation</a>
        <a href="https://laracasts.com">Laracasts</a>
        <a href="https://laravel-news.com">News</a>
        <a href="https://forge.laravel.com">Forge</a>
        <a href="https://github.com/laravel/laravel">GitHub</a>
    </div>

    {{ get_class($_panel) }}


    <h3>Container</h3>
    @foreach($_panel->containerActions() as $action)
        {!! $action->btnHtml() !!}
    @endforeach

    <h3>Item</h3> SE NON  VEDI IL TASTO E' PERCHE' lA policy dice che non hai il diritto
    <ul>
    @foreach($_panel->itemActions() as $action)
       <li>{!! $action->btnHtml() !!}{{ $action->getName() }}</li>
    @endforeach
    </ul>


</div>
@endsection
