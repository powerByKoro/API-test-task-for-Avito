<?php

namespace App\Controllers;

use App\Helpers\DBConnection;
use PDO;


class PostAccount
{
    private $pdo;
    private $addBalance;
    private $id;

    public function __construct(int $id, int $addBalance)
    {
        $this->pdo = (new DBConnection())->getPDO();
        $this->addBalance = $addBalance;
        $this->id = $id;
    }

    public function increaseBalance()
    {

        $query = $this->pdo->prepare("SELECT balance FROM users WHERE id =:id");
        $query->execute(['id' => $this->id]);
        $oldBalance = $query->fetch(PDO::FETCH_ASSOC);

        if($oldBalance){
            $oldBalance = (int) $oldBalance['balance'];
            $addBalance = $this->addBalance;
            $newBalance = $addBalance + $oldBalance;
            $query = $this->pdo->prepare("UPDATE users SET balance =:newBalance WHERE id =:id");
            $query->execute([
                'id' => $this->id,
                'newBalance' => $newBalance,
            ]);
            unset($_SERVER,$_REQUEST);
            echo 'деньги дали';
        }else{
            unset($_SERVER,$_REQUEST);
            echo 'Такого пользователя нет';
        }
    }

    public function decreaseBalance()
    {
        Database::connection();

        $query = $this->pdo->prepare("SELECT balance FROM users WHERE id =:id");
        $query->execute(['id' => $this->id]);
        $oldBalance = $query->fetch(PDO::FETCH_ASSOC);

        if ($oldBalance){
            $oldBalance = (int) $oldBalance['balance'];
            $newBalance = $oldBalance - $this->addBalance;
            if($newBalance >0){
                $query = $this->pdo->prepare("UPDATE users SET balance =:newBalance WHERE id =:id");
                $query->execute([
                    'id' => $this->id,
                    'newBalance' => $newBalance,
                ]);
                unset($_SERVER,$_REQUEST);
                echo 'деньги забрали';
            }else{
                unset($_SERVER,$_REQUEST);
                echo 'Недостаточно средств';
            }
        }else{
            unset($_SERVER,$_REQUEST);
            echo 'Такого пользователя нет';
        }
    }
}
