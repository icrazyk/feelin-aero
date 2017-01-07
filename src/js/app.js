/*
* Mmenu jQuery plugin init
*/
$(".header .menu").clone().appendTo(".menu-mobile");

$(".menu-mobile").mmenu({
  navbar: {
    title: "Школа пилотов"
  }
});

var API = $(".menu-mobile").data( "mmenu" );

$(".menu-toggle").click(function() {
   API.open();
});

/*
* Comment
*/
$('.comment-form-comment textarea').on('change', function()
{
  if($(this).val())
    $(this).addClass('comment-dirty');
  else
    $(this).removeClass('comment-dirty');
});

/*
* Fancybox
*/

// set rel attribute

$('.gallery').each(function(index)
{
	var id = $(this).attr('id');
	$(this).find('a').attr('rel', id);
});

// init

$('.gallery a').fancybox(
{
	padding : 0,
	beforeShow : function() 
	{
    var alt = this.element.find('img').attr('alt');
    this.inner.find('img').attr('alt', alt);
    this.title = alt;
  },
  helpers : 
  {
    overlay : 
    {
      css : 
      {
        'background' : 'rgba(32, 32, 60, 0.85)'
      }
    }
  }
});

/*
* Gallery fold
*/

$('.gallery').each(function(idx, gallery)
{
  if($(gallery).find('.gallery-item').length > 9)
  {
    console.log('Need fold');
  }
});

/*
* Min Width Shadow
*/

(function ( $ ) {
  $.fn.minWidthShadow = function()
  {
    function shadowInTable(tableWrapper){
      var wrapper = tableWrapper,
          wrapperWidth = wrapper.width(),
          table = wrapper.children(),
          tableWidth = table.width(),
          leftShadow = wrapper.siblings('.shdwtab__shad_lt'),
          rightShadow = wrapper.siblings('.shdwtab__shad_rt'),
          scrollLeft = wrapper.scrollLeft(),
          scrollRight = tableWidth - scrollLeft - wrapperWidth,
          visibleClass = 'shdwtab__shad_visible';

      // Left shadow
      if(scrollLeft > 5){
        leftShadow.addClass(visibleClass)
        leftShadow.css({'opacity' : scrollLeft / 100})
      }else{
        leftShadow.removeClass(visibleClass)
        leftShadow.css({'opacity' : ''})
      }

      // Right shadow
      if(scrollRight > 5){
        rightShadow.addClass(visibleClass)
        rightShadow.css({'opacity' : scrollRight / 100})
      }else{
        rightShadow.removeClass(visibleClass)
        rightShadow.css({'opacity' : ''})
      }
    }

    return this.each(function()
    {
      /* Template */
      var shadowWrap =  '<div class="shdwtab">'
                          + '<div class="shdwtab__shad shdwtab__shad_lt"></div>'
                          + '<div class="shdwtab__shad shdwtab__shad_rt"></div>'
                          + '<div class="shdwtab__wrap"></div>'
                      + '</div>';
      
      /* Add template */
      var newTable = $(shadowWrap).insertBefore($(this));
      var newTableWrap = newTable.find('.shdwtab__wrap');

      /* Wrap to template */
      newTableWrap.append($(this));

      /* Handlers */ 
      newTableWrap.scroll(function() { shadowInTable($(this)); });
      // TODO: this init one and global
      // $(window).resize(function() { shadowInTable($(newTableWrap)); });  

      /* Init */ 
      shadowInTable(newTableWrap);
    });
  };
}( jQuery ));

$('table, .winguru').minWidthShadow();
