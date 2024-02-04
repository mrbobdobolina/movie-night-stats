<?php

function convert_hex_to_rgb($hex){
	list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
	return [$r, $g, $b];
}

function get_luminance_from_rgb($rgb): float {
	[$r, $g, $b] = $rgb;

	$r /= 255;
	$g /= 255;
	$b /= 255;

	$r2 = ( $r < 0.04045 ) ? $r / 12.92 : pow(( $r + 0.055 ) / 1.055, 2.4);
	$g2 = ( $g < 0.04045 ) ? $g / 12.92 : pow(( $g + 0.055 ) / 1.055, 2.4);
	$b2 = ( $b < 0.04045 ) ? $b / 12.92 : pow(( $b + 0.055 ) / 1.055, 2.4);

	return 0.2126 * $r2 + 0.7152 * $g2 + 0.0722 * $b2;
}

function get_contract_values_from_rgb($rgb): array {
	$luminance = get_luminance_from_rgb($rgb);

	$lum_white = ( 1 + 0.05 ) / ( $luminance + 0.05 );
	$lum_black = ( $luminance + 0.05 ) / ( 0.05 );

	return [ $lum_white, $lum_black ];
}

function get_text_color_from_hex($hex): string {
	$rgb = convert_hex_to_rgb($hex);
	$contrast = get_contract_values_from_rgb($rgb);

	return ($contrast[0] >= 4.5) ? '#FFF' : '#000';
}
