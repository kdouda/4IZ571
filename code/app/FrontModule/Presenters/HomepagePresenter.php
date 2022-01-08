<?php

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\CartControl\ProductCard;
use App\FrontModule\Components\ProductCard\ProductCardFactory;
use App\FrontModule\Components\ProductCartForm\ProductCartFormFactory;
use App\Model\Facades\CategoriesFacade;
use App\Model\Facades\ProductsFacade;

class HomepagePresenter extends BasePresenter
{
    /**
     * @var ProductCardFactory $productCardFactory
     */
    private $productCardFactory;

    /** @var ProductsFacade $productsFacade @inject */
    public $productsFacade;

    /** @var CategoriesFacade $categoriesFacade @inject */
    public $categoriesFacade;

    public function renderDefault(): void
    {
        $this->template->featuredProducts = $this->productsFacade->findProducts(['order'=>'title', 'featured' => 1], null, 10);
        $this->template->featuredCategories = $this->categoriesFacade->findCategories(['order' => 'title']);
        $this->template->isLoggedIn = $this->user->isLoggedIn();
    }

    protected function createComponentProductCard(): ProductCard
    {
        return $this->productCardFactory->create();
    }


    public function injectProductCardFactory(ProductCardFactory $productCardFactory): void
    {
        $this->productCardFactory = $productCardFactory;
    }
}
