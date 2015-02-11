<?php
namespace Kantor\Controller;

use Kantor\Service\ExchangeRateDAO;
use Silex\Application;

class IndexController
{
    /**
     * @param Application $app
     * @return string
     */
    public function index(Application $app)
    {
        return $app['twig']->render('index.twig', array(
            'retail' => $app['exchangeRate']->getByTypeId(ExchangeRateDAO::TYPE_RETAIL),
            'wholesale' => $app['exchangeRate']->getByTypeId(ExchangeRateDAO::TYPE_WHOLESALE)
        )); 
    }
}