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
            ->add('currentPurchase', 'number')
            ->add('currentSale', 'number')
            ->add('typeId', 'hidden');
    }

    public function getName()
    {
        return 'exchange_rate';
    }
}