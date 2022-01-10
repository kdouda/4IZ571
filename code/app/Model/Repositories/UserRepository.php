<?php

namespace App\Model\Repositories;

/**
 * Class UserRepository - repozitář pro uživatele
 * @package App\Model\Repositories
 */
class UserRepository extends BaseRepository{
    public function getConnection() {
        return $this->connection->select('*')->from($this->getTable());
    }
}