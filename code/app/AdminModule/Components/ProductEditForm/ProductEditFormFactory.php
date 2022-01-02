<?php

namespace App\AdminModule\Components\ProductEditForm;

use App\Model\Entities\Product;

/**
 * Interface ProductEditFormFactory
 * @package App\AdminModule\Components\ProductEditForm
 */
interface ProductEditFormFactory{

  public function create(?Product $product = null) : ProductEditForm;

}