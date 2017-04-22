/* JS Global Variables */

var page = 1; //The current page, for calculating pagination functions

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
  console.log(url);
  var callback = function(data, callbackObject)
  {
    console.log(data);
    if(data == true)
    {
      item.toggleClass('active');
    }
  }
  var errorCallback = function(data) {}
  var dataType = "JSON";

  ajaxCall(null, url, callback, errorCallback, dataType, method, item);
}
