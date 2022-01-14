<?php

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\UserEditForm\UserEditForm;
use App\AdminModule\Components\UserEditForm\UserEditFormFactory;
use App\Model\Entities\Order;
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
    /** @var OrderFacade @inject */
    public $orderFacade;

    /**
     * Akce pro vykreslení seznamu produktů
     */
    public function renderDefault(): void
    {

    }

    /**
     * Akce pro vykreslení seznamu produktů
     */
    public function renderEdit(int $id): void
    {
        try {
            $this->template->order = $this->orderFacade->getOrderById($id);
        } catch (\Exception $e) {
            $this->flashMessage('Tato objednávka neexistuje', 'danger');
            $this->redirect('Order:default');
            return;
        }
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

        $grid->setPrimaryKey('order_id');

        $grid->setDataSource($this->orderFacade->getGridDataSource());

        $grid->addColumnText('create_date', 'Datum vytvoření')
            ->setSortable()
            ->setTemplate(__DIR__ . '/templates/Order/grid/dateCreated.latte')
            ->setSort('DESC');

        $grid->addColumnText('num_products', 'Počet produktů')
             ->setSortable();

        $grid->addColumnText('total_price', 'Cena')
             ->setSortable();

        $grid->addColumnText('last_modified', 'Poslední změna')
             ->setSortable();

        $grid->addColumnText('state', 'Stav')
             ->setRenderer(function ($row) {
                 return Order::getStateName($row->state);
             })
             ->setSortable();

        return $grid;
    }
}
