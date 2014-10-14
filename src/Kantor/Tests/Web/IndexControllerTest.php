<?php

namespace Kantor\Tests\Web;

class IndexControllerTest extends WebTestCase
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