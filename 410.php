<?php
/**
 * The template for displaying 410 pages (gone).
 *
 * @package Sanse
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section class="error-410 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Sorry, that page has been removed.', 'sanse' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php esc_html_e( 'It looks like the page you’re looking for has been permanently removed.', 'sanse' ); ?></p>

					<?php get_search_form(); ?>

				</div><!-- .page-content -->
			</section><!-- .error-410 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
