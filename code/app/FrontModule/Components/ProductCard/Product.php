<?php

namespace App\FrontModule\Components\CartControl;

use App\Model\Entities\Cart;
use App\Model\Entities\CartItem;
use App\Model\Entities\Product;
use App\Model\Facades\CartFacade;
use Nette\Application\UI\Control;
use Nette\Application\UI\Template;
use Nette\Http\Session;
use Nette\Http\SessionSection;
use Nette\Security;
use Tracy\Debugger;

/**
 * Class CartControl
 * @package App\FrontModule\Components\CartControl
 */
class ProductCard extends Control
{

    /** @var Security\User  */
    private $currentUser;

    public function __construct(Security\User $user)
    {
        $this->currentUser = $user;
    }

    /**
     * Akce renderující šablonu s odkazem pro zobrazení harmonogramu na desktopu
     * @param array $params = []
     */
    public function render($product):void {
        $template=$this->prepareTemplate('default');
        $template->product = $product;
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

}