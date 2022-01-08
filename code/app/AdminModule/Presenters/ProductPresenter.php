<?php

namespace App\AdminModule\Presenters;

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
class ProductPresenter extends BasePresenter
{
    /** @var ProductsFacade $productsFacade */
    private $productsFacade;
    /** @var ProductEditFormFactory $productEditFormFactory */
    private $productEditFormFactory;
    /** @var FilesFacade $filesFacade */
    private $filesFacade;

    /**
     * Akce pro vykreslení seznamu produktů
     */
    public function renderDefault(): void
    {
        $this->template->products = $this->productsFacade->findProducts(['order' => 'title']);
    }

    /**
     * Akce pro úpravu jednoho produktu
     * @param int $id
     * @throws \Nette\Application\AbortException
     */
    public function renderEdit(int $id): void
    {
        try {
            $product = $this->productsFacade->getProduct($id);
        } catch (\Exception $e) {
            $this->flashMessage('Požadovaný produkt nebyl nalezen.', 'error');
            $this->redirect('default');
        }
        if (!$this->user->isAllowed($product, 'edit')) {
            $this->flashMessage('Požadovaný produkt nemůžete upravovat.', 'error');
            $this->redirect('default');
        }

        $form = $this->getComponent('productEditForm');
        $form->setDefaults($product);
        $this->template->product = $product;
    }

    /**
     * Formulář na editaci produktů
     * @return ProductEditForm
     */
    public function createComponentProductEditForm(): ProductEditForm
    {
        $product = null;

        $id = $this->presenter->getParameter("id");

        if ($id) {
            try {
                $product = $this->productsFacade->getProduct($id);
            } catch (\Exception $e) {
            }
        }

        $form = $this->productEditFormFactory->create($product);

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

        $grid->setPrimaryKey('product_id');
        $grid->setDataSource($this->productsFacade->getDataGridConnection());
        $grid->addColumnText('title', 'Název')->setSortable();
        $grid->addColumnText('price', 'Cena')->setSortable();

        $grid->addColumnText('edit', 'Editovat')
             ->setTemplate(__DIR__ . '/templates/Product/grid/edit.latte');

        return $grid;
    }


    public function handleDeletePhoto(int $productId, int $photoId)
    {
        $product = $this->productsFacade->getProduct($productId);
        $file = $this->filesFacade->getFile($photoId);

        $product->removeFromFiles($file);
        $this->productsFacade->saveProduct($product);

        $this->redrawControl('imageList');
    }

    #region injections
    public function injectProductsFacade(ProductsFacade $productsFacade)
    {
        $this->productsFacade = $productsFacade;
    }

    public function injectProductEditFormFactory(ProductEditFormFactory $productEditFormFactory)
    {
        $this->productEditFormFactory = $productEditFormFactory;
    }

    public function injectFilesFacade(FilesFacade $filesFacade)
    {
        $this->filesFacade = $filesFacade;
    }
    #endregion injections

}
