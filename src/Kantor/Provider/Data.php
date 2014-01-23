<?php

namespace Kantor\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Silex\Provider\DoctrineServiceProvider;

class Data implements ServiceProviderInterface
{
    const TABLE_NAME = 'ExchangeRate';
    
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
    
    public function getExchangeRates()
    {
        $query = sprintf('SELECT * FROM `%s`', self::TABLE_NAME);
        return $this->db->fetchAll($query);
    }
    
    public function getExchangeRatesByTypeId($typeId)
    {
        $query = sprintf('SELECT * FROM `%s` WHERE `typeId` = ?', self::TABLE_NAME);
        return $this->db->fetchAll($query, array($typeId));
    }
    
    public function updateExchangeRate(array $data, $id)
    {
        return $this->db->executeUpdate('CALL `updateExchangeRate`(?, ?, ?, ?, ?, ?)', array(
            $id, $data['typeId'], $data['country'], $data['currency'], $data['purchase'], $data['sale']
        ));
    }
    
    public function addExchangeRate(array $data)
    {
        return $this->db->insert(self::TABLE_NAME, $data);
    }
    
    public function removeExchangeRate($id)
    {
        return $this->db->delete(self::TABLE_NAME, array('id' => $id));
    }
}