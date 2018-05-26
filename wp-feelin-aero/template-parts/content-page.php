<?php
/**
 * The template used for displaying page content
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages( array(
			'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'feelinaero' ) . '</span>',
			'after'       => '</div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
			'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'feelinaero' ) . ' </span>%',
			'separator'   => '<span class="screen-reader-text">, </span>',
		) );
		?>
	</div>

	<?php
		edit_post_link(
			__( 'Edit', 'feelinaero' ),
			'<footer class="entry-footer"><span class="edit-link">',
			'</span></footer>'
		);
	?>
</article>
