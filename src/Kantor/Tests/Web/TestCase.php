<?php

namespace Kantor\Tests\Web;

use Silex\WebTestCase;

abstract class TestCase extends WebTestCase
{
    
    protected $client;
    
    public function setUp()
    {
        parent::setUp();
        $this->client = $this->createClient();
    }
    
    public function createApplication()
    {
        $app = require __DIR__.'/../../../../src/app.php';
        $app['debug'] = true;
        $app['exception_handler']->disable();
        
        return $app;
    }
}