@extends('layouts.app')
@section('title')
{{$title}}
@endsection
@section('content')
@if ( !$posts->count() )
There is no post till now. Login and write a new post now!!!
@else
<div class="">
  @foreach( $posts as $post )
  <div class="well">
    <div class="row">
        <div class="col-md-4 col-sm-4">
            <img style="width:60%" src="/storage/cover_images/{{$post->cover_image}}">
            
            
        </div>
        
        <div class="col-md-8 col-sm-8">
          
          
            <h3><a href="{{ url('/'.$post->slug) }}">  {{ $post->title }}</a></h3>
            @if(!Auth::guest() && ($post->author_id == Auth::user()->id || Auth::user()->is_admin()))
           <a href="{{ url('edit/'.$post->slug)}}" class="btn btn-primary" style="float: right">Edit Post</a>
            @endif
            <small>{{ $post->created_at->format('M d,Y \a\t h:i a') }} By <a href="{{ url('/user/'.$post->author_id)}}">{{ $post->author->name }}</a></small>
            <article>
        {!! Str::limit($post->body, $limit = 150, $end = '....... <a href='.url("/".$post->slug).'>Read More</a>') !!}
      </article>
        </div>
    </div>
</div>
  @endforeach
  {!! $posts->render() !!}
</div>
@endif
@endsection