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

  public function getRelativePath() : string
  {
      return
          "img/products/" .
          $this->fileName
      ;
  }

  /**
   * @inheritDoc
   */
  function getResourceId():string{
    return 'File';
  }
}