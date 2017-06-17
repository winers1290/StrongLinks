<!DOCTYPE html>
<html lang="en">
<head>

<title>Laravel</title>

<meta name="csrf_token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0">



<script src="https://code.jquery.com/jquery-3.1.1.min.js?v=1.0"></script>


<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

<script src="/js/functions.js?v=1.25"></script>

<script src="{{asset('/js/hammer.min.js')}}"></script>
<script src="{{asset('/js/jquery.hammer.js')}}"></script>
<script src="{{asset('/js/jquery.knob.min.js')}}"></script>
<script src="/js/scripts.js?v=1.26"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<link rel="stylesheet" href="/css/sass/main.css?v=2.04">

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

{!! Charts::assets() !!}

</head>

<body>
<div class="page">

    <!-- Main Navigation Element -->
    <nav class="navbar navbar-toggleable-md navbar-light bg-faded fixed-top">

      <!-- Mobile/Tablet Responsive Dropdown menu -->
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Mobile/Tablet Responsive Dropdown menu -->

      <!-- Brand -->
      <a class="navbar-brand" href="#">Navbar</a>
      <!-- Brand -->

      <!-- Nav links -->
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-item nav-link" href="{{url('/stream')}}">Home <span class="sr-only">(current)</span></a>
          <a class="nav-item nav-link" href="{{url('/profile')}}">Profile</a>
          <!-- User Dropdown -->
          <div class="nav-item dropdown hidden-md-below">
            <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              User
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="{{url('/logout')}}">Logout</a>
            </div>
          </div>
          <!-- User Dropdown -->
          </div>
      </div> <!-- collapse navbar-collapse -->
      <!-- Nav links -->
    </nav>
    <!-- Main Navigation Element -->

@hasSection('beforeContainer')
  @yield('beforeContainer')
@endif


<div id="page-container" class="container">

@if(Auth::check())
<!-- The main post creation element -->

@yield('create')

<!-- The main post creation element -->
@endif

<!-- the page content -->
@yield('content')
<!-- the page content -->

</div> <!-- page container -->

<!-- page modals start here -->
@yield('modals')
<!-- page modals end here -->


<footer>

</footer>
</div> <!-- page -->
</body>

</html>
