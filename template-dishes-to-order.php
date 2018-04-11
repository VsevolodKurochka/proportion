<?php
/**
* Template Name: Dishes To Order
*/

$context = Timber::get_context();
$post = new TimberPost();


$context['post'] = $post;

Timber::render( array( 'template-dishes-to-order.twig' ), $context );

//print_r($context);