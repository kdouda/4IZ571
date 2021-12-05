<?php

namespace App\AdminModule\Components\ProductDimensionForm;

use App\AdminModule\Components\ProductDimensionForm\ProductDimensionForm;

/**
 * Interface CategoryEditFormFactory
 * @package App\AdminModule\Components\CategoryEditForm
 */
interface ProductDimensionFormFactory
{
    public function create(): ProductDimensionForm;
}