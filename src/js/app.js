$(".menu-mobile").mmenu();

var API = $(".menu-mobile").data( "mmenu" );

$(".menu-toggle").click(function() {
   API.open();
});
