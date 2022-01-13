<?php

namespace App\Model\Facades;

use App\Model\Entities\Address;
use App\Model\Entities\AddressItem;
use App\Model\Entities\User;
use App\Model\Repositories\AddressItemRepository;
use App\Model\Repositories\addressRepository;
use Dibi\DateTime;

class AddressFacade
{
    /** @var addressRepository $addressRepository */
    private $addressRepository;

    public function __construct(addressRepository $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    /**
     * Metoda vracející adresu podle AddressId
     * @param int $id
     * @return Address
     * @throws \Exception
     */
    public function getAddressById(int $id):Address {
        return $this->addressRepository->find($id);
    }

    /**
     * Metoda vracející adresu konkrétního uživatele
     * @param User|int $user
     * @return Address[]
     * @throws \Exception
     */
    public function getAddressByUser($user) : array {
        if ($user instanceof User){
            $user = $user->userId;
        }

        if ($user instanceof \Nette\Security\User) {
            $user = $user->getId();
        }

        return $this->addressRepository->findAllBy(['user_id'=>$user]);
    }

    /**
     * Metoda pro smazání adresy konkrétního uživatele
     * @param User|int $user
     */
    public function deleteAddressByUser($user):void {
        try{
            $this->addressRepository->delete($this->getAddressByUser($user));
        } catch (\Exception $e) {

        }
    }

    /**
     * Metoda pro uložení adresy
     * @param Address $Address
     */
    public function saveAddress(Address $Address){
        $this->addressRepository->persist($Address);
    }
}