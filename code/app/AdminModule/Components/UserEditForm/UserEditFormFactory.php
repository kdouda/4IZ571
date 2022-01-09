<?php

namespace App\AdminModule\Components\UserEditForm;

use App\Model\Entities\Product;

/**
 * Interface ProductEditFormFactory
 * @package App\AdminModule\Components\ProductEditForm
 */
interface UserEditFormFactory
{

    public function create() : UserEditForm;

}