<!DOCTYPE html>
<html>
<head>

<title>Laravel</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="/styles.css">
  

</head>
    
    <body>
    @if(Auth::check())
        @yield('create')
    @endif
    
    @yield('content')
        
        
    <footer>

    </footer>
    
    </body>
    
</html>