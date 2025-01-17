@extends('layouts.app')

@section('title')

Add New Post

@endsection

@section('content')

<form action="/new-post" method="post" enctype="multipart/form-data">

@csrf
<div class="form-group">

<input required="required" value="{{ old('title') }}" placeholder="Enter title here" type="text" name = "title"class="form-control" />

</div>

<div class="form-group">
<textarea name='body'class="form-control">{{ old('body') }}</textarea>
<br>
<input  type="file" id="cover_image"  name="cover_image" >
<br>
<input type="submit" name='publish' class="btn btn-success" value = "Publish"/>

</form>

@endsection