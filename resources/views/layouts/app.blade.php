<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blog </title>
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="{{ asset('js/blog.js') }}" defer></script>
  </head>
  <body>
    <nav class="navbar navbar-inverse">
      <div class="container">
          <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle Navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li>
              <a href="{{ url('/') }}">Home</a>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            @if (Auth::guest())
            <li>
              <a href="{{ url('/auth/login') }}">Login</a>
            </li>
            <li>
              <a href="{{ url('/auth/register') }}">Register</a>
            </li>
            @else

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
              <!-- Left Side Of Navbar -->
              <ul class="nav navbar-nav">
                  &nbsp;
              </ul>
  
              <ul class="nav navbar-nav">
                @if (Auth::user()->can_post())
                <li><a href="{{ url('/new-post') }}">Add new post</a></li>
                <li><a href="{{ url('/user/'.Auth::id().'/posts') }}">My Posts</a></li>
                @endif
                <li><a href="{{ url('/user/'.Auth::id()) }}">My Profile</a></li>
                <li><a href="{{ url('/logout') }}">Logout</a></li>
              </ul>

            @endif
          </ul>
        </div>
      </div>
    </nav>
    {{-- background-color:yellow;" --}}
    <div class="container"  style = "position:relative;  top:-21px; ">
      @if (Session::has('message'))
      <div class="flash alert-info">
        <p class="panel-body">
          {{ Session::get('message') }}
        </p>
      </div>
      @endif
      @if ($errors->any())
      <div class='flash alert-danger'>
        <ul class="panel-body">
          @foreach ( $errors->all() as $error )
          <li>
            {{ $error }}
          </li>
          @endforeach
        </ul>
      </div>
      @endif
     
      @if (request()->route()->named('home') || request()->route()->named('New_Home') )
      <div id="myCarousel" class="carousel slide" > 
   <ul class="carousel-indicators">
     <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
     <li data-target="#myCarousel" data-slide-to="1"></li>
     <li data-target="#myCarousel" data-slide-to="2"></li>
   </ul>
   <div class="carousel-inner">
     <div class="active item" > 
       <img width="100%" height="90%"  src="storage/cover_images/test12.jpg" alt="Responsive image">
     </div> 
     <div class="item">
       <img width="100%" height="90%"  src="storage/cover_images/test2.jpg" alt="Responsive image">
     </div> 
     <div class="item"> 
       <img  width="100%" height="90%"   src="storage/cover_images/test1.jpg"  alt="Responsive image">
     </div> 
   </div> 
   <div class="carousel-arrow">
     <a data-slide="prev" href="#myCarousel" class="left carousel-control">
       <i class="fa fa-angle-left"></i>
     </a>
     <a data-slide="next" href="#myCarousel" class="right carousel-control">
       <i class="fa fa-angle-right"></i>
     </a>
   </div>
   </div>  
 @endif
      <br>  
      <div class="row">
        <div class="col-md-10 col-md-offset-1" style=" background-color:#f5f8fa;">
          <div class="panel panel-default" style=" background-color:#f5f8fa;">

            <div class="panel-heading" style=" background-color:#f5f8fa;">
              <h2>@yield('title')</h2>
              @yield('title-meta')
            </div>
            <div class="panel-body">
              @yield('content')
            </div>
          </div>
        </div>
      </div>
   
    </div>
    <!-- Scripts -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
  </body>
</html>