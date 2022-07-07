<?php

namespace App\Controllers;

use App\Helpers\DBConnection;
use PDO;

class GetAccount
{
    private $pdo;
    private $id;

    public function __construct(int $id)
    {
        $this->pdo = (new DBConnection())->getPDO();
        $this->id = $id;
    }

    public function getCount() :array
    {
        $query = $this->pdo->prepare("SELECT balance FROM users WHERE id =:id");
        $query->execute(['id' => $this->id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

}

