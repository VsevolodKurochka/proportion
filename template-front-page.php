<?php
/**
* Template Name: Front Page
*/

$context = Timber::get_context();
$post = new TimberPost();

$reviews = array(
	'post_type' 			=> 'reviews',
	'posts_per_page' 	=> -1,
	'post_status'		 	=> 'publish'
);

$rations = array(
	'post_type' 			=> 'rations',
	'posts_per_page' 	=> -1,
	'post_status'		 	=> 'publish'
);


$context['post'] = $post;
$context['reviews'] = new Timber\PostQuery($reviews);
$context['rations'] = Timber::get_posts( $rations );


Timber::render( array( 'template-front-page.twig' ), $context );

//print_r($context);