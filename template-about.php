<?php
/**
* Template Name: About Us
*/

$context = Timber::get_context();
$post = new TimberPost();

$context['post'] = $post;

$front_page_id = 4;
$front = new TimberPost( $front_page_id );
$context['front'] = $front;

Timber::render( array( 'template-about.twig' ), $context );