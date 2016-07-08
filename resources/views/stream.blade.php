@extends('layouts.default')

@section('content')

<h1>Welcome!</h1>

@if(count($Stream) > 0)
@foreach($Stream as $Event) <!-- For each post -->
<div class="col-md-12">
<p>
    <b><a href="{{url('/')}}/{{{$Event['Post']['User']['Username']}}}">&#64{{$Event['Post']['User']['Username']}}</a></b>
    <i>Comments: {{$Event['Post']['total_comments']}}</i>
    <i>Reactions: {{$Event['Post']['total_reactions']}}</i>
    <i>Created: {{$Event['Post']['friendly_time']}}</i>
    @if(isset($Event['Post']['Emotions']))
    @foreach($Event['Post']['Emotions'] as $Emotion) <!-- For each emotion on post -->
    <p>Emotion: {{$Emotion['Emotion']['emotion']}} Severity: {{$Emotion['severity']}}</p>
    @endforeach 
    @endif

    @if(isset($Event['Post']['Reactions']))
    @foreach($Event['Post']['Reactions'] as $Reaction)
    <p>Reaction: &#64{{$Reaction['User']['Username']}} Emotion: {{$Reaction['Emotion']['emotion']}}</p>
    @endforeach
    @endif

    <p>{{$Event['Post']['content']}}</p>
</p>


@if(isset($Event['Post']['Comments']))
@foreach($Event['Post']['Comments'] as $Comment)
<div class="col-md-10">
<p>
<a href="{{url('/')}}/{{$Comment['User']['Username']}}">
&#64{{$Comment['User']['Username']}} 
</a>
Replies: {{$Comment['total_replies']}} Created: {{$Comment['friendly_time']}}
<br>
{{$Comment['comment']}}
</p>
</div>



@if(isset($Comment['Replies']))
@foreach($Comment['Replies'] as $Reply)
<div class="col-md-8 col-md-offset-1">
<p>
<a href="{{url('/')}}/{{$Reply['User']['Username']}}">
&#64{{$Reply['User']['Username']}}
</a>
 Created: {{$Reply['friendly_time']}}
<br>
{{$Reply['comment']}}
</div>
@endforeach
@endif


@endforeach
@endif



<div class="col-md-10">
@if($Event['Post']['total_comments'] > 10)
View more comments <b>({{$Event['Post']['total_comments'] - 10}})</b>
@endif
</div>
</div>

@endforeach

<p><b>View more posts</b></p>

@else
no more posts
@endif

<a href="{{url('/logout')}}">Logout</a>
@endsection

@section('create')
<form action="{{url('/create')}}" method="POST">
{{ csrf_field() }}
<textarea class="create-box" placeholder="Tell us something..."></textarea>
<br>
<input type="submit" name="submit" value="Submit" class="create-box">

 <select class="create-box" name="emotion_one">
    <option value="Blank"></option>
    @foreach($Emotions as $Emotion)
    <option value="{{$Emotion}}">{{$Emotion}}</option>
    @endforeach
</select>
<input type="text" name="emotion_one_severity" placeholder="0" class="create-box">

 <select class="create-box" name="emotion_two">
    <option value="Blank"></option>
    @foreach($Emotions as $Emotion)
    <option value="{{$Emotion}}">{{$Emotion}}</option>
    @endforeach
</select>
<input type="text" name="emotion_two_severity" placeholder="0" class="create-box">

 <select class="create-box" name="emotion_three">
    <option value="Blank"></option>
    @foreach($Emotions as $Emotion)
    <option value="{{$Emotion}}">{{$Emotion}}</option>
    @endforeach
</select>
<input type="text" name="emotion_three_severity" placeholder="0" class="create-box">

</form>


@endsection