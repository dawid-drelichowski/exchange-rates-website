<?php

namespace Kantor\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class Index
{
    public function index(Request $request, Application $app)
    {
        return $app['twig']->render('index.twig', array(
            'data' => $app['data']->getExchangeRates()
        )); 
    }
    
    public function admin(Request $request, Application $app)
    {
        return $app['twig']->render('index.twig', array(
            'data' => $app['data']->getExchangeRates()
        )); 
    }
}