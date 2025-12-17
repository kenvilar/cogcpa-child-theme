<?php

$theme_dir = get_stylesheet_directory();

$main_shortcodes = $theme_dir . '/shortcodes/index.php';
if ( file_exists( $main_shortcodes ) ) {
	require_once $main_shortcodes;
}