<?php
/**
 * The template for displaying the header
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> >
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
  <?php endif; ?>
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <div class="menu-mobile"></div>
  <div class="wrapper">
    <header class="header z-index-2">
      <div class="container">
        <div class="header__logo">
          <?php if ( is_front_page() ) : ?>
            <span class="header-logo"><span>
          <?php else : ?>
            <a href="/" class="header-logo"></a>
          <?php endif ?>
        </div>
        <div class="header__menu">
          <div class="header-menu">
            <div class="header-menu__toggle Fixed">
              <div class="menu-toggle">
                <div class="menu-toggle__icon">
                  <span></span>
                  <span></span>
                  <span></span>
                </div>
                <div class="menu-toggle__title">Меню</div>
              </div>
              <div class="menu-search">
                <?php get_search_form(); ?>
              </div>
            </div>
            <div class="header-menu__menu">
              <?php if ( has_nav_menu( 'primary' ) ) : ?>
                <?php
                  wp_nav_menu( array(
                    'theme_location' => 'primary'
                   ) );
                ?>
              <?php endif ?>
            </div>
          </div>
        </div>
        <div class="header__search">
          <?php get_search_form(); ?>
        </div>
        <div class="header__flybtn">
          <button class="flybtn" id="modal-fly-open"><span>Полетать</span></button>
        </div>
      </div>
    </header>
