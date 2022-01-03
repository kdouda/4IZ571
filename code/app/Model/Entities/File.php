<?php

namespace App\Model\Entities;

use LeanMapper\Entity;

/**
 * Class Category
 * @package App\Model\Entities
 * @property int $fileId
 * @property string $fileName
 * @property int $fileSize
 * @property int $width
 * @property int $height
 */
class File extends Entity implements \Nette\Security\Resource
{

  /**
   * @inheritDoc
   */
  function getResourceId():string{
    return 'File';
  }
}