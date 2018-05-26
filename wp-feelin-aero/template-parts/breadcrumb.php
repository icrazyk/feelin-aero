<?php if ( !is_front_page() ) : ?>

<div class="main__row main__row_breadcrumb">
	<?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(''); ?>
</div>
<?php endif ?>