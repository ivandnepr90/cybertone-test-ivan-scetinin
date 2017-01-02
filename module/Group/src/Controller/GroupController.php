<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 25.12.2016
 * Time: 13:48
 */

namespace Group\Controller;


use Group\Form\GroupForm;
use Group\Model\Group;
use Group\Model\GroupTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class GroupController extends AbstractActionController
{
    private $table;

    public function __construct(GroupTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel([
            'groups' => $this->table->fetchAll(),
        ]);
    }

    public function addAction()
    {
        $form = new GroupForm();
        $form->get('submit')->setValue('add');

        $request = $this -> getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $group = new Group();
        $form->setInputFilter($group->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $group->exchangeArray($form->getData());
        $this->table->saveGroup($group);
        return $this->redirect()->toRoute('group');
    }

    public function editAction()
    {
        $groupId = (int) $this->params()->fromRoute('groupId', 0);

        if (0 === $groupId) {
            return $this->redirect()->toRoute('group', ['action' => 'edit']);
        }

        // Retrieve the album with the specified id. Doing so raises
        // an exception if the album is not found, which should result
        // in redirecting to the landing page.
        try {
            $group = $this->table->getGroup($groupId);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('group', ['action' => 'index']);
        }

        $form = new GroupForm();
        $form->bind($group);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['groupId' => $groupId, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($group->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->saveGroup($group);

        // Redirect to album list
        return $this->redirect()->toRoute('group', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $groupId = (int) $this->params()->fromRoute('groupId', 0);
        if(!$groupId) {
            return $this -> redirect()->toRoute('group');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                //$groupId = (int) $request->getPost('groupId');
                $this->table->deleteGroup($groupId);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('group');
        }

        return [
            'groupId'    => $groupId,
            'group' => $this->table->getGroup($groupId),
        ];
    }
}