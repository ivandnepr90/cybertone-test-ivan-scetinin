<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 25.12.2016
 * Time: 13:47
 */

namespace Consumer\Controller;

require_once __DIR__ . '/../../../../config/application.run.config.php';

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
        /*return new ViewModel([
            'consumers' => $this->table->fetchAll(),
        ]);*/


        $paginator = $this->table->fetchAll(true);

        // Set the current page to what has been passed in query string,
        // or to 1 if none is set, or the page is invalid:
        $page = (int) $this->params()->fromQuery('page', 1);
        $page = ($page < 1) ? 1 : $page;
        $paginator->setCurrentPageNumber($page);

        // Set the number of items per page to 10:
        $paginator->setItemCountPerPage(10);

        return new ViewModel(['paginator' => $paginator]);
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

        $post = array_merge_recursive(
            $request->getPost()->toArray(),
            $request->getFiles()->toArray()
        );

        $newFilePath = CONSUMER_PHOTOS_PATH . $post['consumerId'] . '.' .pathinfo(basename($post['imageExtention']['name']), PATHINFO_EXTENSION);
        copy($post['imageExtention']['tmp_name'], $newFilePath);
        $post['imageExtention'] = $newFilePath;

        $form->setData($post);

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $consumer->exchangeArray($form->getData());
        $this->table->saveConsumer($consumer);
        return $this->redirect()->toRoute('consumer');
    }

    public function editAction()
    {
        $consumerId = (int) $this->params()->fromRoute('consumerId', 0);

        if (0 === $consumerId) {
            return $this->redirect()->toRoute('consumer', ['action' => 'add']);
        }

        // Retrieve the album with the specified id. Doing so raises
        // an exception if the album is not found, which should result
        // in redirecting to the landing page.
        try {
            $consumer = $this->table->getConsumer($consumerId);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('consumer', ['action' => 'index']);
        }

        $form = new ConsumerForm();
        $form->bind($consumer);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['consumerId' => $consumerId, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($consumer->getInputFilter());

        $post = array_merge_recursive(
            $request->getPost()->toArray(),
            $request->getFiles()->toArray()
        );

        $newFilePath = CONSUMER_PHOTOS_PATH . $post['consumerId'] . '.' .pathinfo(basename($post['imageExtention']['name']), PATHINFO_EXTENSION);
        copy($post['imageExtention']['tmp_name'], $newFilePath);
        $post['imageExtention'] = $newFilePath;

        $form->setData($post);

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->saveConsumer($consumer);

        // Redirect to album list
        return $this->redirect()->toRoute('consumer', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $consumerId = (int) $this->params()->fromRoute('consumerId', 0);
        if(!$consumerId) {
            return $this -> redirect()->toRoute('consumer');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $consumerId = (int) $request->getPost('consumerId');
                $this->table->deleteConsumer($consumerId);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('consumer');
        }

        return [
            'consumerId'    => $consumerId,
            'consumer' => $this->table->getConsumer($consumerId),
        ];
    }
}