<?php

$theme_dir = get_stylesheet_directory();

$main_shortcodes = $theme_dir . '/shortcodes/index.php';
if ( file_exists( $main_shortcodes ) ) {
	require_once $main_shortcodes;
}

function cogcpa_custom_styles() {
	$theme_dir = get_stylesheet_directory();
	$theme_uri = get_stylesheet_directory_uri();

	$custom_style_css = file_exists( $theme_dir . '/assets/css/custom.css' ) ? filemtime( $theme_dir . '/assets/css/custom.css' ) : null;

	wp_enqueue_style(
		'cogcpa-custom-style',
		$theme_uri . '/assets/css/custom.css',
		[],
		$custom_style_css
	);
}
function cogcpa_custom_scripts() {
	$theme_dir = get_stylesheet_directory();
	$theme_uri = get_stylesheet_directory_uri();

	$ver_custom_js = file_exists( $theme_dir . '/assets/js/custom.js' ) ? filemtime( $theme_dir . '/assets/js/custom.js' ) : null;

	wp_enqueue_script(
		'cogcpa-custom-script',
		$theme_uri . '/assets/js/custom.js',
		[],
		$ver_custom_js,
		true // load in footer
	);
}
add_action( 'wp_enqueue_scripts', 'cogcpa_custom_styles', 11 );
add_action( 'wp_enqueue_scripts', 'cogcpa_custom_scripts' );

// Load Finsweet Attributes (social share) on single blog posts only
add_action( 'wp_head', function () {
  if ( is_singular( 'post' ) ) {
    ?>
    <!-- [Attributes by Finsweet] Social Share -->
    <script defer src="https://cdn.jsdelivr.net/npm/@finsweet/attributes-socialshare@1/socialshare.js"></script>
    <?php
  }
}, 1 );
