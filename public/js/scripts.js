$( document ).ready(function() {

//For each reaction button on page
$.each($("div.emotion-box"), function() {

  $(this).click(function(e){
    if($(this).hasClass('create-post'))
    {
      //Not part of a standard reaction (used to create statuses), skip
    }
    else
    {
      e.preventDefault();
      alert("meow");
    }

  });


});
var rangeSliders = [];
var rangeSliderNumbers = [];

for(i = 1; i < 6; i++)
{
  rangeSliders.push($("input[name='emotion_" + i + "_severity']"));
  rangeSliderNumbers.push($("#emotion_" + i + "_severity_number"));
}

$.each(rangeSliders, function(index) {
  $(this).on("mousemove change", function() {
      rangeSliderNumbers[index].html($(this).val());

      if($(this).val() > 0)
      {
        $(this).parent().parent().addClass('active');
      }
      else
      {
        $(this).parent().parent().removeClass('active');
      }

  });
});



// Load more when user scrolls to end of page
window.onscroll = function(ev) {
    if ((window.innerHeight + window.pageYOffset) >= document.body.offsetHeight) {

streamPaination();
    }
};


});
