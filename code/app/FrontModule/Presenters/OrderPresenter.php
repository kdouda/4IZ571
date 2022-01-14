<?php

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\CartControl\CartControl;
use App\FrontModule\Components\OrderForm\OrderFormFactory;
use App\Model\Entities\Order;
use App\Model\Facades\OrderFacade;
use Tracy\Debugger;
use Ublaboo\DataGrid\DataGrid;

class OrderPresenter extends BasePresenter
{

    /** @var OrderFormFactory @inject */
    public $orderFormFactory;

    /** @var OrderFacade @inject */
    public $orderFacade;

    public function createComponentOrderForm()
    {
        $form = $this->orderFormFactory->create();

        $form->onCancel[] = function () {
          $this->redirect('Cart:default');
        };

        $form->onFinished[] = function () {
            $this->redirect('Order:list');
        };

        return $form;
    }

    public function createComponentGrid($name)
    {
        $grid = new DataGrid($this, $name);

        $grid->setPrimaryKey('order_id');

        $grid->setDataSource($this->orderFacade->getGridDataSourceForUser($this->user));

        $grid->addColumnText('create_date', 'Datum vytvoření')
             ->setSortable()
             ->setTemplate(__DIR__ . '/templates/Order/grid/dateCreated.latte');

        $grid->addColumnText('num_products', 'Počet produktů')->setSortable();

        $grid->addColumnText('total_price', 'Cena')->setSortable();

        $grid->addColumnText('last_modified', 'Poslední změna')->setSortable();

        $grid->addColumnText('state', 'Stav')->setRenderer(function ($row) {
            return Order::getStateName($row->state);
        })->setSortable();

        return $grid;
    }

    public function createComponentDetailGrid($order)
    {
        $grid = new DataGrid(null, 'detail');

        $grid->setPrimaryKey('p.title');

        $grid->setDataSource($this->orderFacade->getGridDataSourceForOrder($this->getParameter('id')));

        $grid->addColumnText('p.title', 'Produkt')->setSortable();

        $grid->addColumnText('products', 'Počet produktů')->setSortable();

        $grid->addColumnText('total_price', 'Cena')->setSortable();

        $grid->addColumnText('o.create_date', 'Datum vytvoření')->setSortable();

        $grid->addColumnText('state', 'Stav')->setSortable();

        return $grid;
    }

    public function renderDetail(int $id)
    {
        try {
            $order = $this->orderFacade->getOrderById($id);
        } catch (\Exception $e) {
            $this->flashMessage('Tato objednávka neexistuje nebo není dostupná', 'error');
            $this->redirect('Order:list');
        }

        $this->template->order = $order;
    }

    public function renderDefault()
    {
        /** @var CartControl $cart */
        $cart = $this->getComponent('cart');

        if (!$cart->hasAnyItemsInCart()) {
            $this->flashMessage('Nemáte žádné věci v košíku!', 'danger');
            $this->redirect('Cart:default');
        }

        if (!$this->user->isLoggedIn()) {
            $this->flashMessage('Pro objednání se přihlašte', 'success');
            $this->redirect('User:login');
        }

    }

}