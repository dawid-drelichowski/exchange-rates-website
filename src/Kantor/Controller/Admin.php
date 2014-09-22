<?php
namespace Kantor\Controller;

use Silex\Application;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Symfony\Component\HttpFoundation\Request;
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
        
        $rates = array(
            'retail' =>  $this->dataProvider->getExchangeRatesByTypeId(Data::TYPE_RETAIL),
            'wholesale' =>  $this->dataProvider->getExchangeRatesByTypeId(Data::TYPE_WHOLESALE)
        );
        
        $form = $app['form.factory']->createBuilder('form', $rates)
            ->add('retail', 'collection', array(
                'type' => new ExchangeRate(),
                'allow_add' => true,
                'allow_delete' => true
            ))
            ->add('wholesale', 'collection', array(
                'type' => new ExchangeRate(),
                'allow_add' => true,
                'allow_delete' => true
            ))
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
        $removed = $added = $updated = array();
        
        foreach ($before as $type => $rates) {
            $removed = array_merge($removed, array_diff_key($rates, $after[$type]));
            
            $added = array_merge($added, array_diff_key($after[$type], $rates));

            $updated = array_merge($updated, array_udiff_assoc(
                array_diff_key($after[$type], $added),
                $rates,
                function($first, $second) {
                    if ($first == $second) {
                        return 0;
                    }
                    return 1;
                }
            ));
        }

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