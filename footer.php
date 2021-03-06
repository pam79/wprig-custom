<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

?>

	<?php
	if ( wp_rig()->has_block_area( 'footer' ) ) {
		?>
		<footer id="colophon" class="site-footer entry-content">
			<?php wp_rig()->render_block_area( 'footer' ); ?>
		</footer><!-- #colophon -->
		<?php
	} else {
		?>
		<footer id="colophon" class="site-footer">
			<?php get_template_part( 'template-parts/footer/widget_areas' ); ?>
			<?php get_template_part( 'template-parts/footer/social_navigation' ); ?>
			<?php get_template_part( 'template-parts/footer/info' ); ?>
		</footer><!-- #colophon -->
		<?php
	}
	?>

<?php wp_footer(); ?>

</body>
</html>
