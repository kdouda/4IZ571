<?php

namespace App\Model\Entities;

use LeanMapper\Entity;

/**
 * Class Product
 * @package App\Model\Entities
 * @property int $productId
 * @property string $title
 * @property string $url
 * @property string $description
 * @property float $price
 * @property string $photoExtension = ''
 * @property bool $available = true
 * @property bool $featured = false
 * @property Category[] $categories m:hasMany
 * @property ProductDimension[] $dimensions m:belongsToMany(product_id:product_dimension)
 * @property File[] $files m:hasMany(product_id:product_images)
 */
class Product extends Entity implements \Nette\Security\Resource
{
    /**
     * Returns the value of a given dimension.
     *
     * @param Dimension $dimension
     * @return string
     */
    public function getDimensionValue(Dimension $dimension) : string
    {
        foreach ($this->dimensions as $dim) {
            if ($dimension->dimensionId === $dim->dimension->dimensionId) {
                return $dim->value;
            }
        }

        return "";
    }

  /**
   * @inheritDoc
   */
  function getResourceId():string{
    return 'Product';
  }
}