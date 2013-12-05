<?php

use Symfony\Component\Translation\Loader\YamlFileLoader;

$app = new Silex\Application();

$app->register(new Igorw\Silex\ConfigServiceProvider(__DIR__.'/../config/default.json', array(
    'dir' => __DIR__
)));
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
     'locale_fallbacks' => $app['locale_fallbacks']
));
$app->register(new Silex\Provider\SecurityServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => $app['twig.path']
));
$app->register(new Kantor\Provider\Data());

$app['translator'] = $app->share($app->extend('translator', function($translator, $app) {
    $translator->addLoader('yaml', new YamlFileLoader());
    $translator->addResource('yaml', __DIR__.'/../locales/pl.yml', 'pl');

    return $translator;
}));

$app->get('/', 'Kantor\Controller\Index::index');
$app->get('/admin', 'Kantor\Controller\Index::admin');

return $app;