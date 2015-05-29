<?php
/*
Plugin Name: Anywhere Post List Shortcode
Version: 0.2
Plugin URI: http://hibou-web.com
Description: You can simply put a "[list]" short code, to list the title of the latest article (link with) and the front page of your blog, sidebar, footer. Set category and custom post type, taxonomy also other it is also possible.
Author: Shuhei Nishimura
Author URI: http://hibou-web.com
License: GPLv2 or later
License URI: http://opensource.org/licenses/gpl-2.0.php GPLv2
*/

/**
 * Anywhere Post List Shortcode
 *
 * @package Anywhere Post List Shortcode
 * @version 0.2
 * @author Shuhei Nishimura <shuhei.nishimura@gmail.com>
 * @copyright Copyright (c) 2014 Shuhei Nishimura (Hibou).
 * @license http://opensource.org/licenses/gpl-2.0.php GPLv2
 * @link http://hibou-web.com
 */

function anywhere_list( $atts ) {
	global $post;
	extract( shortcode_atts( array(
		'post_type'			=>	'post',
		'cat_name'			=>	'',
		'num'						=>	10,
		'class'					=>	'',
		'orderby'				=>	'post_date',
		'order'					=>	'DESC',
		'length'				=>	'',
		'end_of_title'	=>	'',
		'taxonomy'			=>	'',
		'term'					=>	'',
		'more'					=>	' … more',
		'post_format'		=>	'standard',
		'no_filter'			=>	false,
	), $atts ) );

	if( $post_type === 'post' ) {
		$args = array(
		  'post_type'				=>	$post_type,
		  'posts_per_page'	=>	$num,
		  'order'						=>	$order,
		  'category_name'		=>	$cat_name,
		  'orderby'					=>	$orderby,
		  'order'						=>	$order,
		);
	} elseif( ! empty( $taxonomy ) && ! empty( $term ) ) {
		$args = array(
		  'post_type'			=>	$post_type,
		  'posts_per_page'=>	$num,
		  'orderby'				=>	$orderby,
		  'order'					=>	$order,
		  'tax_query' => array(
				array(
					'taxonomy'	=>	$taxonomy,
					'field'			=>	'slug',
					'terms'			=>	$term,
				)
			)
		);
	} else {
		$args = array(
		  'post_type'			=>	$post_type,
		  'posts_per_page'=>	$num,
		  'order'					=>	$order,
		  'post_format'		=>	$post_format,
		);
	}
	$list_posts = get_posts( $args );

	$html   = '';
	$output = '';
	$class = ( ! empty( $class ) ) ? "class='$class'" : '';
	if( $list_posts ) {
		$html .= apply_filters( 'anywhter_before_list_tag', "<ul $class>" );
		foreach( $list_posts as $post ) {
			setup_postdata( $post );
			$post_id    = $post->ID;
			$post_link	= get_permalink( $post_id );
			$post_title	= get_the_title( $post_id );

			if( ! empty( $length ) && mb_strlen( $post_title ) >= $length ) {
				$post_title = wp_trim_words( $post_title, $length, $more );
			}
			$post_title = apply_filters( 'the_title', $post_title );

			if( ! empty( $list_posts ) ) {
				$no_filter ?
				$html .= apply_filters( 'anywhter_list_content', '<li>'
							. '<a href="' . esc_url ( $post_link ) . '">'
							. esc_html( $post_title )
							. '</a></li>'
				) :
				$html .= '<li>'
							. '<a href="' . esc_url ( $post_link ) . '">'
							. esc_html( $post_title )
							. '</a></li>';
			} else {
				$no_filter ?
				$html .= apply_filters( 'anywhter_list_content', '<li>'
							. '<a href="' . esc_url ( $post_link )
							. '">'
							. esc_html( $post_title )
							. '</a></li>'
				) :
				$html .= '<li>'
							. '<a href="' . esc_url ( $post_link )
							. '">'
							. esc_html( $post_title )
							. '</a></li>';
			}
		}
	}
	wp_reset_postdata();
	$html .= apply_filters( 'anywhter_after_list_tag', '</ul>' );
	return $html;
}
add_shortcode( 'list', 'anywhere_list' );

// add widget area
add_filter('widget_text', 'do_shortcode');
