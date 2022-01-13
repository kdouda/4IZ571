<?php

namespace App\Model\Entities;

use LeanMapper\Entity;

/**
 * Class Address
 * @package App\Model\Entities
 * @property int $cartOrderItemId
 * @property Order $order m:hasOne
 * @property Product $product m:hasOne
 * @property int $amount
 * @property float $unitPrice
 */
class OrderItem extends Entity implements \Nette\Security\Resource
{
  /**
   * @inheritDoc
   */
  function getResourceId():string{
    return 'OrderItem';
  }
}