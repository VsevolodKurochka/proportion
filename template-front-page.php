<?php
/**
* Template Name: Front Page
*/

$context = Timber::get_context();
$post = new TimberPost();


$context['post'] = $post;

Timber::render( array( 'template-front-page.twig' ), $context );

//print_r($context);