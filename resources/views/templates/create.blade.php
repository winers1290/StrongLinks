@include('common.errors')


<form action="{{url('/create')}}" method="POST">
{{ csrf_field() }}

<div class="row">
<div class="col col-md-6 offset-md-2 col-sm-12">
  <div class="form-group">
  <textarea name="content" placeholder="Tell us something..." class="form-control" id="exampleTextarea" rows="3"></textarea>
  <input type="submit" class="btn btn-primary" name="submit" value="Submit" class="create-box">
  </div>

</div> <!-- Create wrapper -->
<div class="col-md-2">
  <input type="submit" class="btn btn-primary" value="Tap and Hold" class="create-box">
</div>
</div> <!-- row -->




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

<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#newCBT">
  New CBT Record
</button>


</form>
