<?php
namespace Kantor\Provider;

use Kantor\Service\ExchangeRateDAO;
use Silex\Application;
use Silex\ServiceProviderInterface;

class ExchangeRateDAOServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Application $app
     */
    public function register(Application $app)
    {
        $app['exchangeRate'] = new ExchangeRateDAO($app['db']);
    }

    /**
     * @param Application $app
     */
    public function boot(Application $app)
    {
    }
} 