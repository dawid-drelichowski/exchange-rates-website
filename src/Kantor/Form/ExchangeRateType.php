<?php
namespace Kantor\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class ExchangeRateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('country', 'text', array(
            'attr' => array('maxlength' => 50),
            'constraints' => array(
                new NotBlank(),
                new Length(array('max' => 50)),
            )
        ))
            ->add('currency', 'text', array(
                'attr' => array('maxlength' => 10),
                'constraints' => array(
                    new NotBlank(),
                    new Length(array('max' => 10)),
                )
            ))
            ->add('purchase', 'money', array(
                'currency' => '',
                'precision' => 4,
                'constraints' => array(
                    new Range(array('min' => 0))
                )
            ))
            ->add('sale', 'money', array(
                'currency' => '',
                'precision' => 4,
                'constraints' => array(
                    new Range(array('min' => 0))
                )
            ))
            ->add('typeId', 'hidden');
    }

    public function getName()
    {
        return 'exchangeRate';
    }
}