<?php

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\CartControl\CartControl;
use App\FrontModule\Components\ProductCard\ProductCard;
use App\FrontModule\Components\ProductCard\ProductCardFactory;
use App\FrontModule\Components\ProductCartForm\ProductCartForm;
use App\FrontModule\Components\ProductCartForm\ProductCartFormFactory;
use App\Model\Facades\CategoriesFacade;
use App\Model\Facades\ProductsFacade;
use Nette;
use Nette\Application\BadRequestException;
use Nette\Application\UI\Multiplier;
use Nette\Security;

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

        $this->template->product = $product;
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
    public function renderList(int $category = null, int $limit = null, int $offset = null): void
    {
        $categories = [];

        $productsQuery = [
            'order' => 'title'
        ];

        if ($category) {
            $categories[] = $category;
        }

        //TODO tady by mělo přibýt filtrování podle kategorie, stránkování atp.
        $this->template->products = $this->productsFacade->filterAllBy($productsQuery, $categories, $limit, $offset);
        $this->template->categories = $this->categoriesFacade->findCategories(['order' => 'title']);
        $this->template->currentCategory = $category;
        $this->template->canEdit = $this->currentUser->isLoggedIn() && $this->currentUser->isAllowed($this->template->products[0], 'edit');
    }

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