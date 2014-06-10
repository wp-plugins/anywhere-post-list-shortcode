<?php
/*
Plugin Name: Anywhere Post List Shortcode
Version: 0.0.5
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
 * @version 0.0.1
 * @author Shuhei Nishimura <shuhei.nishimura@gmail.com>
 * @copyright Copyright (c) 2014 Shuhei Nishimura (Hibou).
 * @license http://opensource.org/licenses/gpl-2.0.php GPLv2
 * @link http://hibou-web.com
 */

function anywhere_list( $atts ) {

	extract( shortcode_atts( array(
		'post_type'			=>	'post',
		'cat_name'			=>	'',
		'num'						=>	3,
		'class'					=>	'',
		'orderby'				=>	'post_date',
		'order'					=>	'DESC',
		'length'				=>	'',
		'end_of_title'	=>	'',
		'taxonomy'			=>	'',
		'term'					=>	''
	), $atts ) );
	global $post;
	if( $post_type === 'post' ) {
		$args = array(
		  'post_type'				=>	$post_type,
		  'posts_per_page'	=>	$num,
		  'order'						=>	$order,
		  'category_name'		=>	$cat_name,
		  'orderby'					=>	$orderby,
		  'order'						=>	$order
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
					'terms'			=>	$term
				)
			)
		);
	} else {
		$args = array(
		  'post_type'			=>	$post_type,
		  'posts_per_page'=>	$num,
		  'order'					=>	$order,
		);
	}
	$relational_posts = get_posts( $args );
	setup_postdata( $post );
	$html = '';
	foreach( $relational_posts as $post ) {
		$post_link	= get_permalink();
		$post_title	= get_the_title();
		
		if( ! empty( $length ) && mb_strlen( $post_title ) >= $length ) {
			$post_title = mb_strimwidth( $post_title, 0, $length*2-1, $end_of_title );
		}
		$post_title = apply_filters( 'the_title', $post_title );
		
		$html .= '<li>' . '<a href="' . $post_link . '">' . $post_title . '</a></li>';
	}
	wp_reset_postdata();
	if( ! empty( $relational_posts ) && ! empty( $class ) ) {
		$output = "<ul class='$class'>" . $html . "</ul>";
		return $output;
	} elseif( ! empty( $relational_posts ) ) {
		$output =  "<ul>" . $html . "</ul>";
		return $output;
	}
} 
add_shortcode( 'list', 'anywhere_list' );

// add widget area
add_filter('widget_text', 'do_shortcode');
