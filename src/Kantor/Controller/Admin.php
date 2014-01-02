<?php
namespace Kantor\Controller;

use Silex\Application;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Kantor\Form\Transformer\ExchangeRates as ExchangeRatesTransformer;
use Kantor\Form\ExchangeRate;
use Kantor\Provider\Data;

class Admin
{
    
    public function index(Request $request, Application $app)
    {
        $app->register(new FormServiceProvider());
        $app->register(new ValidatorServiceProvider());
        
        $transformer = new ExchangeRatesTransformer();
        $rates = $app['data']->getExchangeRatesByTypeId(Data::TYPE_RETAIL);
        
        $form = $app['form.factory']->createBuilder('form', $rates)
            ->add('rates', 'collection', array(
                'type' => new ExchangeRate(),
                'allow_add' => true,
                'allow_delete' => true
            ))
            ->addModelTransformer($transformer)
            ->getForm();
        
        $before = $form->getData();
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $after = $form->getData();
            $removed = array_diff_assoc($before, $after);
            $added = array_diff_assoc($after, $before);
        }
        
        return $app['twig']->render('admin.twig', array('form' => $form->createView())); 
    }
}