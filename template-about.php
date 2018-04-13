<?php
/**
* Template Name: About Us
*/

$context = Timber::get_context();
$post = new TimberPost();

$context['post'] = $post;

Timber::render( array( 'template-about.twig' ), $context );