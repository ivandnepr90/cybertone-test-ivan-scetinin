<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 25.12.2016
 * Time: 13:47
 */

namespace Consumer\Controller;


use Consumer\Form\ConsumerForm;
use Consumer\Model\Consumer;
use Consumer\Model\ConsumerTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ConsumerController extends AbstractActionController
{
    private $table;

    public function __construct(ConsumerTable $table)
    {
        $this->table = $table;
    }


    public function indexAction()
    {
        return new ViewModel([
            'consumers' => $this->table->fetchAll(),
        ]);
    }

    public function addAction()
    {
        $form = new ConsumerForm();
        $form->get('submit')->setValue('add');

        $request = $this -> getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $consumer = new Consumer();
        $form->setInputFilter($consumer->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $consumer->exchangeArray($form->getData());
        $this->table->saveConsumer($consumer);
        return $this->redirect()->toRoute('consumer');
    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
    }
}