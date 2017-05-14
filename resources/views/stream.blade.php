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

<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#newCBT">
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
<div class="modal fade" id="newCBT" tabindex="-1" role="dialog" aria-labelledby="newCBT-Label">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New CBT Record</h4>
      </div>
      <div class="modal-body">

        <div id="CBT-page-1">

        <div class="situation">
          <h4>Situation</h4>
          <p>What happened? When and where did it happen? What else was going on? Was it a situation that you often find yourself in? Who were you with?</p>
          <textarea style="width: 100%"></textarea>
        </div>

      <div class="general_mood_before">
        <h4>How would you rate your overall mood?</h4>
        <table class="table">
          <tr>
            <td>1</td>
            <td><input type="range" min="0" max="10" step="1" value="0"></td>
            <td>10</td>
          </tr>
        </table>

      </div>

      <div class="before_emotions">
        <h4>Are you feeling any specific emotions?</h4>
        <table class="table table-striped tabler-hover" id="cbt-before-emotions-table">

          <tbody>
            <tr class="hidden" id="cbt-before-emotions-row-1">
              <td>
                <select name="cbt-emotion-list-1">
                  @foreach($Emotions as $Emotion)
                  <option value="{{$Emotion['id']}}">{{$Emotion['emotion']}}</option>
                  @endforeach
                </select>
              </td>
              <td><input class="emotion-slider" data-output="emotion-slider-output-1" name="cbt-emotion-severity-1" type="range" min="1" max="5" step="1" value="0"></td>
              <td id="emotion-slider-output-1">1</td>
              <td>
                <a href="#">
                <i data-target="cbt-before-emotions-row-1" class="material-icons remove">delete</i>
                </a>
              </td>
            </tr>

          </tbody>

        </table>
        <button id="cbt_add_before_emotion">+</button>
      </div>

    </div> <!-- CBT page 1 -->

    <div id="CBT-page-2" class="hidden">

      <div class="situation">
        <h4>Automatic Thoughts</h4>
        <p>Add one thougth per line. What was going through your mind at the time? Did anything in particular make you feel this way? What is the worse that could happen? How much do you believe each thought?</p>
        <table class="table table-striped tabler-hover" id="cbt-automatic-thoughts-table">

          <tbody>
            <tr class="" id="cbt-automatic-thoughts-row-1">
              <td>
                <textarea id="automatic-thought-1" style="width: 100%"></textarea>
              </td>

              <td>
                <input name="automatic-thought-severity-1" class="automatic-slider" data-output="automatic-slider-output-1" type="range" min="0" max="100" step="5" value="0">
              </td>

              <td id="automatic-slider-output-1">
                  0%
              </td>

              <td>
                <a href="#">
                <i data-target="cbt-automatic-thoughts-row-1" class="material-icons remove">delete</i>
                </a>
              </td>
            </tr>

          </tbody>

        </table>
        <button id="cbt-add-automatic-thought">+</button>
      </div>

    </div> <!-- CBT Page 2 -->

    <div id="CBT-page-3" class="hidden">
      dfgdfgdfg
    </div> <!-- CBT page 3 -->


      </div>
      <div class="modal-footer">
        <button type="button" id="CBT-back" class="btn btn-primary hidden">Back</button>
        <button type="button" id="CBT-next" class="btn btn-primary">Next</button>
      </div>
    </div>
  </div>
</div>

@endsection
