@extends('layouts.default')

@section('content')

<div class="row">
<h1>Welcome!</h1>
</div>

@if(count($Stream) > 0) <!-- If there are posts to show -->

@foreach($Stream as $key => $Event) <!-- For each item in stream -->

<div class="row">
<div class="col-sm-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">

<div class="panel panel-default post" id="post-{{$Event['App\Post']['Attributes']['id']}}">
<div class="panel-body">

@if(array_key_exists("App\Post", $Event)) <!-- Post model not CBT -->

<div class="col-md-12">
<!-- Panel Header -->
<div>
  <!-- Username -->
  <b><a href="{{url('/')}}/{{{$Event['App\Post']['User']['username']}}}">
    &#64;{{$Event['App\Post']['User']['username']}}
  </a></b>
  <!-- Username -->
  <p>
		<span>{{$Event['App\Post']['friendly_time']}} | </span>
    <i class="material-icons">link</i>
		<span>{{$Event['App\Post']['total_reactions']}}</span>

		<!-- list emotions -->
		@if(isset($Event['App\Post']['Emotions']))
		@foreach($Event['App\Post']['Emotions'] as $Emotion) <!-- For each emotion on post -->
			<span class="post-emotion {{$Emotion['emotion']}} severity-{{$Emotion['severity']}}">
			@if(!($loop->last))
				&nbsp;
			@endif
			{{$Emotion['emotion']}}
			</span>
		@endforeach
		@endif
		<!-- post emotions end -->
	</p>

	<hr>
<!-- Panel Header -->
@endif



@if(array_key_exists("App\Post", $Event)) <!-- if the item is a regular post -->







    @if(isset($Event['App\Post']['Reactions']))
    @foreach($Event['App\Post']['Reactions'] as $Reaction_em)
        @foreach($Reaction_em as $Reaction)
        <p>Reaction: &#64;{{$Reaction['User']['username']}} Emotion: {{$Reaction['Emotion']['emotion']}}</p>
        @endforeach
    @endforeach
    @endif





    <p>{{$Event['App\Post']['content']}}</p>

	<div class="reaction-wrapper">
    @foreach($Emotions as $emotion)


        @if(isset($Event['App\Post']['Reactions'][$emotion]))
        @foreach($Event['App\Post']['Reactions'][$emotion] as $event)

				<?php $values[$emotion][] = $event['user_id']; ?>


        @endforeach
				@if(in_array(Auth::id(), $values[$emotion]))
					<a href="#"><div class="emotion-box post-{{$Event['App\Post']['Attributes']['id']}} {{$emotion}} active">{{$emotion}}</div></a>
				@else
					<a href="#"><div class="emotion-box post-{{$Event['App\Post']['Attributes']['id']}} {{$emotion}}">{{$emotion}}</div></a>
				@endif;
				<?php $values = null; ?>

        @else
            <a href="#"><div class="emotion-box post-{{$Event['App\Post']['Attributes']['id']}} {{$emotion}}">{{$emotion}}</div></a>
        @endif

    @endforeach


	</div> <!-- reaction-wrapper -->

	<hr>

	<p>




	</p>

</div>

<div class="panel-group" id="comments-wrapper-{{$Event['App\Post']['Attributes']['id']}}" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingThree">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#comments-{{$Event['App\Post']['Attributes']['id']}}" href="#comments-{{$Event['App\Post']['Attributes']['id']}}" aria-expanded="false" aria-controls="comments-{{$Event['App\Post']['Attributes']['id']}}">
          <i class="material-icons">comment</i>Comments <span>({{$Event['App\Post']['total_comments']}})</span>
        </a>
      </h4>
    </div>

	<div id="comments-{{$Event['App\Post']['id']}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
      <div class="panel-body">

		@if(isset($Event['App\Post']['Comments']))
		@foreach($Event['App\Post']['Comments'] as $Comment)
		<div class="col-md-10">
		<p>
		<a href="{{url('/')}}/{{$Comment['User']['username']}}">
		&#64;{{$Comment['User']['username']}}
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
		<a href="{{url('/')}}/{{$Reply['User']['username']}}">
		&#64;{{$Reply['User']['username']}}
		</a>
		 Created: {{$Reply['friendly_time']}}
		<br>
		{{$Reply['comment']}}
		</div>
		@endforeach
		@endif


		@endforeach
		@endif


      </div>
    </div>

  </div>
</div>





<div class="col-md-10">
@if($Event['App\Post']['total_comments'] > 10)
View more comments <b>({{$Event['App\Post']['total_comments'] - 10}})</b>
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
