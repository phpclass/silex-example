<?php

// configure your app for the production environment

$app['twig.path'] = [
    __DIR__.'/../templates',
    __DIR__.'/../src/App/templates',
];
$app['twig.options'] = array('cache' => __DIR__.'/../var/cache/twig');
