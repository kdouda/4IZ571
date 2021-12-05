<?php

namespace App\Model\Entities;

use LeanMapper\Entity;

/**
 * Class ProductDimension
 * @package App\Model\Entities
 * @property int $productDimensionId
 * @property Product $product m:hasOne(product_id)
 * @property Dimension $dimension m:hasOne(dimension_id)
 * @property string $value
 * @property string|null $description
 */
class ProductDimension extends Entity implements \Nette\Security\Resource
{
  /**
   * @inheritDoc
   */
  function getResourceId():string{
    return 'ProductDimension';
  }
}