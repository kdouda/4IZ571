<?php

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\CartControl\ProductCard;
use App\FrontModule\Components\ProductCard\ProductCardFactory;
use App\FrontModule\Components\ProductCartForm\ProductCartFormFactory;
use App\Model\Facades\CategoriesFacade;
use App\Model\Facades\ProductsFacade;
use Nette;
use Nette\Application\BadRequestException;

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

    /**
     * Akce pro vykreslení přehledu produktů
     */
    public function renderList(int $category = null, int $limit = null, int $offset = null): void
    {
        $productsQuery = [
            'order' => 'title'
        ];

        if ($category) {
            $productsQuery['category_id'] = $category;
        }

        if ($limit) {
            $productsQuery['limit'] = $limit;
        }

        if ($offset) {
            $productsQuery['offset'] = $offset;
        }

        //TODO tady by mělo přibýt filtrování podle kategorie, stránkování atp.
        $this->template->products = $this->productsFacade->findProducts($productsQuery);
        $this->template->categories = $this->categoriesFacade->findCategories(['order' => 'title']);
        $this->template->currentCategory = $category;
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