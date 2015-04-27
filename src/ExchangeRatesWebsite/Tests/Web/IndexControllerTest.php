<?php

namespace ExchangeRatesWebsite\Tests\Web;

class IndexControllerTest extends WebTestCase
{
    public function testIndexOk()
    {
        $this->client->request('GET', '/');
        $this->assertTrue($this->client->getResponse()->isOk());
    }
}