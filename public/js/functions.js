/* JS Global Variables */

var page = 1; //The current page, for calculating pagination functions

/*
 * Looks like:
    array[] =
    [
      0 => #id of comments section
      1 => #current pagination
  ]
*/
var commentsPage = new Array(); //Variable for tracking comments pagination on multiple (infinite) posts


/* Generic AJAX handler */
function ajaxCall(data = null, url, callback = function(data){}, errorCallback = function(data){}, dataType = "JSON", method = "POST", callbackObject = null)
{
  //Load CSRF Token Header
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
    }

  });

  if(callback == null)
  {
    callback = function(){}
  }
  if(errorCallback == null)
  {
    errorCallback = function(){}
  }

  //Continue to main function
  $.ajax({
       url: url,
       type: method,
       data: data,
       dataType: dataType,
       error: function(data, callbackObject) {
          errorCallback(data, callbackObject);
       },
       success:function(data, callbackObject)
       {
         callback(data, callbackObject);
       },
});
}

function isAuthenticated(callback = null, errorCallback = null)
{
  var url = "/api/authenticated";
  var callback = function(data){console.log(data);}
  ajaxCall(null, url, callback, errorCallback, "JSON", "GET");
}


function streamPaination(endpoint)
{

  var url = String(window.location);
  var endpoint = url.split("/");
  endpoint = endpoint[endpoint.length - 1];
  //Make sure nothing dodgy at the end (or innocent, i.e., #)
  endpoint = endpoint.replace(/[^\w]/g,'');

  var errorCallback = function(data)
  {
    page = page - 1;
    alert('unknown error');
  }
  var callback = function(data)
  {
    if(data == 'false')
    {
      page = page - 1
    }
    else
    {
      $("#stream-wrapper").append(data);
    }
  }
    //Make call to load more :S
    ajaxCall(null, "/" + endpoint + "/" + (++page), callback, errorCallback, "HTML");
}

function react(item)
{
  //Grab data about item
  var post_id = item.attr('data-post-id');
  var emotion_id = item.attr('data-emotion-id');
  var post_type = item.attr('data-post-type');

  //If item has the active class, is already reacted
  if(item.hasClass("active"))
  {
    var method = "DELETE";
  }
  else
  {
    var method = "PUT";
  }

  //Prepare the call
  var url = 'api/' + post_type + '/' + post_id + '/reaction/' + emotion_id;

  var callback = function(data)
  {
    if(data == true)
    {
      item.toggleClass('active');
    }
  }
  var errorCallback = function(data) {}
  var dataType = "JSON";

  ajaxCall(null, url, callback, errorCallback, dataType, method, item);
}

function createComment(item)
{
  //Grab data about item
  var post_id = item.attr('data-post-id');
  var post_type = item.attr('data-post-type');
  var method = "PUT";

  //Pull the comment
  var data = {'comment': item.val()};

  var commentTable = $("table#comments-" + post_type + "-" + post_id);

  //Prepare the call
  var url = 'api/' + post_type + '/' + post_id + '/comment/';
  var callback = function(data)
  {
    //We need to dynamically add the comment
    commentTable.prepend(data);

    //Update total comments count
    var totalCount = $('span#total-comments-' + post_type + '-' + post_id);
    var text = totalCount.text();
    var number = text.replace(/[()]/g, "");
    console.log(number);

    totalCount.text('(' + (parseInt(number) + 1) + ')');
  }
  var errorCallback = function(data) {}
  var dataType = "HTML";

  //Clear comment box
  item.val('');

  ajaxCall(data, url, callback, errorCallback, dataType, method, item);
}

function loadComments(item)
{
  //Grab data about item
  var post_id = item.attr('data-post-id');
  var post_type = item.attr('data-post-type');
  var commentTableString = "comments-" + post_type + "-" + post_id;
  var commentTable = $("table#" + commentTableString);

  //Count number of existing comments
  var commentsTable = $("table#" + commentTableString + " tr");
  var existingComments = commentsTable.length;

  var method = "GET";
  var url = post_type + '/' + post_id + '/comments/' + existingComments;
  var callback = function(data)
  {
    //We need to dynamically add the comment
    commentTable.append(data);

    //Reassess number of comments to see is < 10
    var newCommentsTable = $("table#" + commentTableString + " tr");
    var newCommentsNumber = newCommentsTable.length;
    if(newCommentsNumber - existingComments < 10)
    {
      //Remove "view more" sticker
      var viewMore = $('a#view-more-comments-' + post_type + '-' + post_id);
      viewMore.addClass('hidden');
    }
  }
  var errorCallback = function(data)
  {
    //Roll back if failed
    commentsPage[arrayIndex][1] = commentsPage[arrayIndex][1] - 1;
  }

  var dataType = "HTML";
  var data = null;
  ajaxCall(data, url, callback, errorCallback, dataType, method, item);

}

/* CBT Login */

