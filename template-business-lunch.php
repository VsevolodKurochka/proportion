<?php
/**
* Template Name: Business Lunch
*/

$context = Timber::get_context();
$post = new TimberPost();


$context['post'] = $post;

Timber::render( array( 'template-business-lunch.twig' ), $context );

//print_r($context);