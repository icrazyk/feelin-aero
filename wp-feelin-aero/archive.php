<?php
/**
 * The template for displaying archive pages
 */

get_header(); ?>

<main class="main main_column_two z-index-1">
  <div class="container">

  	<?php get_template_part( 'template-parts/breadcrumb' ); ?>

    <div class="main__row">
      <div class="main__col main__col_content">

				<?php if ( have_posts() ) : ?>

					<?php
					// Start the Loop.
					while ( have_posts() ) : the_post();

						get_template_part( 'template-parts/content', get_post_format() );

					// End the loop.
					endwhile;

					// Previous/next page navigation.
					the_posts_pagination( array(
						'prev_text'          => __( 'Previous page', 'feelinaero' ),
						'next_text'          => __( 'Next page', 'feelinaero' ),
						'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'feelinaero' ) . ' </span>',
					) );

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif;
				?>
			</div>
			<div class="main__col main__col_sidebar">
				<?php get_sidebar(); ?>
      </div>
    </div>
  </div>
</main>
<?php get_footer(); ?>
