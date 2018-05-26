<?php
/**
 * The template for displaying 404 pages (not found)
 */

get_header(); ?>

	<main class="main z-index-1">
  	<div class="container">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'feelinaero' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'feelinaero' ); ?></p>

					<?php get_search_form(); ?>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->

	  </div>
	</main>
<?php get_footer(); ?>
