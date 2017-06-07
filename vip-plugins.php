<?php

require __DIR__ . '/amp-wp/amp.php';
require __DIR__ . '/jetpack/jetpack.php';
require __DIR__ . '/media-explorer/media-explorer.php';
require __DIR__ . '/Rewrite-Rules-Inspector/rewrite-rules-inspector.php';
require __DIR__ . '/writing-helper/writing-helper.php';

/*
 * Automatically activate the shortcodes module as the same code
 * is being automatically present on the WordPress.com VIP platform.
 */
if ( class_exists( 'Jetpack' ) ) {
	Jetpack::activate_module( 'shortcodes', false, false );
}
