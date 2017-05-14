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

/* CBT  */

//On add new before emotion
$('#cbt_add_before_emotion').on('click', function(e)
{
  addBeforeEmotion($(this));
});

//Monitor emotion sliders for changes
  $('#newCBT').on("mousemove change", ".emotion-slider", function(e) {

    if($(this).attr('data-output') != null)
    {
      var target = $('#' + $(this).attr('data-output'));
      target.html($(this).val());
    }

  });

//Monitor delete button for clicks
$('#newCBT').on('click', '.remove-emotion', function(e) {

  if($(this).attr('data-target') != null)
  {
    var target = $('#' + $(this).attr('data-target'));
    var id = target.attr('id');
    var numberArray = id.split('-');
    var number = numberArray[numberArray.length - 1];
    if(number == 1)
    {
      target.addClass('hidden');
    }
    else
    {
      target.remove();
    }

  }

});


/* CBT sliders end */


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
