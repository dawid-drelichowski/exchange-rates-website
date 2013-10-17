<?php
require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->register(new Igorw\Silex\ConfigServiceProvider(__DIR__.'/../config/default.json', array(
    'dir' => __DIR__
)));
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => $app['twig.path']
));
$app->register(new Kantor\Provider\Data());

$app->get('/', 'Kantor\Controller\Index::index');

$app->run();