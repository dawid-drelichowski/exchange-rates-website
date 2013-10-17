<?php

namespace Kantor\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class Index
{
    public function index(Request $request, Application $app)
    {
        return $app['twig']->render('index.twig'); 
    }
}