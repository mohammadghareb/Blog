@extends('layouts.app')
@section('title')
{{ $user->name }}
@endsection
@section('content')
<div >
  <ul class="list-group" >
    <li class="list-group-item" style=" background-color:#f5f8fa;">
      Joined on {{$user->created_at->format('M d,Y \a\t h:i a') }}
    </li>
    <li class="list-group-item panel-body" style=" background-color:#f5f8fa;">
      <table class="table-padding" >
        <style>
          .table-padding td{
            padding: 3px 8px;
          }
        </style>
        <tr>
          <td>Total Posts</td>
          <td> {{$posts_count}}</td>
          @if($author && $posts_count)
          <td><a href="{{ url('/my-all-posts')}}"  class="btn btn-info" >Show All</a></td>
          @endif
        </tr>
        
        
      </table>
    </li>
    <li class="list-group-item" style=" background-color:#f5f8fa;">
      Total Comments {{$comments_count}}
    </li>
  </ul>
</div>
<div class="panel panel-default">
  <div class="panel-heading" style=" background-color:#f5f8fa;"><h4>Posts</h4></div>
  <div class="panel-body" style=" background-color:#f5f8fa;">
    @if(!empty($latest_posts[0]))
    @foreach($latest_posts as $latest_post)
      <p>
        <strong><a href="{{ url('/'.$latest_post->slug) }}">{{ $latest_post->title }}</a></strong>
        <span class="well-sm">On {{ $latest_post->created_at->format('M d,Y \a\t h:i a') }}</span>
      </p>
    @endforeach
    @else
    <p>You have not written any post till now.</p>
    @endif
  </div>
</div>
<div class="panel panel-default">
  <div class="panel-heading" style=" background-color:#f5f8fa;"><h4>Comments</h4></div>
  <div class="list-group">
    @if(!empty($latest_comments[0]))
    @foreach($latest_comments as $latest_comment)
      <div class="list-group-item" style=" background-color:#f5f8fa;">
        <p>{{ $latest_comment->body }}</p>
        <p>On {{ $latest_comment->created_at->format('M d,Y \a\t h:i a') }}</p>
        <p>On post <a href="{{ url('/'.$latest_comment->post->slug) }}">{{ $latest_comment->post->title }}</a></p>
      </div>
    @endforeach
    @else
    <div class="list-group-item" style=" background-color:#f5f8fa;">
      <p>You have not commented till now. Your latest 5 comments will be displayed here</p>
    </div>
    @endif
  </div>
</div>
@endsection