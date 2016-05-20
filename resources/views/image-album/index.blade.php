@extends('app')

@section('body_class', 'gallery')

@section('title', 'Image Gallery')

@section('content')
<div class="row">
    @foreach ($paginator->items() as $album)
        <div class="col s6 m4 l3 album {{ $album->hasMultipleImages ? 'multiple-images' : '' }}">
            <a href="{{ $album->url }}">
                <span class="title">{{ $album->title }}</span><br>
                <img src="{!! $album->coverUrl !!}" alt="{{ $album->title }}">
            </a>
            <span class="grey-text">
                by <a href="{{ $album->user->profile->url }}">{{ $album->user->name }}</a>
                {{ $album->created_at->diffForHumans() }}
            </span>
        </div>
    @endforeach
    {!! $paginator->render() !!}
</div>
@stop
