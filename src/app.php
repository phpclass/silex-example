<?php

use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app->register(new DoctrineOrmServiceProvider());

$app->register(new DoctrineServiceProvider(), [
        'db.options' => [
            'driver' => 'pdo_mysql',
            'host' => '127.0.0.1',
            'dbname' => 'silex',
            'user' => 'root',
            'password' => 'root',
            'charset' => 'utf8mb4',
        ]
    ]
);
//$app['orm.proxies_dir'] = __DIR__.'/../cache/doctrine/proxies';
//$app['orm.default_cache'] = 'array';
$app['orm.em.options'] = array(
    'mappings' => array(
        array(
            'type' => 'simple_yml',
            'path' => __DIR__.'/App/Resources/Doctrine/',
            'namespace' => 'App\\Entities',
        ),
    ),
);

$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...

    return $twig;
});

return $app;
