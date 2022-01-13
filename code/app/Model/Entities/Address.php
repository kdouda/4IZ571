<?php

namespace App\Model\Entities;

use LeanMapper\Entity;

/**
 * Class Address
 * @package App\Model\Entities
 * @property int $addressId
 * @property string $name
 * @property string $street
 * @property string $zip
 * @property string $country
 * @property string $city
 * @property User $user m:hasOne
 */
class Address extends Entity implements \Nette\Security\Resource, \Stringable
{
    /**
     * @inheritDoc
     */
    function getResourceId(): string
    {
        return 'Address';
    }

    public function __toString()
    {
        $parts = [];

        $parts[] = $this->name;
        $parts[] = $this->street;
        $parts[] = $this->country;
        $parts[] = $this->zip;

        return implode(', ', array_filter($parts));
    }
}