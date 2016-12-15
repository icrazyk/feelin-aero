/*
* Mmenu jQuery plugin init
*/
$(".header .menu").clone().appendTo(".menu-mobile");

$(".menu-mobile").mmenu({
  navbar: {
    title: "Главное меню"
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