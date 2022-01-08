<?php

namespace App\Model\Repositories;

/**
 * Class ProductRepository
 * @package App\Model\Repositories
 */
class ProductRepository extends BaseRepository
{

    public function getConnection() {
        return $this->connection->select('*')->from('product');
    }

}