@extends('layouts.app')
@section('title')
Edit Post
@endsection
@section('content')
<form method="post" action='{{ url("/update") }}' enctype="multipart/form-data">
  @csrf
  <input type="hidden" name="post_id" value="{{ $post->id }}{{ old('post_id') }}">
  <div class="form-group">
    <input required="required" placeholder="Enter title here" type="text" name = "title" class="form-control" value="@if(!old('title')){{$post->title}}@endif{{ old('title') }}"/>
  </div>
  <div class="form-group">
    <textarea name='body'class="form-control">
      @if(!old('body'))
      {!! $post->body !!}
      @endif
      {!! old('body') !!}
    </textarea>
  </div>

  <input  type="file" id="cover_image"  name="cover_image" >
<br>
  @if($post->active == '1')
  <input type="submit" name='publish' class="btn btn-success" value = "Update"/>
  @endif
  <a href="{{  url('delete/'.$post->id.'?_token='.csrf_token()) }}" class="btn btn-danger">Delete</a>
</form>
@endsection