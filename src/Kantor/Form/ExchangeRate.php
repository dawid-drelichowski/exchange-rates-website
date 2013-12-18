<?php
namespace Kantor\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ExchangeRate extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('country')
            ->add('currency')
            ->add('purchase', 'number')
            ->add('sale', 'number');
    }

    public function getName()
    {
        return 'exchange_rate';
    }
}