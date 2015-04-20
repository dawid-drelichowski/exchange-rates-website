<?php
namespace Kantor\Tests\Web;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DomCrawler\Form;

class AdminControllerTest extends WebTestCase
{
    public function testAdminNoPermissions()
    {
        $this->client->request('GET', '/admin');
        $this->assertEquals(401, $this->client->getResponse()->getStatusCode());
    }

    public function testAdminLoginOk()
    {
        $this->logIn();
        $this->assertTrue($this->client->getResponse()->isOk());
    }

    /**
     * @depends testAdminLoginOk
     */
    public function testAdminUpdate()
    {
        $expectedValues = array(
            'form' => array(
                'retail' => array( array(
                    'country' => 'Updated country',
                    'currency' => 'UC',
                    'purchase' => '1,1000',
                    'sale' => '1,2000',
                    'typeId' => '1'
                ))
            )
        );
        $crawler = $this->logIn();
        $form = $this->getExchangeRateForm($crawler);
        $form->setValues($expectedValues);
        $crawler = $this->client->submit($form);
        $form = $this->getExchangeRateForm($crawler);
        $currentValues = $form->getPhpValues();
        $this->assertSame($expectedValues['form']['retail'][0], $currentValues['form']['retail'][0]);
    }

    /**
     * @return Crawler;
     */
    private function logIn()
    {
        return $this->client->request('GET', '/admin', array(), array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'foo',
        ));
    }

    /**
     * @param Crawler $crawler
     * @return Form
     */
    private function getExchangeRateForm(Crawler $crawler)
    {
        return $crawler->selectButton('submit')->form();
    }
}