function ajaxCall(data = null, url, callback, errorCallback, dataType = "JSON")
{
  $.ajax({
       url: url,
       type: "POST",
       data: { _token: $('[name="csrf_token"]').attr('content') },
       dataType: dataType,
       error: function() {
          errorCallback(data);
       },
       success:function(data)
       {
         callback(data);
       },
});
}

//On load variable
var page = 1;
function streamPaination()
{
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
      console.log(data);
      $("#stream-wrapper").append(data);
    }
  }
    //Make call to load more :S
    ajaxCall(null, "/stream/" + ++page, callback, errorCallback, "HTML");
}
