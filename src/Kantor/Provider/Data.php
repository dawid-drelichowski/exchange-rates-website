<?php

namespace Kantor\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Silex\Provider\DoctrineServiceProvider;

class Data implements ServiceProviderInterface
{
    protected $db;
    
    public function register(Application $app)
    {
        $app['data'] = $this;
    }

    public function boot(Application $app)
    {
        $app->register(new DoctrineServiceProvider());
        $this->db = $app['db'];
    }
    
    public function getExchangeRates()
    {
        return $this->db->fetchAll('SELECT * FROM `test`');
    }
}