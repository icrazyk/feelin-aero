<?php
/**
 * The template for displaying search results pages
 */

get_header(); ?>

<main class="main z-index-1">
  <div class="container">

  	<?php get_template_part( 'template-parts/breadcrumb' ); ?>

  	<div class="main__row">
  	  <div class="main__col main__col_content">

				<?php if ( have_posts() ) : ?>

					<?php
					// Start the loop.
					while ( have_posts() ) : the_post();

						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						get_template_part( 'template-parts/content', 'search' );

					// End the loop.
					endwhile;

					// Previous/next page navigation.
					the_posts_pagination( array(
						'prev_text'          => __( 'Previous page', 'feelinaero' ),
						'next_text'          => __( 'Next page', 'feelinaero' ),
						'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'feelinaero' ) . ' </span>',
					) );

				// If no content, include the "No posts found" template.
				else :
					get_template_part( 'template-parts/content', 'none' );

				endif;
				?>
				
		  </div>
		</div>
  </div>
</main>

<?php get_footer(); ?>
