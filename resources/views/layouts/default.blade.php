<!DOCTYPE html>
<html>
<head>

<title>Laravel</title>

<meta name="csrf_token" content="{{ csrf_token() }}">

<script src="https://code.jquery.com/jquery-3.1.1.min.js?v=1.0"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script src="/js/functions.js?v=1.17"></script>
<script src="/js/scripts.js?v=1.17"></script>
<script src="/js/charts.js?v=1.1"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="/css/sass/main.css?v=1.912">

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">



</head>

    <body>

      <nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Brand</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="{{url('/stream')}}">Home</a></li>
        <li><a href="{{url('/profile')}}">Profile</a></li>
      </ul>

      <form class="navbar-form navbar-left">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="{{url('/logout')}}">Logout</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

	<div class="row">
	<div class="col-sm-10 col-sm-offset-1">


    @if(Auth::check())
		<div class="row">
		<div class="col-sm-8 col-sm-offset-2">
        @yield('create')
		</div>
		</div>
    @endif

    @yield('content')

	</div> <!-- col-sm-10 offset-1 -->
	</div> <!-- row -->

    <footer>

    </footer>

    </body>

</html>
