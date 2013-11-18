<?php

namespace Kantor\Tests\Web;

use Silex\WebTestCase;

class IndexTest extends WebTestCase
{
    public function createApplication()
    {
        $app = require __DIR__.'/../../../../src/app.php';
        $app['debug'] = true;
        $app['exception_handler']->disable();
        
        return $app;
    }

    public function testIndex()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');
        $this->assertTrue($client->getResponse()->isOk());
    }
}