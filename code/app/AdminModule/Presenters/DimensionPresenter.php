<?php

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\CategoryEditForm\CategoryEditForm;
use App\AdminModule\Components\CategoryEditForm\CategoryEditFormFactory;
use App\AdminModule\Components\DimensionEditForm\DimensionEditForm;
use App\AdminModule\Components\DimensionEditForm\DimensionEditFormFactory;
use App\Model\Facades\CategoriesFacade;
use App\Model\Facades\DimensionsFacade;

/**
 * Class CategoryPresenter
 * @package App\AdminModule\Presenters
 */
class DimensionPresenter extends BasePresenter
{
    /** @var DimensionsFacade $dimensionsFacade */
    private $dimensionsFacade;
    /** @var DimensionEditFormFactory $dimensionEditFormFactory */
    private $dimensionEditFormFactory;

    /**
     * Akce pro vykreslení seznamu kategorií
     */
    public function renderDefault(): void
    {
        $this->template->dimensions = $this->dimensionsFacade->findDimensions(['order' => 'name']);
    }

    /**
     * Akce pro úpravu jedné dimenze
     * @param int $id
     * @throws \Nette\Application\AbortException
     */
    public function renderEdit(int $id): void
    {
        try {
            $category = $this->dimensionsFacade->getDimension($id);
        } catch (\Exception $e) {
            $this->flashMessage('Požadovaná dimenze nebyla nalezena.', 'error');
            $this->redirect('default');
        }
        $form = $this->getComponent('dimensionEditForm');
        $form->setDefaults($category);
        $this->template->category = $category;
    }

    /**
     * Akce pro smazání dimenze
     * @param int $id
     * @throws \Nette\Application\AbortException
     */
    public function actionDelete(int $id): void
    {
        try {
            $category = $this->dimensionsFacade->getDimension($id);
        } catch (\Exception $e) {
            $this->flashMessage('Požadovaná dimenze nebyla nalezena.', 'error');
            $this->redirect('default');
        }

        if (!$this->user->isAllowed($category, 'delete')) {
            $this->flashMessage('Tuto dimenzi není možné smazat.', 'error');
            $this->redirect('default');
        }

        if ($this->dimensionsFacade->deleteDimension($category)) {
            $this->flashMessage('Dimenze byla smazána.', 'info');
        } else {
            $this->flashMessage('Tuto dimenzi není možné smazat.', 'error');
        }

        $this->redirect('default');
    }

    /**
     * Formulář na editaci dimenzí
     * @return DimensionEditForm
     */
    public function createComponentDimensionEditForm(): DimensionEditForm
    {
        $form = $this->dimensionEditFormFactory->create();
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

    #region injections
    public function injectDimensionsFacade(DimensionsFacade $dimensionsFacade)
    {
        $this->dimensionsFacade = $dimensionsFacade;
    }

    public function injectCategoryEditFormFactory(DimensionEditFormFactory $dimensionEditFormFactory)
    {
        $this->dimensionEditFormFactory = $dimensionEditFormFactory;
    }
    #endregion injections

}
