@extends('layouts.default')

@section('content')

@if(count($Stream) > 0) <!-- If there are posts to show -->

<div id="stream-wrapper">

@foreach($Stream as $Event) <!-- For each item in stream -->
@foreach($Event as $key => $Post) <!-- For each item in stream -->

<div class="row">
<div class="col-sm-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">

<div class="panel panel-default {{$Post['Type']}}" id="{{$Post['Attributes']['id']}}">

  <div class="panel-heading">
  <h3 class="panel-title">

    <!-- Username Link -->
    <b>
    <a href="{{url('/' . $Post['User']['username'])}}">
    &#64;{{$Post['User']['username']}}
    </a>
    </b>
    @if($key == "App\Post")
    <i class="header-icon material-icons">color_lens</i>
    @endif

    <!-- time and reactions icons -->
    <div class="icon-wrapper">

    <i class="header-icon material-icons">access_time</i>
    <span class="icon-text">
      {{$Post['friendly_time']}}
    </span>
    <i class="header-icon material-icons">person_outline</i>
    <span class="icon-text">
      {{$Post['total_reactions']}}
    </span>
    </div> <!-- Icon wrapper -->

  </h3>
  </div> <!-- Panel Heading -->

<div class="panel-body">

  <!-- Here we need to split between App\Post and App\CBT -->
  @if($key == "App\Post")
 {{$Post['Attributes']['content']}}

 @include('common.reactions')

  @elseif($key == "App\CBT")

  <h1 class="text-center">
    {{$Post['Attributes']['general']}}
    <i class="material-icons">arrow_forward</i>
    {{$Post['Attributes']['general_after']}}
  </h1>

  <p class="text-center">
    {{$Post['Attributes']['situation']}}
  </p>
  <p>
    A bold hippopotamus was standing one day, by the light of the evening star!
  </p>
  <hr>

<div class="row">
  <div class="col-sm-12 col-md-12">
  <div class="automatic_thoughts">
    <h4>Automatic Thoughts</h4>
    <ul class="automatic_thought_list">
      @foreach($Post['Automatic Thoughts'] as $thought)
      <li class="automatic_thought_list">{{$thought['thought']}}</li>
      @endforeach
    </ul>
  </div>

  <div class="rational_thoughts">
    <h4>Rational Thoughts</h4>
    <ul class="rational_thought_list">
      @foreach($Post['Rational Thoughts'] as $thought)
      <li class="rational_thought_list">{{$thought['thought']}}</li>
      @endforeach
    </ul>
  </div>
</div>
</div>

  <div class="chart-area">
  {!! $Post['chart']->render() !!}
  </div>
<hr>
 @include('common.reactions')

  @endif

</div> <!-- Panel Body -->

<div class="panel-footer">
  Comments ({{$Post['total_comments']}})
</div>

</div> <!-- Panel -->


</div> <!-- col -->
</div> <!-- row -->



@endforeach <!-- Foreach Stream Item -->
@endforeach
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
