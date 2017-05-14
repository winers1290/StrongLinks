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
  }
  var errorCallback = function(data)
  {
    //Roll back if failed
    console.log(arrayIndex);
    commentsPage[arrayIndex][1] = commentsPage[arrayIndex][1] - 1;
  }

  var dataType = "HTML";
  var data = null;
  ajaxCall(data, url, callback, errorCallback, dataType, method, item);

}
