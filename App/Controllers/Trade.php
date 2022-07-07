<?php

namespace App\Controllers;

use App\Helpers\DBConnection;
use PDO;

class Trade
{
    private $pdo;
    private $firstUserId;
    private $secondUserId;
    private $sum;

    public function __construct(int $firstUserId, int $secondUserId, int $sum)
    {
        $this->pdo = (new DBConnection())->getPDO();
        $this->firstUserId = $firstUserId;
        $this->secondUserId = $secondUserId;
        $this->sum = $sum;
    }

    public function tradeCash()
    {

        $query = $this->pdo->prepare("SELECT balance FROM users WHERE id IN (:firstUserId,:secondUserId)");
        $query->execute([
            'firstUserId' => $this->firstUserId,
            'secondUserId' => $this->secondUserId
        ]);
        $usersBalance = $query->fetchAll(PDO::FETCH_ASSOC);
        $userBalance =[];
        for ($i=0; $i<count($usersBalance); $i++){
            $userBalance[] = $usersBalance[$i]['balance'];
        }

        $firstUserBalance = $userBalance[0];
        $secondUserBalance = $userBalance[1];

        if($firstUserBalance < $this->sum){
            unset($_SERVER,$_REQUEST);
            echo 'На счету пользователя 1 недостаточно средств';
        }else{
            $query = $this->pdo->prepare("UPDATE users SET balance =:newBalanceForFirstUser WHERE id =:firstUserId");
            $query->execute([
                'firstUserId' => $this->firstUserId,
                'newBalanceForFirstUser' => $firstUserBalance - $this->sum,
            ]);

            $query = $this->pdo->prepare("UPDATE users SET balance =:newBalanceForSecondUser WHERE id =:secondUserId");
            $query->execute([
                'secondUserId' => $this->secondUserId,
                'newBalanceForSecondUser' => $secondUserBalance + $this->sum,
            ]);
            unset($_SERVER,$_REQUEST);
            echo 'деньги переведены';
        }



    }
}