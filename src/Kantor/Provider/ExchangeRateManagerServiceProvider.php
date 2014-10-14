<?php
namespace Kantor\Provider;

use Kantor\Service\ExchangeRateManager;
use Silex\Application;
use Silex\ServiceProviderInterface;

class ExchangeRateManagerServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Application $app
     */
    public function register(Application $app)
    {
        $app['exchangeRate'] = new ExchangeRateManager($app['db']);
    }

    /**
     * @param Application $app
     */
    public function boot(Application $app)
    {
    }
} 