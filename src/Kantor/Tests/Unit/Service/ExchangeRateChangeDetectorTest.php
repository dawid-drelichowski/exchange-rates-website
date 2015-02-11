<?php

namespace Kantor\Tests\Unit\Service;

use Kantor\Service\ExchangeRateChangeDetector;

class ExchangeRateChangeDetectorTest extends \PHPUnit_Framework_TestCase
{
    const RETAIL_KEY = 'retail';

    /**
     * @var ExchangeRateChangeDetector
     */
    private $changeDetector;

    public function setUp()
    {
        $this->changeDetector = new ExchangeRateChangeDetector();
    }

    public function testGetAdded_whenExchangeRatesAdded_returnsAddedExchangeRatesArray()
    {
        $before = $after = $this->getExchangeRatesBeforeChanges();
        $added = $this->getDifferentExchangeRate();
        $after[self::RETAIL_KEY][] = $added;
        $this->changeDetector->detect($before, $after);

        $this->assertSame(array($added), $this->changeDetector->getAdded());
    }

    public function testGetAdded_whenNoExchangeRatesAdded_returnsEmptyArray()
    {
        $before = $after = $this->getExchangeRatesBeforeChanges();
        $this->changeDetector->detect($before, $after);

        $this->assertSame(array(), $this->changeDetector->getAdded());
    }

    public function testGetUpdated_whenExchangeRatesUpdated_returnsUpdatedExchangeRatesArray()
    {
        $before = $after = $this->getExchangeRatesBeforeChanges();
        $updated = $this->getDifferentExchangeRate();
        $after[self::RETAIL_KEY][0] = $updated;
        $this->changeDetector->detect($before, $after);

        $this->assertSame(array($updated), $this->changeDetector->getUpdated());
    }

    public function testGetUpdated_whenNoExchangeRatesUpdated_returnsEmptyArray()
    {
        $before = $after = $this->getExchangeRatesBeforeChanges();
        $this->changeDetector->detect($before, $after);

        $this->assertSame(array(), $this->changeDetector->getUpdated());
    }

    public function testGetRemoved_whenExchangeRatesRemoved_returnsRemovedExchangeRatesArray()
    {
        $before = $after = $this->getExchangeRatesBeforeChanges();
        $removed = $after[self::RETAIL_KEY][0];
        unset($after[self::RETAIL_KEY][0]);
        $this->changeDetector->detect($before, $after);

        $this->assertSame(array($removed), $this->changeDetector->getRemoved());
    }

    public function testGetRemoved_whenNoExchangeRatesRemoved_returnsEmptyArray()
    {
        $before = $after = $this->getExchangeRatesBeforeChanges();
        $this->changeDetector->detect($before, $after);

        $this->assertSame(array(), $this->changeDetector->getRemoved());
    }

    public function testDetect_whenExchangeRatesAddedUpdatedAndRemoved()
    {
        $before = $after = $this->getExchangeRatesBeforeChanges();
        $added = $updated = $this->getDifferentExchangeRate();
        $after[self::RETAIL_KEY][] = $added;
        $after[self::RETAIL_KEY][0] = $updated;
        $removed = $after[self::RETAIL_KEY][1];
        unset($after[self::RETAIL_KEY][1]);
        $this->changeDetector->detect($before, $after);

        $this->assertSame(array($added), $this->changeDetector->getAdded());
        $this->assertSame(array($updated), $this->changeDetector->getUpdated());
        $this->assertSame(array($removed), $this->changeDetector->getRemoved());
    }

    public function testDetect_whenNoExchangeRatesAddedUpdatedAndRemoved()
    {
        $before = $after = $this->getExchangeRatesBeforeChanges();
        $this->changeDetector->detect($before, $after);

        $this->assertSame(array(), $this->changeDetector->getAdded());
        $this->assertSame(array(), $this->changeDetector->getUpdated());
        $this->assertSame(array(), $this->changeDetector->getRemoved());
    }

    /**
     * @return array
     */
    private function getExchangeRatesBeforeChanges()
    {
        return array (
            self::RETAIL_KEY => array (
                array (
                    'id' => 1,
                    'typeId' => 1,
                    'currency' => 'EUR',
                    'purchase' => 4,
                    'sale' => 4.5
                ),
                array (
                    'id' => 2,
                    'typeId' => 1,
                    'currency' => 'GBP',
                    'purchase' => 5,
                    'sale' => 5.4
                )
            )
        );
    }

    /**
     * @return array
     */
    private function getDifferentExchangeRate()
    {
        return array(
            'id' => 4,
            'typeId' => 1,
            'currency' => 'CHF',
            'purchase' => 4,
            'sale' => 3,
        );
    }
}