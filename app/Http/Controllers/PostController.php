<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Posts;
use App\Http\Requests\PostFormRequest;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{

  public function index()
  {
    $posts = Posts::where('active', 1)->orderBy('created_at', 'desc')->paginate(5);
    $title = 'Posts';
    return view('home')->withPosts($posts)->withTitle($title);
  }

  public function create(Request $request)
  {
    
    if ($request->user()->can_post()) {
      return view('posts.create');
    } else {
      return redirect('/')->withErrors('You have not sufficient permissions for writing post');
    }
  }

  public function store(PostFormRequest $request)
  {
    if ($request->hasFile('cover_image')) {
      $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
      $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
      $extension = $request->file('cover_image')->getClientOriginalExtension();
      $fileNameToStore = $filename . '_' . time() . '.' . $extension;
      $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
    } else {
      $fileNameToStore = 'noimage.jpg';
    }

    $post = new Posts();
    $post->title = $request->get('title');
    $post->body = $request->get('body');
    $post->slug = Str::slug($post->title);
    $post->cover_image = $fileNameToStore;

    $duplicate = Posts::where('slug', $post->slug)->first();
    if ($duplicate) {
      return redirect('new-post')->withErrors('Title already exists.')->withInput();
    }

    $post->author_id = $request->user()->id;
    $post->active = 1;
    $message = 'Post published successfully';
    $post->save();
    return redirect('edit/' . $post->slug)->withMessage($message);
  }

  public function show($slug)
  {
    $post = Posts::where('slug', $slug)->first();
    if (!$post) {
      return redirect('/')->withErrors('requested page not found');
    }
    $comments = $post->comments;
    return view('posts.show')->withPost($post)->withComments($comments);
  }

  public function edit(Request $request, $slug)
  {
    $post = Posts::where('slug', $slug)->first();
    if ($post && ($request->user()->id == $post->author_id || $request->user()->is_admin()))
      return view('posts.edit')->with('post', $post);
    return redirect('/')->withErrors('you have not sufficient permissions');
  }

  public function update(Request $request)
  {
    $post_id = $request->input('post_id');
    $post = Posts::find($post_id);

    if ($request->hasFile('cover_image')) {
      $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
      $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
      $extension = $request->file('cover_image')->getClientOriginalExtension();
      $fileNameToStore = $filename . '_' . time() . '.' . $extension;
      $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
      Storage::delete('public/cover_images/' . $post->cover_image);
      $post->cover_image = $fileNameToStore;
    }

    if ($post && ($post->author_id == $request->user()->id || $request->user()->is_admin())) {
      $title = $request->input('title');
      $slug = Str::slug($title);
      $duplicate = Posts::where('slug', $slug)->first();
      if ($duplicate) {
        if ($duplicate->id != $post_id) {
          return redirect('edit/' . $post->slug)->withErrors('Title already exists.')->withInput();
        } else {
          $post->slug = $slug;
        }
      }
      $post->title = $title;
      $post->body = $request->input('body');

      $post->active = 1;
      $message = 'Post updated successfully';
      $landing = $post->slug;

      $post->save();
      return redirect($landing)->withMessage($message);
    } else {
      return redirect('/')->withErrors('you have not sufficient permissions');
    }
  }

  public function destroy(Request $request, $id)
  {
    $post = Posts::find($id);
    if ($post->cover_image != 'noimage.jpg') {
      Storage::delete('public/cover_images/' . $post->cover_image);
    }
    if ($post  && ($post->author_id == $request->user()->id || $request->user()->is_admin())) {
      $post->delete();
      $data['message'] = 'Post deleted Successfully';
    } else {
      $data['errors'] = 'Invalid Operation. You have not sufficient permissions';
    }
    return redirect('/')->with($data);
  }
}
