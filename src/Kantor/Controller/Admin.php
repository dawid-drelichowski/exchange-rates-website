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
    
    private $dataProvider;
    
    public function index(Request $request, Application $app)
    {
        $this->dataProvider = $app['data'];
        
        $app->register(new FormServiceProvider());
        $app->register(new ValidatorServiceProvider());
        
        $transformer = new ExchangeRatesTransformer();
        $rates = $this->dataProvider->getExchangeRates();
        
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
            $this->persist($before, $form->getData());
        }
        
        return $app['twig']->render('admin.twig', array(
            'form' => $form->createView()
        )); 
    }
    
    private function persist(array $before, array $after)
    {
        
        $removed = array_diff_key($before, $after);
        $added = array_diff_key($after, $before);
        $updated = array_intersect_key($after, $before);
        
        $this->remove($removed);
        $this->add($added);
        $this->update($updated);
    }
    
    private function add(array $added)
    {
        foreach ($added as $item) {
            $this->dataProvider->addExchangeRate($item);
        }
    }
    
    private function remove(array $removed)
    {
        foreach ($removed as $item) {
            $this->dataProvider->removeExchangeRate((int) $item['id']);
        }
    }
    
    private function update(array $updated)
    {
        foreach ($updated as $item) {
            $this->dataProvider->updateExchangeRate($item, (int) $item['id']);
        }
    }
}