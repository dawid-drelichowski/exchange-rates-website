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

    /**
     * @param array $before
     * @param array $added
     * @dataProvider exchangeRatesDataProvider
     */
    public function testGetAdded_whenExchangeRatesAdded_returnsAddedExchangeRatesArray(array $before, array $added)
    {
        $after = $before;
        $after[self::RETAIL_KEY][] = $added;
        $this->changeDetector->detect($before, $after);

        $this->assertAdded(array($added));
    }

    /**
     * @param array $before
     * @dataProvider exchangeRatesDataProvider
     */
    public function testGetAdded_whenNoExchangeRatesAdded_returnsEmptyArray(array $before)
    {
        $after = $before;
        $this->changeDetector->detect($before, $after);

        $this->assertAdded();
    }

    /**
     * @param array $before
     * @param array $updated
     * @dataProvider exchangeRatesDataProvider
     */
    public function testGetUpdated_whenExchangeRatesUpdated_returnsUpdatedExchangeRatesArray(array $before, array $updated)
    {
        $after = $before;
        $after[self::RETAIL_KEY][0] = $updated;
        $this->changeDetector->detect($before, $after);

        $this->assertUpdated(array($updated));
    }

    /**
     * @param array $before
     * @dataProvider exchangeRatesDataProvider
     */
    public function testGetUpdated_whenNoExchangeRatesUpdated_returnsEmptyArray(array $before)
    {
        $after = $before;
        $this->changeDetector->detect($before, $after);

        $this->assertUpdated();
    }

    /**
     * @param array $before
     * @dataProvider exchangeRatesDataProvider
     */
    public function testGetRemoved_whenExchangeRatesRemoved_returnsRemovedExchangeRatesArray(array $before)
    {
        $after = $before;
        $removed = $after[self::RETAIL_KEY][0];
        unset($after[self::RETAIL_KEY][0]);
        $this->changeDetector->detect($before, $after);

        $this->assertRemoved(array($removed));
    }

    /**
     * @param array $before
     * @dataProvider exchangeRatesDataProvider
     */
    public function testGetRemoved_whenNoExchangeRatesRemoved_returnsEmptyArray(array $before)
    {
        $after = $before;
        $this->changeDetector->detect($before, $after);

        $this->assertRemoved();
    }

    /**
     * @param array $before
     * @param array $added
     * @dataProvider exchangeRatesDataProvider
     */
    public function testDetect_whenExchangeRatesAddedUpdatedAndRemoved(array $before, array $added)
    {
        $after = $before;
        $after[self::RETAIL_KEY][] = $added;
        $after[self::RETAIL_KEY][0] = $added;
        $removed = $after[self::RETAIL_KEY][1];
        unset($after[self::RETAIL_KEY][1]);
        $this->changeDetector->detect($before, $after);

        $this->assertOperationsDone(array($added), array($added), array($removed));
    }

    /**
     * @param array $before
     * @dataProvider exchangeRatesDataProvider
     */
    public function testDetect_whenNoExchangeRatesAddedUpdatedAndRemoved(array $before)
    {
        $after = $before;
        $this->changeDetector->detect($before, $after);

        $this->assertOperationsDone();
    }

    /**
     * @return array
     */
    public function exchangeRatesDataProvider()
    {
        return array(
            array(
                $this->getExchangeRatesBeforeChanges(),
                $this->getDifferentExchangeRate()
            )
        );
    }

    /**
     * @param array $expected
     */
    private function assertAdded(array $expected = array())
    {
        $this->assertSame($expected, $this->changeDetector->getAdded());
    }

    /**
     * @param array $expected
     */
    private function assertUpdated(array $expected = array())
    {
        $this->assertSame($expected, $this->changeDetector->getUpdated());
    }

    /**
     * @param array $expected
     */
    private function assertRemoved(array $expected = array())
    {
        $this->assertSame($expected, $this->changeDetector->getRemoved());
    }

    /**
     * @param array $added
     * @param array $updated
     * @param array $removed
     */
    private function assertOperationsDone(array $added = array(), array $updated = array(), $removed = array()) {
        $this->assertAdded($added);
        $this->assertUpdated($updated);
        $this->assertRemoved($removed);
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