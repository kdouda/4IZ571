<?php

namespace App\AdminModule\Components\DimensionEditForm;

/**
 * Interface CategoryEditFormFactory
 * @package App\AdminModule\Components\CategoryEditForm
 */
interface DimensionEditFormFactory
{

    public function create(): DimensionEditForm;

}