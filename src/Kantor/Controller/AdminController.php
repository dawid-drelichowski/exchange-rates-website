<?php
namespace Kantor\Controller;

use Kantor\Form\ExchangeRateType;
use Kantor\Service\ExchangeRateChangeDetector;
use Kantor\Service\ExchangeRateManager;
use Silex\Application;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;


class AdminController
{
    /**
     * @var Application
     */
    private $app;

    /**
     * @param Request $request
     * @param Application $app
     * @return string
     */
    public function index(Request $request, Application $app)
    {
        $this->app = $app;
        $this->registerServices($app);
        
        $rates = array(
            'retail' => $app['exchangeRate']->getByTypeId(ExchangeRateManager::TYPE_RETAIL),
            'wholesale' => $app['exchangeRate']->getByTypeId(ExchangeRateManager::TYPE_WHOLESALE)
        );

        /** @var Form $form */
        $form = $app['form.factory']->createBuilder('form', $rates)
            ->add('retail', 'collection', array(
                'type' => new ExchangeRateType(),
                'allow_add' => true,
                'allow_delete' => true
            ))
            ->add('wholesale', 'collection', array(
                'type' => new ExchangeRateType(),
                'allow_add' => true,
                'allow_delete' => true
            ))
            ->getForm();
        
        $before = $form->getData();
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $changesDetector = $this->detectChanges($before, $form->getData());
            $this->persist($changesDetector);
        }
        
        return $app['twig']->render('admin.twig', array(
            'form' => $form->createView()
        )); 
    }

    private function registerServices()
    {
        $this->app->register(new FormServiceProvider());
        $this->app->register(new ValidatorServiceProvider());
    }

    /**
     * @param array $before
     * @param array $after
     * @return ExchangeRateChangeDetector
     */
    private function detectChanges(array $before, array $after)
    {
        $changeDetector = new ExchangeRateChangeDetector();
        $changeDetector->detect($before, $after);
        return $changeDetector;
    }

    /**
     * @param ExchangeRateChangeDetector $changeDetector
     */
    private function persist(ExchangeRateChangeDetector $changeDetector)
    {
        $this->remove($changeDetector->getRemoved());
        $this->add($changeDetector->getAdded());
        $this->update($changeDetector->getUpdated());
    }

    /**
     * @param array $added
     */
    private function add(array $added)
    {
        foreach ($added as $item) {
            $this->app['exchangeRate']->add($item);
        }
    }

    /**
     * @param array $removed
     */
    private function remove(array $removed)
    {
        foreach ($removed as $item) {
            $this->app['exchangeRate']->remove((int) $item['id']);
        }
    }

    /**
     * @param array $updated
     */
    private function update(array $updated)
    {
        foreach ($updated as $item) {
            $this->app['exchangeRate']->update($item, (int) $item['id']);
        }
    }
}