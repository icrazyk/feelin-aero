<?php
/**
 * The template for displaying pages
 */

get_header(); ?>

<main class="main z-index-1">
  <div class="container">

		<?php get_template_part( 'template-parts/breadcrumb' ); ?>

    <div class="main__row">
      <div class="main__col main__col_content">

			<?php
			// Start the loop.
			while ( have_posts() ) : the_post();

				// Include the page content template.
				get_template_part( 'template-parts/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}

				// End of the loop.
			endwhile;
			?>

      </div>
    </div>
  </div>
</main>

<?php get_footer(); ?>
