<?php

namespace Kantor\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ExchangeRates implements DataTransformerInterface
{
    const RATES_KEY = 'rates';
    
    public function transform($value)
    {
        return array(self::RATES_KEY => $value);
    }
    
    public function reverseTransform($value)
    {
        if (!is_array($value)) {
            throw new TransformationFailedException(
                'ExchangeRates reverse tranformation failed: value is not an array'
            );
        }
        
        if (!array_key_exists(self::RATES_KEY, $value)) {
            throw new TransformationFailedException(sprintf(
                'ExchangeRates reverse tranformation failed: key "%s" does not exists',
                self::RATES_KEY
            ));
        }
        
        return $value[self::RATES_KEY];
    }
}