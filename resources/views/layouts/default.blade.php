<!DOCTYPE html>
<html>
<head>

<title>Laravel</title>

<script src="https://code.jquery.com/jquery-3.1.1.min.js?v=1.0"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script src="/js/scripts.js"></script>
<script src="/js/charts.js?v=1.1"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="/css/main.css?v=1.911">

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">



</head>

    <body>

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
