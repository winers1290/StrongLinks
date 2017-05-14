@extends('layouts.default')

@section('content')

@if(count($Stream) > 0) <!-- If there are posts to show -->

<div id="stream-wrapper">

@include('templates.stream-pagination')

</div> <!-- stream-wrapper -->
@endif <!-- if(count($Stream) > 0) -->


@endsection





@section('create')

@include('common.errors')

<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#newCBT-page1">
  New CBT Record
</button>

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

@section('modals')

<!-- Modal -->
<div class="modal fade" id="newCBT-page1" tabindex="-1" role="dialog" aria-labelledby="newCBT-page1-Label">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New CBT Record</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Next</button>
      </div>
    </div>
  </div>
</div>

@endsection
