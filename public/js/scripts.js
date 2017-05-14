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
//Will only hide the last instance, not remove it (for business logic reasons)
$('#newCBT').on('click', '.remove', function(e) {

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

//Next button
var nextButton = $('button#CBT-next');
var backButton = $('button#CBT-back');
//Array of the pages within the modal
var pages = [$('div#CBT-page-1'), $('div#CBT-page-2'), $('div#CBT-page-3')];

nextButton.on('click', function(e){

  var currentPage = 0;
  e.preventDefault();
  //Find out what page we're currently on
  $.each(pages, function(index){
    if(!$(this).hasClass('hidden'))
    {
      //Gottcha
      currentPage = index;
      return false;
    }
  });

  //Next page has to be > 1, so unhide back button
  backButton.removeClass('hidden');

  /* Individual page logic here */
  if((currentPage + 1) == 2) //page 3
  {
    page3Logic();
  }

  //So now hide current page, unhide next page
  pages[currentPage].addClass('hidden');
  pages[currentPage + 1].removeClass('hidden');

});


backButton.on('click', function(e){

  var currentPage = 0;
  e.preventDefault();
  //Find out what page we're currently on
  $.each(pages, function(index){
    if(!$(this).hasClass('hidden'))
    {
      //Gottcha
      currentPage = index;
      return false;
    }
  });

  //If is first page, hide back button
  if((currentPage - 1) == 0)
  {
    backButton.addClass('hidden');
  }

  //So now hide current page, unhide next page
  pages[currentPage].addClass('hidden');
  pages[currentPage - 1].removeClass('hidden');

});

//Monitor automatic thought sliders for changes
  $('#newCBT').on("mousemove change", ".automatic-slider", function(e) {

    if($(this).attr('data-output') != null)
    {
      var target = $('#' + $(this).attr('data-output'));
      target.html($(this).val() + '%');
    }

  });

  //On add new automatic thought
  $('#cbt-add-automatic-thought').on('click', function(e)
  {
    addAutomaticThought($(this));
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
