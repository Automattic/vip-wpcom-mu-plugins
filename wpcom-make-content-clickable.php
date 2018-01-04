<?php

/**
 * WP.com make clickable
 *
 * Converts all plain-text HTTP URLs in post_content to links on display
 *
 * @uses make_clickable()
 * @since 20121125
 */
function wpcom_make_content_clickable($content) {
	// make_clickable() is expensive, check if plain-text URLs exist before running it
	// don't look inside HTML tags
	// don't look in <a></a>, <pre></pre>, <script></script> and <style></style>
	// use <div class="skip-make-clickable"> in support docs where linkifying
	// breaks shortcodes, etc.
	$_split = preg_split( '/(<[^<>]+>)/i', $content, -1, PREG_SPLIT_DELIM_CAPTURE );
	$end = $out = $combine = '';
	$split = array();

	// filter the array and combine <a></a>, <pre></pre>, <script></script> and <style></style> into one
	// (none of these tags can be nested so when we see the opening tag, we grab everything untill we reach the closing tag)
	foreach( $_split as $chunk ) {
		if ( $chunk === '' )
			continue;

		if ( $end ) {
			$combine .= $chunk;

			if ( $end == strtolower( str_replace( array( "\t", ' ', "\r", "\n" ), '', $chunk ) ) ) {
				$split[] = $combine;
				$end = $combine = '';
			}
			continue;
		}

		if ( strpos( strtolower( $chunk ), '<a ' ) === 0 ) {
			$combine .= $chunk;
			$end = '</a>';
		} elseif ( strpos( strtolower( $chunk ), '<pre' ) === 0 ) {
			$combine .= $chunk;
			$end = '</pre>';
		} elseif ( strpos( strtolower( $chunk ), '<style' ) === 0 ) {
			$combine .= $chunk;
			$end = '</style>';
		} elseif ( strpos( strtolower( $chunk ), '<script' ) === 0 ) {
			$combine .= $chunk;
			$end = '</script>';
		} elseif ( strpos( strtolower( $chunk ), '<div class="skip-make-clickable' ) === 0 ) {
			$combine .= $chunk;
			$end = '</div>';
		} else {
			$split[] = $chunk;
		}
	}

	foreach ( $split as $chunk ) {
		// if $chunk is white space or a tag (or a combined tag), add it and continue
		if ( preg_match( '/^\s+$/', $chunk ) || ( $chunk{0} == '<' && $chunk{ strlen( $chunk ) - 1 } == '>' ) ) {
			$out .= $chunk;
			continue;
		}

		// three strpos() are faster than one preg_match() here. If we need to check for more protocols, preg_match() would probably be better
		if ( strpos( $chunk, 'http://' ) !== false || strpos( $chunk, 'https://' ) !== false || strpos( $chunk, 'www.' ) !== false ) {
			// looks like there is a plain-text url
			$out .= make_clickable( $chunk );
		} else {
			$out .= $chunk;
		}
	}

	return $out;
}

add_filter( 'the_content', 'wpcom_make_content_clickable', 120 );
add_filter( 'the_excerpt', 'wpcom_make_content_clickable', 120 );
