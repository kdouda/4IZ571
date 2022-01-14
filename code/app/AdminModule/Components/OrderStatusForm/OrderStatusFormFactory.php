<?php

namespace App\AdminModule\Components\OrderStatusForm;

use App\AdminModule\Components\ProductDimensionForm\ProductDimensionForm;

interface OrderStatusFormFactory
{
    public function create(): OrderStatusForm;

}