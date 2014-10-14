<?php
namespace Kantor\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ExchangeRateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('country')
            ->add('currency')
            ->add('purchase', 'number')
            ->add('sale', 'number')
            ->add('typeId', 'hidden');
    }

    public function getName()
    {
        return 'exchangeRate';
    }
}