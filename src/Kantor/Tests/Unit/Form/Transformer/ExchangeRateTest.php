<?php

namespace Kantor\Tests\Unit\Form\Transformer;

use Kantor\Form\Transformer\ExchangeRates;

class ExchangeRateTest extends \PHPUnit_Framework_TestCase
{
    private $transformer;
    
    public function setUp()
    {
        $this->transformer = new ExchangeRates();
    }
    
    /**
     * @dataProvider transformerProvider 
     */
    public function testTransformReturnsValueInArray($value)
    {
        $this->assertEquals(
            array(ExchangeRates::RATES_KEY => $value), $this->transformer->transform($value)
        );
    }
    
    /**
     * @dataProvider reverseTransformProperArray
     */
    public function testReverseTransformReturnsRatesArrayKeyValue($value)
    {
        $this->assertEquals(
            $value[ExchangeRates::RATES_KEY], $this->transformer->reverseTransform($value)
        );
    }
    
    /**
     * @expectedException Symfony\Component\Form\Exception\TransformationFailedException
     * @dataProvider reverseTransformNotArray
     */
    public function testReverseTransformThrowsExceptionWhenValueIsNotArray($value)
    {
        $this->transformer->reverseTransform($value);
    }
    
    /**
     * @expectedException Symfony\Component\Form\Exception\TransformationFailedException
     * @dataProvider reverseTransformValueKeyDoesNotExists
     */
    public function testReverseTransformThrowsExceptionWhenValueKeyDoesNotExists($value)
    {
        $this->transformer->reverseTransform($value);
    }
    
    public function transformerProvider()
    {
        return array(
            array(null),
            array(true),
            array(false),
            array(array()),
            array(array('test' => 'text')),
            array(new \stdClass),
            array(1),
            array(1.5),
            array('test'),
        );
    }
    
    public function reverseTransformProperArray()
    {
        return array(
            array(self::generateArrayForReverseTransform(null)),
            array(self::generateArrayForReverseTransform(true)),
            array(self::generateArrayForReverseTransform(false)),
            array(self::generateArrayForReverseTransform(array())),
            array(self::generateArrayForReverseTransform(array('test' => 'text'))),
            array(self::generateArrayForReverseTransform(new \stdClass)),
            array(self::generateArrayForReverseTransform(1)),
            array(self::generateArrayForReverseTransform(1.5)),
            array(self::generateArrayForReverseTransform('test')),
        );
    }

    public function reverseTransformNotArray()
    {
        return array(
            array(null),
            array(true),
            array(false),
            array(1),
            array(1.5),
            array(new \stdClass)
        );
    }
    
    public function reverseTransformValueKeyDoesNotExists()
    {
        return array(
            array(array()),
            array(array(true)),
            array(array(false)),
            array(array(1)),
            array(array('test')),
            array(array('test' => 'test')),
        );
    }

    private static function generateArrayForReverseTransform($value)
    {
        return array(ExchangeRates::RATES_KEY => $value);
    }
}