<?php

namespace App\FrontModule\Components\OrderForm;

use App\FrontModule\Components\OrderForm\OrderForm;

interface OrderFormFactory
{
    public function create():OrderForm;
}