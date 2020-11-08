@extends('layouts.app')
@section('title')
  @if($post)
    {{ $post->title }}
    @if(!Auth::guest() && ($post->author_id == Auth::user()->id || Auth::user()->is_admin()))
      <a href="{{ url('edit/'.$post->slug)}}" class="btn btn-primary" style="float: right">Edit Post</a>

    @endif
  @else
    Page does not exist
  @endif
@endsection
@section('title-meta')
<p>{{ $post->created_at->format('M d,Y \a\t h:i a') }} By <a href="{{ url('/user/'.$post->author_id)}}">{{ $post->author->name }}</a></p>
@endsection
@section('content')
@if($post)
  <div>
    <img style="width:40%" src="/storage/cover_images/{{$post->cover_image}}">
    <br>
    {!! $post->body !!}
  </div>    
  <div>

    @if($comments)
    <ul style="list-style: none; padding: 0">
      @foreach($comments as $comment)
        <li class="panel-body">
          <div class="list-group">
            <div class="list-group-item">
              <b>{{ $comment->author->name }}</h4>
            <h6>  <b>{{ $comment->created_at->format('M d,Y \a\t h:i a') }}</b></h6>
            </div>
            <div class="list-group-item">
              <h5>{{ $comment->body }}</h5>
            </div>
          </div>
        </li>
      @endforeach
    </ul>
    @endif
  </div>
</div>
@if(Auth::guest())
<div class="panel-body">
  <b>You have to Login in order to Comment</b>
</div>
@else
  <div class="panel-body">
    <form method="post" action="/comment/add">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" name="on_post" value="{{ $post->id }}">
      <input type="hidden" name="slug" value="{{ $post->slug }}">
      <div class="form-group">
        <textarea required="required" placeholder="Enter comment here" name = "body" class="form-control"></textarea>
      </div>
      <input type="submit" name='post_comment' class="btn btn-success" value = "Post"/>
    </form>
  </div>
@endif
<div>
@else
404 error
@endif
@endsection