function addBeforeEmotion(item)
{
  //Grab table
  var table = $('table#cbt-before-emotions-table tbody');
  //Count number of exiting rows
  var rowCount = $('table#cbt-before-emotions-table > tbody tr').length;

  //Grab existing emotion options
  var emotionList = $('select#list-of-emotions').html();

  //Otherwise, dynamically generate
  if(rowCount < 6)
  {
    //Append new element
    var appendData =
        `
      <tr id="cbt-before-emotions-row-${rowCount + 1}">
        <td>
          <select name="cbt-emotion-list-${rowCount + 1}">
            ${emotionList}
          <select>
        </td>
        <td>
          <input class="emotion-slider" name="cbt-emotion-severity-${rowCount + 1}" data-output="emotion-slider-output-${rowCount + 1}" type="range" min="1" max="5" step="1" value="0">
        </td>
        <td id="emotion-slider-output-${rowCount + 1}">1</td>
        <td>
        <a href="#">
          <i data-target="cbt-before-emotions-row-${rowCount + 1}" class="remove material-icons">delete</i>
        </a>
        </td>
      </tr>
        `;

        table.append(appendData);
    }
  }

  function addAutomaticThought(item)
  {
    //Grab table
    var table = $('table#cbt-automatic-thoughts-table tbody');
    //Count number of exiting rows
    var rowCount = $('table#cbt-automatic-thoughts-table > tbody tr').length;

    if(table.find('tr').hasClass('hidden'))
    {
      //Unhide first instance
      table.find('tr').removeClass('hidden');
    }

    //Otherwise, dynamically generate
    else if(rowCount < 10)
    {
      //Append new element
      var appendData =
          `
        <tr id="cbt-automatic-thoughts-row-${rowCount + 1}">
          <td>
            <textarea id="automatic-thought-${rowCount + 1}" style="width: 100%"></textarea>
          </td>
          <td>
            <input name=automatic-thought-severity-${rowCount + 1}" class="automatic-slider" data-output="automatic-slider-output-${rowCount + 1}" type="range" min="0" max="100" step="5" value="0">          </td>
          </td>
          <td id="automatic-slider-output-${rowCount + 1}" data-type="automatic-thought-belief">
          0%
          </td>
          <td>
          <a href="#">
            <i data-target="cbt-automatic-thoughts-row-${rowCount + 1}" class="remove material-icons">delete</i>
          </a>
          </td>
        </tr>
          `;

      table.append(appendData);
    }

  }

  function page3Logic()
  {

    /*
     * Here we need to grab each automatic thought
     * and display it on the page with its own table.
    */
    //Automatic thoughts table
    var table = $('table#cbt-automatic-thoughts-table > tbody');
    var textAreas = table.find('textarea');
    var thoughtTable = $('div#automatic-thought-table-wrapper');

    //Sorts automatic thoughts into array
    var automaticThoughts = new Array();

    $.each(textAreas, function(index) {
      automaticThoughts.push($(this).val());
    });


    var template;
    for(var i = 0; i < automaticThoughts.length; i++)
    {
      //Now we can mockup the table for page 3
      template =
      `
      <table class="table table-striped" id="automatic-thought-evidence-${i + 1}">

        <thead>
          <tr>
            <td id="automatic-thought-title-${i + 1}">
              ${automaticThoughts[i]}
            </td>
          </tr>
        </thead>

        <tbody id="automatic-thought-evidence-body-${i + 1}">

          <tr id="automatic-thought-evidence-row-${i + 1}-1">
            <td><textarea name="automatic-thought-evidence-text-${i + 1}-1" style="width: 100%;"></textarea></td>
            <td>
              <input type="radio" name="evidence-supportive-${i + 1}-1" value="true">Supports<br>
              <input type="radio" name="evidence-supportive-${i + 1}-1" value="false">Does not Support<br>
            </td>
            <td>
            <a href="#">
              <i data-target="automatic-thought-evidence-row-${i + 1}-1" class="remove material-icons">delete</i>
            </a>
            </td>
          </tr>

        </tbody>

      </table>
      <button data-target="automatic-thought-evidence-body-${i + 1}" class="addAutomaticThoughtEvidence">+</button>
      `;

      if(i == 0)
      {
        //Wipe for first iteration
        thoughtTable.html(template);
      }
      else
      {
        //Otherwise, append
        thoughtTable.append(template);
      }

    }

  }

  function page5Logic()
  {
    /*
     * Here we need to grab each automatic thought
     * and display it on the page with its own table.
    */
    //Automatic thoughts table
    var table = $('table#cbt-automatic-thoughts-table > tbody');
    //Automatic Thoughts
    var textAreas = table.find('textarea');
    //Automatic Thought percentage
    var percentages = table.find('[data-type="automatic-thought-belief"]');

    //Current page table
    var thoughtTable = $('table#automatic-thoughts-revisit tbody');

    //Sorts automatic thoughts into array
    var automaticThoughts = new Array();
    //Sort percentages into array
    var automaticThoughtPercentages = new Array();

    $.each(textAreas, function(index) {
      automaticThoughts.push($(this).val());
    });

    $.each(percentages, function(index) {
      automaticThoughtPercentages.push($(this).html()); //Inner value
    });

    var template;
    for(var i = 0; i < automaticThoughts.length; i++)
    {
      template =
      `
        <tr>
        <td>${automaticThoughts[i]}</td>
        <td>${automaticThoughtPercentages[i]}</td>
        <td>
          <input name="automatic-thought-revist-severity-${i + 1}" class="automatic-slider" data-output="automatic-slider-revist-output-${i + 1}" type="range" min="0" max="100" step="5" value="0">
        </td>
        <td id="automatic-slider-revist-output-${i + 1}">
            0%
        </td>
        </tr>
      `;

      if(i == 0)
      {
        thoughtTable.html(template);
      }
      else
      {
        thoughtTable.append(template);
      }

    }

  }

  function page6Logic()
  {
    var generalRevisit = $('table#general-mood-revisit tbody');
    var emotionsRevisit = $('table#emotions-revisit tbody')

    //Get value of initial general mood
    var emotionSlider = $('input[name="general-mood-slider"]');

    //Now grab the emotions + severities
    var emotionsTable = $('#cbt-before-emotions-table tbody');
    //Count number of rows
    var emotionsRows = emotionsTable.find('tr');
    var rowCount = emotionsRows.length;
    var emotionValues = new Array();

    $.each(emotionsRows, function(index) {
      // 0 => emotion, 1 => severity
      var emotionID = $('select[name="cbt-emotion-list-' + (index + 1) +'"]').val();
      var emotionText = $('select[name="cbt-emotion-list-' + (index + 1) +'"] option[value="' + emotionID + '"]').text();
      var emotionSeverity = $('input[name="cbt-emotion-severity-' + (index + 1) + '"]').val();

      var template =
      `
      <tr>
      <td>${emotionText}</td>
      <td>${emotionSeverity}</td>
      <td><input name="emotion-severity-after-${index + 1}" data-percentage="none" class="automatic-slider" data-output="emotion-severity-after-${index + 1}" type="range" min="0" max="10" step="1" value="${emotionSeverity}"></td>
      <td id="emotion-severity-after-${index + 1}">${emotionSeverity}</td>
      </tr>
      `;
      if(index == 0)
      {
        emotionsRevisit.html(template);
      }
      else
      {
        emotionsRevisit.append(template);
      }
    });

    //Append mood
    var template =
    `
      <tr>
      <td>${emotionSlider.val()}</td>
      <td><input name="general-mood-after-slider" data-percentage="none" class="automatic-slider" data-output="general-mood-after-display" type="range" min="0" max="10" step="1" value="${emotionSlider.val()}"></td>
      <td id="general-mood-after-display">${emotionSlider.val()}</td>
      </tr>
    `;

    generalRevisit.html(template);

  }

  function page7Logic()
  {

  }

  function addAutomaticThoughtEvidence(item)
  {
    var target = $('#' + item.attr('data-target')); //tbody
    //Get automatic thought id form data-target
    var atID = item.attr('data-target').split('-');
    atID = atID[atID.length - 1];

    //Find how many existing rows
    var countRows = target.find('tr').length;

    if(countRows < 7)
    {
      var template =
      `
      <tr id="automatic-thought-evidence-row-${atID}-${countRows + 1}">
        <td><textarea name="automatic-thought-evidence-text-${atID}-${countRows + 1}" style="width: 100%;"></textarea></td>
        <td>
          <input type="radio" name="evidence-supportive-${atID}-${countRows + 1}" value="true">Supports<br>
          <input type="radio" name="evidence-supportive-${atID}-${countRows + 1}" value="false">Does not Support<br>
        </td>
        <td>
        <a href="#">
          <i data-target="automatic-thought-evidence-row-${atID}-${countRows + 1}" class="remove material-icons">delete</i>
        </a>
        </td>
      </tr>
      `;

      target.append(template);
    }

  }

  function addRationalThought(item)
  {
    //Grab table
    var table = $('table#cbt-rational-thoughts-table tbody');
    //Count number of exiting rows
    var rowCount = $('table#cbt-rational-thoughts-table > tbody tr').length;

    if(table.find('tr').hasClass('hidden'))
    {
      //Unhide first instance
      table.find('tr').removeClass('hidden');
    }

    //Otherwise, dynamically generate
    else if(rowCount < 10)
    {
      //Append new element
      var appendData =
          `
        <tr id="cbt-rational-thoughts-row-${rowCount + 1}">
          <td>
            <textarea name="rational-thought-${rowCount + 1}" style="width: 100%"></textarea>
          </td>
          <td>
          <a href="#">
            <i data-target="cbt-rational-thoughts-row-${rowCount + 1}" class="remove material-icons">delete</i>
          </a>
          </td>
        </tr>
          `;

      table.append(appendData);
    }

    }

  function CBTSubmitLogic()
  {
    //This is going to be a long one...
    var searchArea = $('#newCBT');


      //Find stuff
      var dataArray = new Array();
      var test = searchArea.find('textarea, input[type!="radio"], input[type="radio"]:checked, select');
      $.each(test, function(e){
        //Only iterate if disabled
          if(!$(this).is(':disabled'))
          {
            if($(this).attr('name') != null)
            {
              console.log($(this).attr('name') + " => " + $(this).val());
            }
            else
            {
              console.log($(this).attr('id') + " => " + $(this).val());
            }
          }

      });

  }
