<?php
/**
 * Sanse Glck Child Theme
 *
 * @author Caspar Hübinger
 */

/**
 * Remove unwanted features.
 */

// Leave minification to plugins.
remove_filter( 'stylesheet_uri', 'sanse_min_stylesheet_uri', 5, 2 );

// Remove parent theme stylesheet, since we’ve copied it over.
add_action( 'wp_enqueue_scripts', function () {

	wp_dequeue_style( 'sanse-parent-style' ); // Content copied to child style.css
	wp_dequeue_style( 'sanse-style' ); // Lacks version number :/
	wp_dequeue_script( 'sanse-navigation' );  // Inlined in footer

}, 20 );

// Remove theme stuff.
add_action( 'after_setup_theme', function () {

	remove_theme_support( 'custom-background' );
	remove_theme_support( 'custom-header' );
	remove_theme_support( 'custom-header-uploads' );
	remove_theme_support( 'custom-logo' );
	remove_editor_styles();

	// Custom name, otherwise both, child and parent will be called!
	add_editor_style( [
		trailingslashit( get_stylesheet_directory_uri() ) . 'assets/css/webfonts.css',
		get_stylesheet_uri(),
		trailingslashit( get_stylesheet_directory_uri() ) . 'assets/css/editor-style.css',
	] );

	// Remove default indieweb styles
	remove_action( 'wp_enqueue_scripts', [ 'IndieWeb_Plugin', 'enqueue_style' ] );
	remove_action( 'wp_enqueue_scripts', [ 'Post_Kinds_Plugin', 'style_load' ] );

}, 20 );

// Remove Custom CSS from Customizer.
add_action( 'customize_register', function ( $wp_customize ) {
	$wp_customize->remove_control( 'custom_css' );
}, 20 );

/**
 * Post formats.
 */
add_action( 'after_setup_theme', function () {
	add_theme_support( 'post-formats', [ 'aside' ]);
});

/**
 * Start CSS
 */
add_action( 'wp_head', function () {
?>
<style id="sanse-glck-start-css">html{background:#ffcd00}body{-webkit-animation:glck-start 8s steps(1, end) 0s 1 normal both;-moz-animation:glck-start 8s steps(1, end) 0s 1 normal both;animation:glck-start 8s steps(1, end) 0s 1 normal both}@-webkit-keyframes glck-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes glck-start {from{visibility:hidden}to{visibility:visible}}@keyframes glck-start{from{visibility:hidden}to{visibility:visible}}html.js.wf-active{background:#fff}.js.wf-active body{-webkit-animation:none;-moz-animation:none;animation:none;visibility:visible}</style>
<noscript><style>html.no-js{background:#fff}.no-js > body{-webkit-animation:none;-moz-animation:none;animation:none;visibility:visible}</style></noscript>
<?php
}, 0 );

/**
 * Web Font Loader configuration string.
 *
 * @link https://github.com/typekit/webfontloader/
 */
function glck_sanse_webfontloader_config( $webfont_css ) {
	$data  = 'WebFontConfig = {';
	$data .= 'custom: {';
	$data .= 'families: ["rvl:n4,i4,n7"],urls: ["';
	$data .= $webfont_css;
	$data .= '"]}};';

	return $data;
}

/**
 * Font business.
 */
add_action( 'wp_enqueue_scripts', function() {
	wp_enqueue_style( 'sanse-glck-style', get_stylesheet_uri(), [], filemtime( __FILE__ ) );

	$assets = trailingslashit( get_stylesheet_directory_uri() ) . 'assets/';

	$data = glck_sanse_webfontloader_config( $assets . 'css/webfonts.css' );

	wp_register_script( 'wf-loader', $assets . 'js/webfontloader.js', [], '1.6.28', false );
	wp_enqueue_script( 'wf-loader' );

	wp_add_inline_script( 'wf-loader', $data, 'before' );
});

/**
 * Inline small JavaScript in footer.
 */
add_action( 'wp_footer', function() {
	$scripts = [
		'sanse-glck-start' => [
			trailingslashit( get_stylesheet_directory_uri() ) . 'assets/js/start.js',
			'script'
		],
		'sanse-navigation' => [
			trailingslashit( get_template_directory_uri() ) . 'assets/js/navigation.js',
			'script'
		],
		'sanse-glck-navigation' => [
			trailingslashit( get_stylesheet_directory_uri() ) . 'assets/js/navigation.js',
			'script'
		],
	];

	glck_sanse_print_file_content( $scripts );
}, 100 );

/**
 * Async scripts (avoids defer by WP Rocket).
 *
 * @link https://matthewhorne.me/defer-async-wordpress-scripts/
 */
add_filter( 'script_loader_tag', function ( $tag, $handle ) {
	if ( 'wf-loader' !== $handle )
		return $tag;

	return str_replace( ' src', ' async="async" src', $tag );
}, 10, 2 );

/**
 * Alter post classes on the front end.
 *
 * @link https://developer.wordpress.org/reference/hooks/post_class/
 */
add_filter( 'post_class', function ( $classes, $class, $post_id ) {
	if ( is_admin() ) {
		return $classes;
	}

	if ( ! is_main_query() ) {
		return $classes;
	}

	if ( 'post' !== get_post_type( $post_id ) ) {
		return $classes;
	}

	$maybe_has_more_link = glck_sanse_maybe_has_more_link( $post_id );

	if ( $maybe_has_more_link ) {
		$classes[] = 'has-more-link';
	}

	return $classes;
}, 10, 3 );


/**
 * Allow custom elements in editor.
 *
 * @link https://vip.wordpress.com/documentation/register-additional-html-attributes-for-tinymce-and-wp-kses/
 */
add_action( 'init', function () {
	global $allowedposttags;

	$tags = [ 'aside' ];
	$new_attributes = [ 'class' => [] ];

	foreach ( $tags as $tag ) {
		if ( isset( $allowedposttags[ $tag ] ) && is_array( $allowedposttags[ $tag ] ) ) {
			$allowedposttags[ $tag ] = array_merge( $allowedposttags[ $tag ], $new_attributes );
		}
	}
});
add_filter( 'tiny_mce_before_init', function ( $options ) {
	if ( ! isset( $options['extended_valid_elements'] ) ) {
		$options['extended_valid_elements'] = '';
	} else {
		$options['extended_valid_elements'] .= ',';
	}

	if ( ! isset( $options['custom_elements'] ) ) {
		$options['custom_elements'] = '';
	} else {
		$options['custom_elements'] .= ',';
	}

	$options['extended_valid_elements'] .= 'aside[class]';
	$options['custom_elements']         .= 'aside[class]';

	return $options;
});


/**
 * Check for more link in post content.
 */
function glck_sanse_maybe_has_more_link( $post_id ) {
	$post = get_post( $post_id );
	$content = $post->post_content;
	$data_array = get_extended( $content );

	return '' !== $data_array['extended'];
}

/**
 * Get file content from given URLs and print it in <script> or <style> tags.
 *
 * @param  array  $assets Multidimensional array ['handle' => 'my-hanle', 'asset' => [ $url, $tag ]]
 * @return string         Content of each file printed in passed HTML tag
 */
function glck_sanse_print_file_content( array $assets ) {
	foreach ( $assets as $handle => $asset ) {

		$content = file_get_contents( $asset[0] );
		$tag = $asset[1];

		if ( ! $content ) {
			continue;
		}

		if ( 'script' !== $tag && 'style' !== $tag ) {
			continue;
		}

		printf( '<%1$s id="%2$s">%3$s</%1$s>', tag_escape( $tag ), esc_attr( $handle ), $content );
	}
}

/**
 * Webmention plugin support
 */
add_filter( 'webmention_comment_form', function () {
	return trailingslashit( get_stylesheet_directory() ) . 'plugins/webmention/webmention-comment-form.php';
} );

/**
 * Post meta data: current post-date/time, but not author.
 */
function glck_sanse_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( 'Posted on %s', 'post date', 'sanse' ),
		$time_string
	);

	echo '<span class="posted-on"><span class="screen-reader-text">' . $posted_on . '</span><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a></span>';
}

