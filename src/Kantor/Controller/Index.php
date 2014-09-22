<?php
namespace Kantor\Controller;

use Silex\Application;
use Kantor\Provider\Data;

class Index
{
    public function index(Application $app)
    {
        return $app['twig']->render('index.twig', array(
            'retail' => $app['data']->getExchangeRatesByTypeId(Data::TYPE_RETAIL),
            'wholesale' => $app['data']->getExchangeRatesByTypeId(Data::TYPE_WHOLESALE)
        )); 
    }
}