<?php

namespace App\FrontModule\Components\ProductCard;

use App\FrontModule\Components\CartControl\CartControl;
use App\FrontModule\Components\ProductCartForm\ProductCartForm;
use App\FrontModule\Components\ProductCartForm\ProductCartFormFactory;
use App\Model\Entities\Cart;
use App\Model\Entities\CartItem;
use App\Model\Entities\Product;
use App\Model\Facades\CartFacade;
use App\Model\Facades\ProductsFacade;
use Nette\Application\UI\Control;
use Nette\Application\UI\Multiplier;
use Nette\Application\UI\Template;
use Nette\Http\Session;
use Nette\Http\SessionSection;
use Nette\Security;
use Tracy\Debugger;

/**
 * Class CartControl
 * @package App\FrontModule\Components
 */
class ProductCard extends Control
{

    /** @var Security\User  */
    private $currentUser;
    /**
     * @var ProductCartFormFactory
     */
    private $productCartFormFactory;
    /**
     * @var ProductsFacade
     */
    private $productsFacade;

    /**
     * @var Product
     */
    private $product;

    public function __construct(Security\User $user, ProductCartFormFactory $productCartFormFactory,ProductsFacade $productsFacade)
    {
        $this->currentUser = $user;
        $this->productsFacade = $productsFacade;
        $this->productCartFormFactory = $productCartFormFactory;
    }

    /**
     * Akce renderující šablonu s odkazem pro zobrazení harmonogramu na desktopu
     * @param array $params = []
     */
    public function render($product):void {
        $template=$this->prepareTemplate('default');
        $template->product = $product;
        $this->product = $product;
        bdump($this->product->productId);
        $this->createComponentProductCartForm();
        $template->canEdit = $this->currentUser->isLoggedIn() && $this->currentUser->isAllowed($product, 'edit');
        $template->render();
    }

    /**
     * Metoda vytvářející šablonu komponenty
     * @param string $templateName=''
     * @return Template
     */
    private function prepareTemplate(string $templateName=''):Template{
        $template=$this->template;
        if (!empty($templateName)){
            $template->setFile(__DIR__.'/templates/'.$templateName.'.latte');
        }
        return $template;
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
                $cart = $this->getPresenter()->getComponent('cart');
                $cart->addToCart($product, (int)$form->values->count);
                $this->redirect('this');
            };

            return $form;
        });
    }


}