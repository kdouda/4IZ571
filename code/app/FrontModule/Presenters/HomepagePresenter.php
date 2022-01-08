<?php

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\CartControl\CartControl;
use App\FrontModule\Components\ProductCard;
use App\FrontModule\Components\ProductCard\ProductCardFactory;
use App\FrontModule\Components\ProductCartForm\ProductCartForm;
use App\FrontModule\Components\ProductCartForm\ProductCartFormFactory;
use App\Model\Facades\ProductsFacade;
use Nette\Application\UI\Multiplier;

class HomepagePresenter extends BasePresenter
{
    /**
     * @var ProductCardFactory $productCardFactory
     */
    private $productCardFactory;

    /** @var ProductsFacade $productsFacade @inject */
    public $productsFacade;
    /**
     * @var ProductCartFormFactory
     */
    private $productCartFormFactory;

    public function renderDefault(): void
    {
        //TODO tady by mělo přibýt filtrování podle kategorie, stránkování atp.
        $this->template->featuredProducts = $this->productsFacade->findProducts(['order'=>'title']);
        $this->template->isLoggedIn = $this->user->isLoggedIn();
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

    public function injectProductCartFormFactory(ProductCartFormFactory $productCartFormFactory): void
    {
        $this->productCartFormFactory = $productCartFormFactory;
    }

    public function injectProductCardFactory(ProductCardFactory $productCardFactory): void
    {
        $this->productCardFactory = $productCardFactory;
    }
}
