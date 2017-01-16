@if(isset($Emotions) && count($Emotions) > 0)

<div class="reaction-wrapper">
@foreach($Emotions as $Emotion)
    <a href="#">
  @if(array_key_exists($Emotion, $Post['Reactions']))
      <div class="emotion-box active">
  @else
  <div class="emotion-box">
  @endif
    {{$Emotion}}</div>
    </a>
@endforeach
</div>

@endif
