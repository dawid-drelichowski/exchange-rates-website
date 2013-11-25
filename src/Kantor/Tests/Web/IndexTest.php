<?php

namespace Kantor\Tests\Web;

class IndexTest extends TestCase
{
    public function testOk()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');
        $this->assertTrue($client->getResponse()->isOk());
    }
    
    public function testPolishCharacters()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');
        $this->assertTrue($client->getResponse()->isOk());
        $this->assertRegExp('/Węgry/', $client->getResponse()->getContent());
    }
}