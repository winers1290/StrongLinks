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

    target.remove();
  }

});

//Next button
var nextButton = $('button#CBT-next');
var backButton = $('button#CBT-back');
//Array of the pages within the modal
var pages = [$('div#CBT-page-1'), $('div#CBT-page-2'), $('div#CBT-page-3'),
$('div#CBT-page-4'), $('div#CBT-page-5'), $('div#CBT-page-6'), $('div#CBT-page-7')];

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

  else if((currentPage + 1) == 4) //page 5
  {
    page5Logic();
  }

  else if((currentPage + 1) == 5) //page 6
  {
    page6Logic();
  }

  else if((currentPage + 1) == 6) //page 7
  {

  }

  if((currentPage + 1) < 7)
  {
    //So now hide current page, unhide next page
    pages[currentPage].addClass('hidden');
    pages[currentPage + 1].removeClass('hidden');
    if((currentPage + 2) == 7) //If page we're able to move to is final page, change to save
    {
      nextButton.html('Save');
    }
  }
  else //Is 7th and final page
  {
    alert('finished');
    CBTSubmitLogic();
  }



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
  else if((currentPage) < 7) //else if page isn't the last one
  {
    nextButton.html('Next');
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
      if($(this).attr('data-percentage') == "none")
      {
        target.html($(this).val());
      }
      else
      {
        target.html($(this).val() + '%');
      }

    }

  });

  //On add new automatic thought
  $('#cbt-add-automatic-thought').on('click', function(e)
  {
    addAutomaticThought($(this));
  });

  //On add new automatic thought evidence
  $('#newCBT').on('click', '.addAutomaticThoughtEvidence', function(e)
  {
    addAutomaticThoughtEvidence($(this));
  });

  //on add new rational thought
  $('#cbt-add-rational-thought').on('click', function(e)
  {
    addRationalThought($(this));
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

//Monitor changes to privacy posting restrictions (me, anon, or none)
var privacyRadios = $('input[type="radio"][name="posting"]');
var privacyTable = $('table#privacy-table');
$(privacyRadios).on('change', function(){
  //get checked value
  var value = $(this).filter(":checked").val();
  if(value == "0")
  {
    if(!privacyTable.hasClass("hidden"))
    {
      privacyTable.addClass("hidden");
    }
  }
  else if(value == "1" || value == "2")
  {
    if(privacyTable.hasClass("hidden"))
    {
      privacyTable.removeClass("hidden");
    }
  }

});




var privacySlider = $('input[type="range"][name="privacy"]');
var privacyList = $('#privacy-includes');
//Monitor privacy level value
  privacySlider.on("mousemove change", privacySlider, function(e) {

      switch(privacySlider.val())
      {
        case '1':
          var template =
          `
            <li>Your situation</li>
            <li>Your automatic thoughts</li>
            <li>Your rational thoughts</li>
            <li>Your general mood, before and after.</li>
            <li>Your emotional responses, before and after.</li>
          `;
        break;

        case '2':
          var template =
          `
          <li>Your situation</li>
          <li>Your general mood, before and after.</li>
          <li>Your emotional responses, before and after.</li>
          `;
        break;

        case '3':
          var template =
          `
          <li>Your general mood, before and after.</li>
          <li>Your emotional responses, before and after.</li>
          `;
        break;
      }

      privacyList.html(template);

    });

/*
 * Profile page Logic  ----------------------------------------
*/

//Listen for secondary menu clicks
var secondaryMenuItems = $('div.cover-menu-wrapper span');
var wrapper = $('div.cover-menu-wrapper');
$.each(secondaryMenuItems, function(){
  $(this).on('click', function(){

    var active = secondaryMenuItems.filter('[class="active"]');
    if($(this).attr('id') == active.attr('id'))
    {
      var amIActive = true;
      //Don't need to do anything
    }
    else if(active.length > 0)
    {
      var amIActive = false;
      //reconstruct triangle position from active
      var x = active.position().left;
      x = x + (active.outerWidth() / 2);

      var newTriangle = $('<div class="triangle" style="left:' + x + 'px;"></div>');
      wrapper.append(newTriangle);

      //Now we have triangle in position, we can remove active class
      active.removeClass("active");

      //Now we find where the triangle needs to be
      var newX = $(this).position().left;
      newX = newX + ($(this).outerWidth() / 2);

      //Find triangle
      newTriangle.attr('style', 'left:' + newX + 'px');

      newActive = $(this);
      //Now add active class and remove pretend triangle
      newTriangle.bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function(){
        newActive.addClass("active");
        newTriangle.remove();
      });




    }


  });
});

//Listen to scroll for header positioning
$(window).scroll(function(e) {
    var top = $(window).scrollTop();
    var image = $('.profile-cover-img');
    var navHeight = $('nav').outerHeight();
    var height = image.height() - (50 + 15 + navHeight);

    if(top >= height)
    {
      if(!$('.profile-cover-img').hasClass("active"))
      {
        $('.profile-cover-img').addClass("active");
        $('#page-container').css('margin-top', (parseInt($('#page-container').css('marginTop')) + image.height()) + "px");
      }
    }
    else if(top < height)
    {
      if($('.profile-cover-img').hasClass("active"))
      {
        $('.profile-cover-img').removeClass("active");
        $('#page-container').css('margin-top', "");
      }
    }

});

});
