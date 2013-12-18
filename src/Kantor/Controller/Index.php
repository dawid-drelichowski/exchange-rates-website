<?php
namespace Kantor\Controller;

use Silex\Application;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Kantor\Provider\Data;
use Kantor\Form\ExchangeRate;

class Index
{
    public function index(Request $request, Application $app)
    {
        return $app['twig']->render('index.twig', array(
            'retail' => $app['data']->getExchangeRatesByTypeId(Data::TYPE_RETAIL),
            'wholesail' => $app['data']->getExchangeRatesByTypeId(Data::TYPE_WHOLESALE)
        )); 
    }
    
    public function admin(Request $request, Application $app)
    {
        $app->register(new FormServiceProvider());
        $app->register(new ValidatorServiceProvider());
        
        $form = $app['form.factory']->createBuilder()
            ->add('rates', 'collection', array(
                'type' => new ExchangeRate(),
                'allow_add' => true,
                'allow_delete' => true
            ))
            ->getForm();
        
        return $app['twig']->render('admin.twig', array('form' => $form->createView())); 
    }
}