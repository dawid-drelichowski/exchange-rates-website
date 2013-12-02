<?php

namespace Kantor\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Silex\Provider\DoctrineServiceProvider;

class Data implements ServiceProviderInterface
{
    const TYPE_RETAIL = 1;
    const TYPE_WHOLESALE = 2;
    
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
    
    public function getExchangeRatesByTypeId($typeId)
    {
        return $this->db->fetchAll('SELECT * FROM `ExchangeRate` WHERE `TypeId` = ?', array($typeId));
    }
}