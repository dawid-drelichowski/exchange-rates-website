<?php

namespace Kantor\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;

class ExchangeRates implements DataTransformerInterface
{
    public function transform($value)
    {
        return array('rates' => $value);
    }
    
    public function reverseTransform($value)
    {
        return array_shift($value);
    }
}