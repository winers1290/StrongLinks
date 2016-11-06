@extends('layouts.default')

@section('content')

<div class="row">
<h1>Welcome!</h1>
</div>

@if(count($Stream) > 0) <!-- If there are posts to show -->
	
@foreach($Stream as $key => $Event) <!-- For each item in stream -->

<div class="row">
<div class="col-sm-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">

<div class="panel panel-default">
<div class="panel-body">

@if(array_key_exists("Post", $Event)) <!-- if the item is a regular post -->
<div class="col-md-12">
<div>
    <b><a href="{{url('/')}}/{{{$Event['Post']['User']['Username']}}}">&#64{{$Event['Post']['User']['Username']}}</a></b>
    
	<p>
		<span>{{$Event['Post']['friendly_time']}}</span>
		
		<!-- list emotions -->
		@if(isset($Event['Post']['Emotions']))
		@foreach($Event['Post']['Emotions'] as $Emotion) <!-- For each emotion on post -->
			<span class="post-emotion {{$Emotion['Emotion']['emotion']}}-{{$Emotion['severity']}}">
			{{$Emotion['Emotion']['emotion']}}
			@if(!($loop->last))
				&nbsp;
			@endif;
			</span>
		@endforeach 
		@endif
		<!-- post emotions end -->
	</p>

	<hr>
    


    @if(isset($Event['Post']['Reactions']))
    @foreach($Event['Post']['Reactions'] as $Reaction_em)   
        @foreach($Reaction_em as $Reaction)
        <p>Reaction: &#64{{$Reaction['User']['Username']}} Emotion: {{$Reaction['Emotion']['emotion']}}</p>
        @endforeach
    @endforeach
    @endif
    
    
    @foreach($Emotions as $emotion)
        
        @if(isset($Event['Post']['Reactions']) && isset($Event['Post']['Reactions'][$emotion]))
        @foreach($Event['Post']['Reactions'][$emotion] as $event)
            @if($event['user_id'] == Auth::id())
            <span><a style="color:red" href="{{url('/')}}/{{$Event['Post']['id']}}">{{$emotion}}</a></span>
            @else
            <span ><a style="color:green" href="{{url('/')}}/{{$Event['Post']['id']}}">{{$emotion}}</a></span>   
            @endif
        @endforeach
        
        @else
            <span><a style="color:green" href="{{url('/')}}/{{$Event['Post']['id']}}">{{$emotion}}</a></span>
        @endif
        
    @endforeach


    <p>{{$Event['Post']['content']}}</p>
	
	<p>	
	<i class="material-icons">comment</i>
		<span>{{$Event['Post']['total_comments']}}</span>
		
    <i class="material-icons">link</i>
		<span>{{$Event['Post']['total_reactions']}}</span>
	</p>
	
</div>


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

@else <!-- else, if it is a CBT stream event -->
mddsfsdf

@endif <!-- if(count($Stream) > 0) -->

</div> <!-- Panel body -->
</div> <!-- Panel -->

</div> <!-- col-sm-12 col-md-8 md-offset-2 col-lg-6 col-lg-offet-3 -->
</div> <!-- row -->

@endforeach <!-- Foreach Stream Item -->



<p><b>View more posts</b></p>

@else
no more posts
@endif

<a href="{{url('/logout')}}">Logout</a>
@endsection

@section('create')

@include('common.errors')

<form action="{{url('/create')}}" method="POST">
{{ csrf_field() }}
<textarea class="create-box" placeholder="Tell us something..." name="content"></textarea>
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

