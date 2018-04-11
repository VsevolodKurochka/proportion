<?php
/**
* Template Name: Page Simple
*/

$context = Timber::get_context();
$post = new TimberPost();

$context['post'] = $post;

Timber::render( array( 'template-page-simple.twig' ), $context );