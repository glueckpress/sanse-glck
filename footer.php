<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Sanse
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">

		<?php get_sidebar( 'footer' ); // Loads the sidebar-footer.php template. ?>

		<div class="site-info">

			<?php
				get_template_part( 'menus/menu', 'social' ); // Loads the menus/menu-social.php template.
			?>

			<?php printf( esc_html__( 'Theme based on %1$s by %2$s.', 'sanse' ), 'Sanse', '<a href="https://foxland.fi/" rel="designer nofollow">Sami Keijonen</a>' ); ?>

		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
