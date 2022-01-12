<?php

namespace App\Model\Entities;

use LeanMapper\Entity;

/**
 * Class Category
 * @package App\Model\Entities
 * @property int $dimensionId
 * @property string $name
 * @property string $description
 * @property string $schemaProperty
 */
class Dimension extends Entity implements \Nette\Security\Resource{

  /**
   * @inheritDoc
   */
  function getResourceId():string{
    return 'Dimension';
  }

  const TYPE_TEXT = 'text';

  const TYPE_NUMBER = 'number';
}