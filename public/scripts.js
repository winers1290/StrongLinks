$( document ).ready(function() {

//For each reaction button on page
$.each($("div.emotion-box"), function() {

  $(this).click(function(e){

    e.preventDefault();
    alert("meow");
  });


});

// Load more when user scrolls to end of page
$(window).scroll(function () {
  var nearToBottom = 100;
  if ($(window).scrollTop() + $(window).height() > $(document).height() - nearToBottom)
  {
    alert("end of page :(");
  }
});


});
