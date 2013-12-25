<?php
namespace Kantor\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Kantor\Provider\Data;

class Index
{
    public function index(Request $request, Application $app)
    {
        return $app['twig']->render('index.twig', array(
            'retail' => $app['data']->getExchangeRatesByTypeId(Data::TYPE_RETAIL),
            'wholesail' => $app['data']->getExchangeRatesByTypeId(Data::TYPE_WHOLESALE)
        )); 
    }
}