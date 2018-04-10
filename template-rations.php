<?php
/**
* Template Name: Rations
*/

$context = Timber::get_context();
$post = new TimberPost();


$context['post'] = $post;

Timber::render( array( 'template-rations.twig' ), $context );

//print_r($context);