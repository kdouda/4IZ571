<?php


namespace App\Model\Repositories;

class OrderRepository extends BaseRepository
{
    public function getFluent()
    {
        return $this->connection->select('`order`.*')->from('order');
    }
}