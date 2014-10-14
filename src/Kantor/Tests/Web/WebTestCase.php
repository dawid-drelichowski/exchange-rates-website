<?php

namespace Kantor\Tests\Web;

use Silex\Application;
use Silex\WebTestCase as BaseWebTestCase;
use Symfony\Component\BrowserKit\Client;

abstract class WebTestCase extends BaseWebTestCase
{
    /**
     * @var Client
     */
    protected $client;

    public function setUp()
    {
        parent::setUp();
        $this->client = $this->createClient();
    }

    /**
     * @return Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../../../../src/app.php';
        $app['debug'] = true;
        $app['exception_handler']->disable();
        
        return $app;
    }
}