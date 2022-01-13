<?php

namespace App\Model\Facades;

use App\Model\Entities\Order;
use App\Model\Entities\OrderItem;
use App\Model\Entities\User;
use App\Model\Repositories\orderItemRepository;
use App\Model\Repositories\orderRepository;
use Dibi\DateTime;

class OrderFacade
{
    /** @var OrderRepository $orderRepository */
    private $orderRepository;
    /** @var OrderItemRepository $orderItemRepository */
    private $orderItemRepository;

    public function __construct(OrderRepository $orderRepository, OrderItemRepository $orderItemRepository)
    {
        $this->orderRepository=$orderRepository;
        $this->orderItemRepository=$orderItemRepository;
    }

    /**
     * Metoda vracející košík podle OrderId
     * @param int $id
     * @return Order
     * @throws \Exception
     */
    public function getOrderById(int $id):Order {
        return $this->orderRepository->find($id);
    }

    /**
     * Metoda vracející košík konkrétního uživatele
     * @param User|int $user
     * @return Order
     * @throws \Exception
     */
    public function getOrderByUser($user):Order {
        if ($user instanceof User){
            $user=$user->userId;
        }
        return $this->orderRepository->findBy(['user_id'=>$user]);
    }

    /**
     * Metoda pro smazání košíku konkrétního uživatele
     * @param User|int $user
     */
    public function deleteOrderByUser($user):void {
        try{
            $this->orderRepository->delete($this->getOrderByUser($user));
        }catch (\Exception $e){}
    }

    /**
     * Metoda vracející konkrétní OrderItem
     * @param int $OrderItemId
     * @return OrderItem
     * @throws \Exception
     */
    public function getOrderItem(int $OrderItemId):OrderItem {
        return $this->orderItemRepository->find($OrderItemId);
    }

    /**
     * Metoda pro uložení položky v košíku
     * @param OrderItem $OrderItem
     */
    public function saveOrderItem(OrderItem $OrderItem){
        $this->orderItemRepository->persist($OrderItem);
    }

    /**
     * Metoda pro smazání položky košíku
     * @param OrderItem $OrderItem
     * @throws \LeanMapper\Exception\InvalidStateException
     */
    public function deleteOrderItem(OrderItem $OrderItem){
        $this->orderItemRepository->delete($OrderItem);
    }

    /**
     * Metoda pro uložení košíku, automaticky aktualizuje informaci o jeho poslední změně
     * @param Order $Order
     */
    public function saveOrder(Order $Order){
        $Order->lastModified = new DateTime();
        $this->orderRepository->persist($Order);
    }

    public function getGridDataSourceForUser($user)
    {
        if ($user instanceof User) {
            $user = $user->userId;
        }

        if ($user instanceof \Nette\Security\User) {
            $user = $user->getId();
        }

        // asi by mělo být v repozitáři
        return $this->orderRepository->getFluent()
                                     ->select('SUM(ot.amount) AS num_products, SUM(ot.amount * ot.amount) as total_price')
                                     ->where('`order`.user_id = ?', $user)
                                     ->innerJoin('order_item ot on ot.order_id = `order`.order_id')
                                     ->groupBy('`order`.order_id');
    }

    public function getGridDataSourceForOrder($order)
    {
        return $this->orderItemRepository->getFluent()
//            ->distinct()
            ->select('count(`p`.product_id) as products, p.title,SUM(p.price) as total_price,o.state,o.create_date')
            ->where('`order_item`.order_id = ?',$order)
            ->innerJoin('product p on p.product_id = `order_item`.product_id')
            ->innerJoin('`order` o on o.order_id = `order_item`.order_id')
            ->groupBy('p.product_id');

//        return $this->orderItemRepository->getFluent()
//            ->select('*')
//            ->where('`order_item`.order_id = ?',$order)
//            ->innerJoin('product p on p.product_id = `order_item`.product_id')
//            ->innerJoin('`order` o on o.order_id = `order_item`.order_id')
//            ->groupBy('p.product_id');

    }
}