@extends('layouts.default')

@section('content')

@if(count($Stream) > 0) <!-- If there are posts to show -->

<div id="stream-wrapper">

@include('templates.stream-pagination')

</div> <!-- stream-wrapper -->
@endif <!-- if(count($Stream) > 0) -->

<p><b>View more posts</b></p>


<a href="{{url('/logout')}}">Logout</a>
@endsection





@section('create')

@include('common.errors')

<form action="{{url('/create')}}" method="POST">
{{ csrf_field() }}
<div class="panel panel-default">

<div class="panel-body">
  <textarea class="create-box" placeholder="Tell us something..." name="content"></textarea>
  <input type="submit" name="submit" value="Submit" class="create-box">

</div> <!-- panel body -->

<div class="panel-footer">

  @if(isset($Emotions) && count($Emotions) > 0)

  <div class="reaction-wrapper">
  @foreach($Emotions as $Emotion)
        <div class="emotion-box create-post {{$Emotion['emotion']}}">
          {{$Emotion['emotion']}}
          <div class="dropdown-content">
            <input type="hidden" name="emotion_{{$loop->iteration}}" value="{{$Emotion['emotion']}}">
            <input type="range" min="0" max="5" step="1" value="0" name="emotion_{{$loop->iteration}}_severity" placeholder="0" class="create-box">
            <div id="emotion_{{$loop->iteration}}_severity_number">
              0
            </div>
          </div> <!-- dropdown-content -->
        </div> <!-- Emotion-Box -->
  @endforeach
</div> <!-- Reaction-Wrapper -->

  @endif





</div> <!-- panel-footer -->

</div> <!--panel -->




</form>


@endsection
