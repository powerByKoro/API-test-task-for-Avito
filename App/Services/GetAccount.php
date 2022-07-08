<?php

namespace App\Services;

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

    public function getCount()
    {
        $query = $this->pdo->prepare("SELECT balance FROM users WHERE id =:id");
        $query->execute(['id' => $this->id]);

        if($query->rowCount()>0){
            $balance = $query->fetch(PDO::FETCH_ASSOC);

            $balance = (double) $balance['balance'];

            $request = [
                'status' => true,
                'code' => 200,
                'msg' => 'Баланс пользователя: ' . $balance . ' RUB',
                'data' => $balance
            ];

            return json_encode($request,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);

        }else{

            $request = [
                'status' => false,
                'code' => 404,
                'msg' => 'Пользователь не найден '
            ];

            return json_encode($request,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        }
    }

}

