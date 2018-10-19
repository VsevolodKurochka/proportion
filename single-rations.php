<?php

$context = Timber::get_context();
$post = new TimberPost();

$context['post'] = $post;
$context['get'] = $_GET;

Timber::render( array( 'single-rations.twig' ), $context );