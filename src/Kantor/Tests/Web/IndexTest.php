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
        $crawler = $this->client->request('GET', '/');
        $this->assertTrue($this->client->getResponse()->isOk());
    }
    
    public function testIndexPolishCharacters()
    {
        $crawler = $this->client->request('GET', '/');
        $this->assertTrue($this->client->getResponse()->isOk());
        $this->assertRegExp('/Węgry/', $this->client->getResponse()->getContent());
    }
    
    public function testAdminNoPermissions()
    {
        $crawler = $this->client->request('GET', '/admin');
        $this->assertEquals(401, $this->client->getResponse()->getStatusCode());
    }
}