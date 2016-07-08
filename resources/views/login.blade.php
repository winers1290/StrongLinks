@extends('layouts.default')

@section('content')

@include('common.errors')


<form action="{{url('/')}}" method="POST">
{{ csrf_field() }}
<input type="text" placeholder="Username" name="username">
<input type="password" placeholder="Password" name="password">
<input type="submit" value="Submit">
</form>

@endsection