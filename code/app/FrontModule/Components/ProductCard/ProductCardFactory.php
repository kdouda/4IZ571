<?php

namespace App\FrontModule\Components\ProductCard;

use App\FrontModule\Components\ProductCard\ProductCard;

/**
 * Interface CartControlFactory
 * @package App\FrontModule\Components
 */
interface ProductCardFactory{

    public function create():ProductCard;

}