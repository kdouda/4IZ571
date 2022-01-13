<?php

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\UserEditForm\UserEditForm;
use App\AdminModule\Components\UserEditForm\UserEditFormFactory;
use App\Model\Facades\OrderFacade;
use App\Model\Facades\UsersFacade;
use Nette\Application\BadRequestException;
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
class OrderPresenter extends BasePresenter
{
    /** @var UsersFacade @inject */
    public $usersFacade;

    /** @var UserEditFormFactory @inject */
    public $userEditFormFactory;

    /** @var OrderFacade @inject */
    public $orderFacade;

    /**
     * Akce pro vykreslení seznamu produktů
     */
    public function renderDefault(): void
    {

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
        $grid->setDataSource($this->orderFacade->getGridDataSource());
        $grid->addColumnText('name', 'Jméno')->setSortable();
        $grid->addColumnText('email', 'E-mail')->setSortable();
        $grid->addColumnText('role_id', 'Role')->setSortable();

        $grid->addColumnText('action', 'Akce')
             ->setTemplate(__DIR__ . '/templates/User/grid/edit.latte');

        return $grid;
    }
}
