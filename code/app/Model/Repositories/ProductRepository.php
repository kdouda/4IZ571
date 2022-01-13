<?php

namespace App\Model\Repositories;

use Tracy\Debugger;

/**
 * Class ProductRepository
 * @package App\Model\Repositories
 */
class ProductRepository extends BaseRepository
{

    public function getConnection() {
        return $this->connection->select('*')->from('product');
    }

    /**
     * @param null|array $whereArr
     * @param null|int $offset
     * @param null|int $limit
     * @return array
     */
    public function filterAllBy($whereArr = null, $categories = [], $offset = null, $limit = null)
    {
        $query = $this->connection->select('p.*')->from($this->getTable() . ' p');

        if (isset($whereArr['order'])) {
            $query->orderBy($whereArr['order']);
            unset($whereArr['order']);
        }
        if ($whereArr != null && count($whereArr) > 0) {
            $query = $query->where($whereArr);
        }

        if ($categories) {
            $query->innerJoin('product_category pc')
                  ->on('pc.product_id = p.product_id AND pc.category_id IN (?)', $categories);
        }

        // in case multiple categoryIds are provided - would probably produce duplicate entities ?
        $res = $query->fetchAll($offset, $limit);

        $tmp = [];

        foreach ($res as $row) {
            $tmp[$row->product_id] = $row;
        }

        return $this->createEntities(array_values($tmp));
    }

    /**
     * @param null|array $whereArr
     * @param null|int $offset
     * @param null|int $limit
     * @return int
     */
    public function countAllBy($whereArr = null, $categories = []) : int
    {
        $query = $this->connection->select('count(distinct p.product_id)')->from($this->getTable() . ' p');

        if ($whereArr != null && count($whereArr) > 0) {
            $query = $query->where($whereArr);
        }

        if ($categories) {
            $query->innerJoin('product_category pc')
                ->on('pc.product_id = p.product_id AND pc.category_id IN (?)', $categories);
        }

        $res = $query->fetchSingle();

        if ($res) {
            return (int)$res;
        }

        return 0;
    }

}