$( document ).ready(function() {

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


window.onscroll = function(ev) {
    if ((window.innerHeight + window.pageYOffset) >= document.body.offsetHeight) {
      streamPaination();
    }
};

/* reaction click trigger */
  $("body").on("click", ".reaction", function(e){
    e.preventDefault();
    react($(this));
  });

/* Comment enter trigger */
$("body").on("keypress", ".add-comment", function(e){
  if(e.which == 13 && !e.shiftKey)
  {
    e.preventDefault();
    createComment($(this));
  }
});

/* View more comments enter trigger */
$("body").on("click", ".view-more-comments", function(e){
    e.preventDefault();
    loadComments($(this));
});



});
