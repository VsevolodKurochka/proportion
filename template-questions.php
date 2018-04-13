<?php
/**
* Template Name: Questions
*/

$context = Timber::get_context();
$post = new TimberPost();

$context['post'] = $post;

Timber::render( array( 'template-questions.twig' ), $context );