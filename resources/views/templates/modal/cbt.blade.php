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
          <textarea name="situation" style="width: 100%"></textarea>
        </div>

      <div class="general_mood_before">
        <h4>How would you rate your overall mood?</h4>
        <table class="table">
          <tr>
            <td>1</td>
            <td><input name="general-mood-slider" type="range" min="0" max="10" step="1" value="0"></td>
            <td>10</td>
          </tr>
        </table>

      </div>

      <div class="before_emotions">

        <select id="list-of-emotions" class="hidden" disabled="disabled">
          @foreach($Emotions as $Emotion)
          <option value="{{$Emotion['id']}}">{{$Emotion['emotion']}}</option>
          @endforeach
        </select>

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
            <tr class="table table-striped" id="cbt-automatic-thoughts-row-1">
              <td>
                <textarea id="automatic-thought-1" style="width: 100%"></textarea>
              </td>

              <td>
                <input name="automatic-thought-severity-1" class="automatic-slider" data-output="automatic-slider-output-1" type="range" min="0" max="100" step="5" value="0">
              </td>

              <td id="automatic-slider-output-1" data-type="automatic-thought-belief">
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
      <div id="automatic-thought-evidence">
        <h4>Evidence</h4>
        <p>What evidence or facts support your automatic thoughts? Do these support your automatic thoughts, or question it?</p>

        <div id="automatic-thought-table-wrapper">

        </div>

    </div> <!-- automatic thought evidence -->
    </div> <!-- CBT page 3 -->

    <div id="CBT-page-4" class="hidden">
      <div id="rational-thoughts">
        <h4>Rational Thoughts</h4>
        <p>Now that you've looked at the facts, what are some alternative thoughts? What would someone else say about this situation? Is my reaction appropiate to the situation?</p>

        <table class="table table-striped tabler-hover" id="cbt-rational-thoughts-table">

          <tbody>
            <tr class="" id="cbt-rational-thoughts-row-1">
              <td>
                <textarea id="rational-thought-1" style="width: 100%"></textarea>
              </td>

              <td>
                <a href="#">
                <i data-target="cbt-rational-thoughts-row-1" class="material-icons remove">delete</i>
                </a>
              </td>
            </tr>

          </tbody>

        </table>
        <button id="cbt-add-rational-thought">+</button>
      </div>

    </div> <!-- CBT page 4 -->

    <div id="CBT-page-5" class="hidden">
      <div id="automatic-thoughts-revisit">
        <h4>Automatic Thoughts Revisit</h4>
        <p>Now that you've looked at the evidence and explored some rational response, how much do you believe your original thoughts?</p>

        <table class="table table-striped" id="automatic-thoughts-revisit">
          <thead>
            <tr>
              <td>Thought</td>
              <td>Before</td>
              <td></td>
              <td>After</td>
            </tr>
          </thead>

          <tbody>
          </tbody>

        </table>
      </div> <!-- automatic-thoughts-revisit -->
    </div> <!-- CBT page 5 -->

    <div id="CBT-page-6" class="hidden">
      <div id="mood-revisit">
        <h4>Mood Revisit</h4>
        <p>Now that you've been through this process, how do you feel?</p>
          <table class="table table-striped" id="general-mood-revisit">

            <thead>
              <tr>
                <td>Before</td>
                <td></td>
                <td>After</td>
              </tr>
            </thead>

            <tbody>
            </tbody>

          </table>

          <table class="table table-striped" id="emotions-revisit">

            <thead>
              <tr>
                <td>Emotion</td>
                <td>Before</td>
                <td></td>
                <td>After</td>
              </tr>
            </thead>

            <tbody>
            </tbody>

          </table>
      </div> <!-- mood revisit -->
    </div> <!-- CBT page 6 -->

    <div id="CBT-page-7" class="hidden">
      <div id="privacy">
        <h4>Your Privacy</h4>
        <p>You can choose what or if you want to share with the community. Keep it to yourself, or tell others what you've accomplished.</p>

        <table class="table table-striped">
          <thead>
          <tr>
            <td>Post as myself</td>
            <td>Post anonymously</td>
            <td>Only visible to you</td>
          </tr>
        </thead>

        <tbody>
          <tr>
            <td><input name="posting" type="radio" checked="checked" value="1"></td>
            <td><input name="posting" type="radio" value="2"></td>
            <td><input name="posting" type="radio" value="0"></td>
          </tr>

        </tbody>
        </table>

        <table class="table table-striped" id="privacy-table">

        <tbody>
          <tr>
            <td>Privacy Level</td>
            <td><input name="privacy" data-percentage="none" class="automatic-slider" data-output="privacy-number" type="range" min="1" max="3" step="1" value="1"></td>
            <td id="privacy-number">1</td>
          </tr>

          <tr id="privacy-include-row">
            <td colspan="3">
              Your share includes:
              <ul id="privacy-includes">
                <li>Your situation</li>
                <li>Your automatic thoughts</li>
                <li>Your rational thoughts</li>
                <li>Your general mood, before and after.</li>
                <li>Your emotional responses, before and after.</li>
              </ul>
            </td>
          </tr>

        </tbody>
        </table>

      </div>
    </div> <!-- CBT page 7 -->

      </div>
      <div class="modal-footer">
        <button type="button" id="CBT-back" class="btn btn-primary hidden">Back</button>
        <button type="button" id="CBT-next" class="btn btn-primary">Next</button>
      </div>
    </div>
  </div>
</div>
