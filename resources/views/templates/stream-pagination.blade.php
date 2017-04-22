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
