<?php
/**
 * Author h-card template loaded from within the wordpress-indieweb plugin.
 */
if ( $args['avatar'] ) {
	$avatar = get_avatar(
		$user,
		$args['avatar_size'],
		'default',
		'',
		// Exclude from WP Rocket LazyLoad!
		[ 'class' => [ 'u-photo', 'hcard-photo' ], 'extra_attr' => 'data-no-lazy="1"', ]
	);
} else {
	$avatar = '';
}
?>
<div class="hcard-display h-card vcard p-author">
	<div class="hcard-header">
		<a class="u-url url fn u-uid" href="<?php echo esc_url( $url ); ?>" rel="author"><?php echo $avatar; ?></a>
		<p class="hcard-name p-name n"><?php echo $name; ?></p>
	</div> <!-- end hcard-header -->
	<div class="hcard-body">
		<?php if ( $args['me'] ) { ?>
			<?php self::rel_me_list( $user->ID, is_front_page() ); ?>
		<?php }
		if ( $args['notes']  && $user->has_prop( 'description' ) ) { ?>
			<p class="p-note note"><?php echo $user->get( 'description' ); ?></p>
		<?php } ?>
	</div> <!-- end hcard-body -->
</div><!-- end hcard-display -->
<?php
