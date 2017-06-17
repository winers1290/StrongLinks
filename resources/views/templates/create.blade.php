@include('common.errors')

<div class="row">

<div class="col col-md-6 offset-md-3 col-sm-12">
<div class="card create-post-wrapper">

  <div class="card-header">
    Create a Post | Launch Thought Record | How are you Feeling?
  </div> <!-- card-header -->

  <div class="card-block">
    <textarea name="content" placeholder="Tell us something..." class="form-control post-entry autoExpand" rows="3"></textarea>
  </div> <!-- card-block -->

</div> <!-- card -->

</div> <!-- col col-md-6 offset-md-3 col-sm-12 -->
</div> <!-- row -->


<div class="row">
<div class="col col-md-8 offset-md-2 col-sm-12">
<div class="emotions-container">

  @if(isset($Emotions) && count($Emotions) > 0)
    @foreach($Emotions as $Emotion)
    <input type="text"
      name="{{$Emotion['emotion']}}_severity"
      value="0"
      data-displayInput="false" 
      data-bgColor="#d0d0d0"
      data-min="0" data-max="5"
      class="dial post-emotions {{$Emotion['emotion']}}"
    >
    @endforeach
  @endif

</div>
</div>
</div>






<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#newCBT">
  New CBT Record
</button>
