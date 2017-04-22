@if(isset($Emotions) && count($Emotions) > 0)

<div class="reaction-wrapper">
@foreach($Emotions as $Emotion)
    <a href="#">
      @if(count($Post['Reactions']) > 0 && array_key_exists($Emotion['emotion'], $Post['Reactions']))

      <div class="emotion-box reaction active {{$Emotion['emotion']}} hoverable" data-post-type="{{$Post['Type']}}" data-emotion="{{strtolower($Emotion['emotion'])}}" data-post-id="{{$Post['Attributes']['id']}}" data-emotion-id="{{$Emotion['id']}}">

      @else
      <div class="emotion-box reaction {{$Emotion['emotion']}} hoverable" data-post-type="{{strtolower($Post['Type'])}}" data-emotion="{{strtolower($Emotion['emotion'])}}" data-post-id="{{$Post['Attributes']['id']}}" data-emotion-id="{{$Emotion['id']}}">
        @endif

    {{$Emotion['emotion']}}</div>
    </a>
@endforeach
</div>

@endif
