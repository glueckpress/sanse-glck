<?php
/**
 * Template part for displaying asides (‘Notes’).
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Sanse
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'h-entry' ); ?>>

	<?php if ( is_singular() ) : // If single. ?>

		<header class="entry-header entry-header-aside">
			<?php
				the_title( '<h1 class="entry-title-aside">', '</h1> | ' );
				get_template_part( 'entry', 'meta' ); // Loads the entry-meta.php file.
			?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_content(); ?>
		</div><!-- .entry-content -->

		<?php get_template_part( 'entry', 'footer' ); // Loads the entry-footer.php file. ?>

	<?php else : ?>

		<div class="entry-inner">

			<header class="entry-header entry-header-aside">
				<?php the_title( '<h2 class="entry-title-aside"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?> |
				<?php get_template_part( 'entry-meta' ); ?>
			</header><!-- .entry-header -->

			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->

		</div><!-- .entry-inner -->

	<?php endif; // End check single. ?>

</article><!-- #post-## -->
