<?php

namespace App\FrontModule\Components\ProductCard;

use App\FrontModule\Components\CartControl\ProductCard;

/**
 * Interface CartControlFactory
 * @package App\FrontModule\Components\CartControl
 */
interface ProductCardFactory{

    public function create():ProductCard;

}