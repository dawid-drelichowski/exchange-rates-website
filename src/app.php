<?php
use Symfony\Component\Translation\Loader\YamlFileLoader;

$app = new Silex\Application();

$app->register(new Igorw\Silex\ConfigServiceProvider(__DIR__.'/../config/default.json', array(
    'dir' => __DIR__
)));
$app->register(new Silex\Provider\SessionServiceProvider(), array(
    'session.test' => $app['session.test']
));
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'locale_fallbacks' => $app['locale_fallbacks']
));
$app->register(new Silex\Provider\SecurityServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => $app['twig.path']
));
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new ExchangeRatesWebsite\Provider\ExchangeRateDAOServiceProvider());

$app['translator'] = $app->share($app->extend('translator', function($translator) {
    $translator->addLoader('yaml', new YamlFileLoader());
    $translator->addResource('yaml', __DIR__.'/../locales/en.yml', 'en');

    return $translator;
}));

$app->get('/', 'ExchangeRatesWebsite\Controller\IndexController::index');
$app->match('/admin', 'ExchangeRatesWebsite\Controller\AdminController::index');

return $app;