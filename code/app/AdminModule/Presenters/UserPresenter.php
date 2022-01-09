<?php

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\UserEditForm\UserEditForm;
use App\AdminModule\Components\UserEditForm\UserEditFormFactory;
use App\Model\Facades\UsersFacade;
use Ublaboo\DataGrid\DataGrid;
use App\AdminModule\Components\ProductEditForm\ProductEditForm;
use App\AdminModule\Components\ProductEditForm\ProductEditFormFactory;
use App\Model\Facades\FilesFacade;
use App\Model\Facades\ProductsFacade;
use Tracy\Debugger;

/**
 * Class ProductPresenter
 * @package App\AdminModule\Presenters
 */
class UserPresenter extends BasePresenter
{
    /** @var UsersFacade @inject */
    public $usersFacade;

    /** @var UserEditFormFactory @inject */
    public $userEditFormFactory;

    /**
     * Akce pro vykreslení seznamu produktů
     */
    public function renderDefault(): void
    {

    }

    /**
     * Akce pro úpravu jednoho produktu
     * @param int $id
     * @throws \Nette\Application\AbortException
     */
    public function renderEdit(int $id): void
    {
        try {
            $user = $this->usersFacade->getUser($id);
        } catch (\Exception $e) {
            $this->flashMessage('Požadovaný uživatel nebyl nalezen.', 'error');
            $this->redirect('default');
        }

        if (!$this->user->isAllowed($user, 'edit')) {
            $this->flashMessage('Požadovaného uživatele nemůžete upravovat.', 'error');
            $this->redirect('default');
        }

        $form = $this->getComponent('userEditForm');
        $form->setDefaults($user);

        $this->template->editingUser = $user;
    }

    /**
     * Formulář na editaci produktů
     * @return ProductEditForm
     */
    public function createComponentUserEditForm(): UserEditForm
    {
        $form = $this->userEditFormFactory->create();

        $form->onCancel[] = function () {
            $this->redirect('default');
        };

        $form->onFinished[] = function ($message = null) {
            if (!empty($message)) {
                $this->flashMessage($message);
            }
            $this->redirect('default');
        };

        $form->onFailed[] = function ($message = null) {
            if (!empty($message)) {
                $this->flashMessage($message, 'error');
            }
            $this->redirect('default');
        };

        return $form;
    }

    public function createComponentGrid($name)
    {
        $grid = new DataGrid($this, $name);

        $grid->setPrimaryKey('user_id');
        $grid->setDataSource($this->usersFacade->getDataGridConnection());
        $grid->addColumnText('name', 'Jméno')->setSortable();
        $grid->addColumnText('email', 'E-mail')->setSortable();
        $grid->addColumnText('role_id', 'Role')->setSortable();

        $grid->addColumnText('action', 'Akce')
             ->setTemplate(__DIR__ . '/templates/User/grid/edit.latte');

        return $grid;
    }


    public function actionDelete(int $id)
    {
        if ($id === $this->user->getId()) {
            $this->flashMessage('Svůj účet nemůžete smazat', 'danger');
            return;
        }

        try {
            $user = $this->usersFacade->getUser($id);
        } catch (\Exception $e) {
            $this->flashMessage('Požadovaný uživatel nebyl nalezen', 'danger');
            return;
        }

        try {
            $this->usersFacade->deleteUser($user);
        } catch (\Exception $e) {
            $this->flashMessage('Chyba při smazání uživatele, zkuste to později.', 'danger');
        }


        $this->redirect('default');
    }


}
