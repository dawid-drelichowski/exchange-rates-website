<?php

namespace Kantor\Tests\Web;

class IndexTest extends TestCase
{
    
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
}