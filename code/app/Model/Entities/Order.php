<?php

namespace App\Model\Entities;

use LeanMapper\Entity;

/**
 * Class Address
 * @package App\Model\Entities
 * @property int $orderId
 * @property User $user m:hasOne
 * @property string $state m:enum(self::STATE_*)
 * @property \DateTimeInterface $createDate
 * @property \DateTimeInterface $lastModified
 * @property Address $deliveryAddress m:hasOne
 * @property Address $billingAddress m:hasOne
 * @property OrderItem[] $items m:belongsToMany
 */
class Order extends Entity implements \Nette\Security\Resource
{
  /**
   * @inheritDoc
   */
  function getResourceId():string{
    return 'Order';
  }

  public function getStateString() : string
  {
      switch ($this->state) {
          case self::STATE_NEW:
              return 'Nový';
          case self::STATE_PROCESSED:
              return 'Zpracovaný';
          case self::STATE_PAID:
              return 'Zaplacený';
          case self::STATE_DELIVERING:
              return 'Na cestě';
          case self::STATE_DELIVERED:
              return 'Doručeno';
          case self::STATE_DELETED:
              return 'Zrušeno';
      }

      return "";
  }


  public const STATE_NEW = 'new';

  public const STATE_PROCESSED = 'processed';

  public const STATE_PAID = 'paid';

  public const STATE_DELIVERING = 'delivering';

  public const STATE_DELIVERED = 'delivered';

  public const STATE_DELETED = 'deleted';

}