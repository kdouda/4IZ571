<?php

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\CartControl\CartControl;
use App\FrontModule\Components\ProductCard\ProductCard;
use App\FrontModule\Components\ProductCard\ProductCardFactory;
use App\FrontModule\Components\ProductCartForm\ProductCartForm;
use App\FrontModule\Components\ProductCartForm\ProductCartFormFactory;
use App\Model\Entities\Product;
use App\Model\Facades\CategoriesFacade;
use App\Model\Facades\ProductsFacade;
use Nette;
use Nette\Application\BadRequestException;
use Nette\Application\UI\Multiplier;
use Nette\Security;
use Tracy\Debugger;

/**
 * Class ProductPresenter
 * @package App\FrontModule\Presenters
 * @property string $category
 */
class ProductPresenter extends BasePresenter
{
    /** @var ProductsFacade $productsFacade */
    private $productsFacade;
    /** @var ProductCartFormFactory $productCartFormFactory */
    private $productCartFormFactory;

    /** @var CategoriesFacade $categoriesFacade */
    private $categoriesFacade;

    /**
     * @var ProductCardFactory $productCardFactory
     */
    private $productCardFactory;

    /** @persistent */
    public $category;

    /** @persistent  */
    public $page = 1;

    /**
     * @var Security\User
     */
    private $currentUser;

    public function injectUser(Security\User $user)
    {
        $this->currentUser = $user;
    }

    /**
     * Akce pro zobrazení jednoho produktu
     * @param string $url
     * @throws BadRequestException
     */
    public function renderShow(string $url): void
    {
        try {
            $product = $this->productsFacade->getProductByUrl($url);
        } catch (\Exception $e) {
            throw new BadRequestException('Produkt nebyl nalezen.');
        }

        $this->template->isProductInComparison = $this->isProductInComparison($product);
        $this->template->product = $product;
    }

    public function renderComparison() : void
    {
        $productIds = $this->getProductComparisonIds();

        if (count($productIds) <= 1) {
            $this->redirect('Product:list');
        }

        $products = [];

        foreach ($productIds as $productId) {
            try {
                $products[] = $this->productsFacade->getProduct($productId);
            } catch (\Exception $e) {
            }
        }

        $distinctDimensions = [];

        foreach ($products as $product) {
            foreach ($product->dimensions as $dimension) {
                $distinctDimensions[$dimension->dimension->dimensionId] = $dimension->dimension;
            }
        }

        $this->template->dimensions = array_values($distinctDimensions);
        $this->template->products = $products;
        $this->template->productCount = count($products);
        $this->template->dimensionCount = count($distinctDimensions);
    }

    public function handleAddProductToComparison(int $productId) : void
    {
        try {
            $product = $this->productsFacade->getProduct($productId);
        } catch (\Exception $e) {
            throw new BadRequestException('Produkt nebyl nalezen.');
        }

        $this->addProductToComparison($product);

        if ($this->getProductComparisonCount() > 1) {
            $this->redirect('Product:comparison');
        } else {
            $this->redirect('this');
        }
    }

    public function handleRemoveProductComparison(int $productId) : void
    {
        try {
            $product = $this->productsFacade->getProduct($productId);
        } catch (\Exception $e) {
            throw new BadRequestException('Produkt nebyl nalezen.');
        }

        $this->removeProductToComparison($product);

        $this->redirect('this');
    }

    protected function createComponentProductCard(): ProductCard
    {
        return $this->productCardFactory->create();
    }

    protected function createComponentProductCartForm():Multiplier {
        return new Multiplier(function($productId){
            $form = $this->productCartFormFactory->create();
            $form->setDefaults(['productId'=>$productId]);
            $form->onSubmit[]=function(ProductCartForm $form){
                try{
                    $product = $this->productsFacade->getProduct($form->values->productId);
                    //kontrola zakoupitelnosti
                }catch (\Exception $e){
                    $this->flashMessage('Produkt nejde přidat do košíku','error');
                    $this->redirect('this');
                }
                //přidání do košíku
                /** @var CartControl $cart */
                $cart = $this->getComponent('cart');
                $cart->addToCart($product, (int)$form->values->count);
                $this->redirect('this');
            };

            return $form;
        });
    }

    /**
     * Akce pro vykreslení přehledu produktů
     */
    public function renderList(int $category = null): void
    {
        $categories = [];

        $productsQuery = [
            'order' => 'title'
        ];

        if ($category) {
            $categories[] = $category;
        }

        $limit = 5;

        $pagination = new Nette\Utils\Paginator();
        $pagination->setItemCount($this->productsFacade->countAllBy([], $categories));
        $pagination->setPage($this->page);
        $pagination->setItemsPerPage($limit);

        $offset = $pagination->getOffset();

        $this->template->paginator = $pagination;
        $this->template->products = $this->productsFacade->filterAllBy($productsQuery, $categories, $offset, $limit);
        $this->template->categories = $this->categoriesFacade->findCategories(['order' => 'title']);
        $this->template->currentCategory = $category;
        $this->template->canEdit = $this->currentUser->isLoggedIn() && $this->currentUser->isAllowed($this->template->products[0], 'edit');
    }


    #region product comparison
    private function isProductInComparison(Product $product) : bool
    {
        $arr = $this->getSession('comparison')->get('products');

        if (empty($arr)) {
            $arr = [];
            $this->getSession('comparison')->set('products', $arr);

            return false;
        }

        return in_array($product->productId, $arr);
    }

    private function getProductComparisonCount() : int
    {
        $arr = $this->getSession('comparison')->get('products');

        if (empty($arr)) {
            return 0;
        }

        return count($arr);
    }

    private function getProductComparisonIds() : array
    {
        $arr = $this->getSession('comparison')->get('products');

        if (empty($arr)) {
            return [];
        }

        return $arr;
    }

    private function addProductToComparison(Product $product) : void
    {
        $arr = $this->getSession('comparison')->get('products');

        if (empty($arr)) {
            $arr = [];
        }

        $arr[] = $product->productId;

        $this->getSession('comparison')->set('products', $arr);
    }

    private function removeProductToComparison(Product $product) : void
    {
        $arr = $this->getSession('comparison')->get('products');

        if (empty($arr)) {
            $arr = [];
        }

        if (in_array($product->productId, $arr)) {
            $arr = array_diff($arr, [$product->productId]);
        }

        $this->getSession('comparison')->set('products', $arr);
    }
    #endregion injections

    #region injections
    public function injectProductsFacade(ProductsFacade $productsFacade): void
    {
        $this->productsFacade = $productsFacade;
    }

    public function injectProductCartFormFactory(ProductCartFormFactory $productCartFormFactory): void
    {
        $this->productCartFormFactory = $productCartFormFactory;
    }

    public function injectProductCardFactory(ProductCardFactory $productCardFactory): void
    {
        $this->productCardFactory = $productCardFactory;
    }

    public function injectCategoriesFacade(CategoriesFacade $categoriesFacade): void
    {
        $this->categoriesFacade = $categoriesFacade;
    }
    #endregion injections
}