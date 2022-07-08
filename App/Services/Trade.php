<?php

namespace App\Services;

use App\Helpers\DBConnection;
use PDO;

class Trade
{
    private $pdo;
    private $firstUserId;
    private $secondUserId;
    private $sum;

    public function __construct(int $firstUserId, int $secondUserId, float $sum)
    {
        $this->pdo = (new DBConnection())->getPDO();
        $this->firstUserId = $firstUserId;
        $this->secondUserId = $secondUserId;
        $this->sum = $sum;
    }

    public function tradeCash()
    {
        //Получение баланса первого пользователя
        $query = $this->pdo->prepare("SELECT balance FROM users WHERE id =:firstUserId");
        $query->execute([
            'firstUserId' => $this->firstUserId,
        ]);

        if($query->rowCount()>0){

            $query = $query->fetch(PDO::FETCH_ASSOC);

            $firstUserBalance = (double) $query['balance'];

        }else{
            $request = [
                'status' => false,
                'code' => 400,
                'msg' => "Пользователь = ($this->firstUserId) не найден."
            ];

            return json_encode($request,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        }

        //Получение баланса второго пользователя
        $query = $this->pdo->prepare("SELECT balance FROM users WHERE id =:secondUserId");
        $query->execute([
            'secondUserId' => $this->secondUserId
        ]);

        if($query->rowCount()>0){

            $query = $query->fetch(PDO::FETCH_ASSOC);

            $secondUserBalance = (double) $query['balance'];

        }else{

            $request = [
                'status' => false,
                'code' => 400,
                'msg' => "Пользователь = ($this->secondUserId) не найден."
            ];

            return json_encode($request,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        }

        if($firstUserBalance < $this->sum){

            unset($_SERVER,$_REQUEST);

            $request = [
                'status' => false,
                'code' => 400,
                'msg' => "У пользователя с id = ($this->firstUserId) недостаточно средств."
            ];

            return json_encode($request,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
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

            $request = [
                'status' => true,
                'code' => 200,
                'msg' => "Пользователь $this->firstUserId перевел $this->sum RUB пользователю $this->secondUserId"
            ];

            return json_encode($request,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        }
    }
}