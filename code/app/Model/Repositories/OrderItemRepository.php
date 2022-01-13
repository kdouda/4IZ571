<?php


namespace App\Model\Repositories;

class OrderItemRepository extends BaseRepository
{
    public function getFluent()
    {
        return $this->connection->select('`order_item`.*')->from('order_item');
    }

}