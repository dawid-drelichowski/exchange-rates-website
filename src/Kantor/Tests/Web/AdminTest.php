<?php

namespace Kantor\Tests\Web;

class AdminTest extends TestCase
{
    public function testAdminNoPermissions()
    {
        $this->client->request('GET', '/admin');
        $this->assertEquals(401, $this->client->getResponse()->getStatusCode());
    }
    
    public function testAdminOk()
    {
        $this->client->request('GET', '/admin', array(), array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'foo',
        ));
        $this->assertTrue($this->client->getResponse()->isOk());
    }
}