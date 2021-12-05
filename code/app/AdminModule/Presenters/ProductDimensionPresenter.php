<?php

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\CategoryEditForm\CategoryEditForm;
use App\AdminModule\Components\CategoryEditForm\CategoryEditFormFactory;
use App\AdminModule\Components\productDimensionEditForm\productDimensionEditForm;
use App\AdminModule\Components\productDimensionEditForm\productDimensionEditFormFactory;
use App\AdminModule\Components\ProductDimensionForm\ProductDimensionForm;
use App\AdminModule\Components\ProductDimensionForm\ProductDimensionFormFactory;
use App\Model\Facades\CategoriesFacade;
use App\Model\Facades\DimensionsFacade;
use App\Model\Facades\ProductDimensionsFacade;
use App\Model\Facades\ProductsFacade;
use Tracy\Debugger;

/**
 * Class CategoryPresenter
 * @package App\AdminModule\Presenters
 */
class ProductDimensionPresenter extends BasePresenter
{
    /** @var ProductDimensionsFacade $productDimensionsFacade */
    private $productDimensionsFacade;

    /** @var ProductsFacade $productsFacade */
    private $productsFacade;

    /** @var ProductDimensionFormFactory $productDimensionEditFormFactory */
    private $productDimensionEditFormFactory;

    /**
     * Akce pro úpravu jedné dimenze
     * @param int $id
     * @throws \Nette\Application\AbortException
     */
    public function renderEdit(int $id): void
    {
        try {
            $productDimension = $this->productDimensionsFacade->getProductDimension($id);
            $product = $productDimension->product;
        } catch (\Exception $e) {
            $this->flashMessage('Požadovaná dimenze nebyla nalezena.', 'error');
            $this->redirect('default');
        }
        
        $form = $this->getComponent('productDimensionEditForm');
        $form->setDefaults($productDimension);
        $this->template->product = $product;
    }

    public function renderAdd(int $productId) : void
    {
        try {
            $product = $this->productsFacade->getProduct($productId);
        } catch (\Exception $e) {
            $this->flashMessage('Produkt neexistuje.', 'error');
            $this->redirect('Admin:Product:default');
        }

        $form = $this->getComponent('productDimensionEditForm');
        $form->setDefaults(["productId" => $productId]);
        $this->template->product = $product;

    }

    /**
     * Akce pro smazání dimenze
     * @param int $id
     * @throws \Nette\Application\AbortException
     */
    public function actionDelete(int $id): void
    {
        try {
            $productDimension = $this->productDimensionsFacade->getProductDimension($id);
            $productId = $productDimension->product->productId;
        } catch (\Exception $e) {
            $this->flashMessage('Požadovaná dimenze nebyla nalezena.', 'error');
            $this->redirect('Product:default');
        }

        if (!$this->user->isAllowed($productDimension, 'delete')) {
            $this->flashMessage('Tuto dimenzi není možné smazat.', 'error');
            $this->redirect('Product:default');
        }

        if ($this->productDimensionsFacade->deleteProductDimension($productDimension)) {
            $this->flashMessage('Dimenze byla smazána.', 'info');
        } else {
            $this->flashMessage('Tuto dimenzi není možné smazat.', 'error');
        }

        $this->redirect('Product:dimension', ['id' => $productId]);
    }

    /**
     * Formulář na editaci dimenzí
     * @return ProductDimensionForm
     */
    public function createComponentProductDimensionEditForm(): ProductDimensionForm
    {
        $form = $this->productDimensionEditFormFactory->create();

        $form->onCancel[] = function () {
            $this->redirect('Product:default');
        };

        $form->onFinished[] = function ($message = null) {
            if (!empty($message)) {
                $this->flashMessage($message);
            }

            $form = $this->getComponent('productDimensionEditForm');
            $this->redirect('Product:dimension', ['id' => $form->getValues()['productId']]);
        };

        $form->onFailed[] = function ($message = null) {
            if (!empty($message)) {
                $this->flashMessage($message, 'error');
            }

            $form = $this->getComponent('productDimensionEditForm');
            $this->redirect('Product:dimension', ['id' => $form->getValues()['productId']]);
        };

        return $form;
    }

    #region injections
    public function injectDimensionsFacade(ProductDimensionsFacade $dimensionsFacade)
    {
        $this->productDimensionsFacade = $dimensionsFacade;
    }

    public function injectCategoryEditFormFactory(ProductDimensionFormFactory $productDimensionEditFormFactory)
    {
        $this->productDimensionEditFormFactory = $productDimensionEditFormFactory;
    }

    public function injectProductsFacade(ProductsFacade $productsFacade)
    {
        $this->productsFacade = $productsFacade;
    }
    #endregion injections

}
