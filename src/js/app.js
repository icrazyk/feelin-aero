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
