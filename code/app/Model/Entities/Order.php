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

  public const STATE_NEW = 'new';

  public const STATE_PROCESSED = 'processed';

  public const STATE_PAID = 'paid';

  public const STATE_DELIVERING = 'delivering';

  public const STATE_DELIVERED = 'delivered';

  public const STATE_DELETED = 'deleted';

}