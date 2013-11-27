<?php

namespace Kantor\Tests\Web;

class IndexTest extends TestCase
{
    private $client;
    
    public function setUp()
    {
        parent::setUp();
        $this->client = $this->createClient();
    }
    
    public function testIndexOk()
    {
        $this->client->request('GET', '/');
        $this->assertTrue($this->client->getResponse()->isOk());
    }
    
    public function testIndexPolishCharacters()
    {
        $this->client->request('GET', '/');
        $this->assertTrue($this->client->getResponse()->isOk());
        $this->assertRegExp('/Węgry/', $this->client->getResponse()->getContent());
    }
    
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