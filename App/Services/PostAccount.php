<?php

namespace App\Services;

use App\Helpers\DBConnection;
use PDO;

class PostAccount
{
    private $pdo;
    private $addBalance;
    private $id;

    public function __construct(int $id, float $addBalance)
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

            $request = [
                'status' => true,
                'code' => 200,
                'msg' => "Пользователю c id = ($this->id) зачислено $this->addBalance RUB"
            ];

            return json_encode($request,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        }else{

            $request = [
                'status' => false,
                'code' => 404,
                'msg' => "Пользователь с таким id = ($this->id) не найден."
            ];

            return json_encode($request,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        }
    }

    public function decreaseBalance()
    {

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

                $request = [
                    'status' => true,
                    'code' => 200,
                    'msg' => "У пользователя с id = ($this->id) списано $this->addBalance RUB"
                ];

                return json_encode($request,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
            }else{

                $request = [
                    'status' => false,
                    'code' => 400,
                    'msg' => "У пользователя с id = ($this->id) недостаточно средств."
                ];

                return json_encode($request,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
            }
        }else{
            unset($_SERVER,$_REQUEST);

            $request = [
                'status' => false,
                'code' => 404,
                'msg' => "Пользователь с таким id = ($this->id) не найден."
            ];

            return json_encode($request,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        }
    }
}
