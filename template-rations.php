<?php
/**
* Template Name: Rations
*/

$context = Timber::get_context();
$post = new TimberPost();

$args = array(
	'post_type' 			=> 'rations',
	'posts_per_page' 	=> -1,
	'post_status'		 	=> 'publish'
);

$context['post'] = $post;
$context['rations'] = Timber::get_posts( $args );

Timber::render( array( 'template-rations.twig' ), $context );