/**
 * Tax query arguments to exclude any posts with post formats.
 */
function sanse_glck__tax_query_minus_post_formats() {
	return [[
		'taxonomy' => 'post_format',
		'field'    => 'slug',
		'terms'    => [
			'post-format-aside',
			'post-format-gallery',
			'post-format-link',
			'post-format-image',
			'post-format-quote',
			'post-format-status',
			'post-format-video',
			'post-format-audio',
			'post-format-chat',
		],
		'operator' => 'NOT IN',
	]];
}

/**
 * Limit main post query to standard post format.
 *
 * @uses sanse_glck__tax_query_minus_post_formats()
 */
add_action( 'pre_get_posts', function ( $query ) {

	// Return default query if this is admin.
	if ( is_admin() ) {
		return $query;
	}

	// Return default query if this is not the main query.
	if ( ! $query->is_main_query() ) {
		return $query;
	}


	// Remove post formats.
	$tax_query = sanse_glck__tax_query_minus_post_formats();

	// Return default query if this is not the blog page.
	if ( $query->is_home() ) {
		$query->set( 'tax_query', $tax_query );
	}

	return $query;
});

/**
 * Modify archive title
 */
add_filter( 'get_the_archive_title', function ( $title ) {

	if ( is_tax( 'post_format', 'post-format-aside' ) ) {
		$title = _x( 'Notes', 'post format archive title' );
	}

	return $title;
});

/**
 * Add SVG definitions to the footer.
 */
add_action( 'wp_footer', function () {
	// Define SVG sprite file.
	$svg_icons = get_stylesheet_directory() . '/assets/img/svg-icons.svg';

	// If it exists, include it.
	if ( file_exists( $svg_icons ) ) {
		require_once( $svg_icons );
	}

}, 9999 );
remove_action( 'wp_footer', 'sanse_include_svg_icons', 9999 );

/**
 * Integrate Sanse SVG icons with IndieWeb relme list.
 */
add_filter( 'indieweb_rel_me', function ( $html, $author_id, $silos ) {
	$author_name   = get_the_author_meta( 'display_name', $author_id );
	$single_author = get_option( 'iw_single_author', is_multi_author() ? '0' : '1' );
	$maybe_rel     = ( is_front_page() && '1' === $single_author ) ? 'rel="me" ' : '';
	$links_array   = [];

	foreach ( $silos as $silo => $profile_url ) {

		//$name = self::url_to_name( $profile_url );

		$links_array[ $silo ] = sprintf( '<a %1$sclass="url u-url" href="%2$s"><span class="relmename screen-reader-text">%3$s</span>%4$s</a>',
			$maybe_rel,
			esc_url( $profile_url ),
			esc_attr( $silo ),
			sanse_get_svg([
				'icon'        => esc_attr( $silo ),
				'title'       => esc_url( $profile_url ),
				'desc'        => '',
				'aria_hidden' => true,
			])
		);
	}

	$html = "<div class='relme menu-social'><ul class='menu-social-items'>\n<li class='menu-item'>" . join( "</li>\n<li>", $links_array ) . "</li>\n</ul></div>";

	return $html;
}, 10, 3);
