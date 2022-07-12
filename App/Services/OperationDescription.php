<?php

namespace App\Services;

use App\Helpers\DBConnection;
use PDO;

class OperationDescription
{
    private $pdo;
    private $id;

    public function __construct(int $id)
    {
        $this->pdo = (new DBConnection())->getPDO();
        $this->id = $id;
    }

    public function getOperations()
    {
        $query = $this->pdo->prepare("SELECT * FROM users JOIN operation_description ON users.id=operation_description.user_id WHERE users.id =:id");
        $query->execute(['id' => $this->id]);

        if ($query->rowCount() > 0) {
            $operation = $query->fetchAll(PDO::FETCH_ASSOC);

            $operationDescription = [];

            for ($i=0; $i<count($operation); $i++){
                $operationDescription[$i]['operationId'] = $operation[$i]['id'];
                $operationDescription[$i]['description'] = $operation[$i]['description'];
                $operationDescription[$i]['price'] = $operation[$i]['price'];
                $operationDescription[$i]['dateTime'] = $operation[$i]['operation_time'];
            }

            $request = [
                'status' => true,
                'code' => 200,
                'msg' => 'Информация о покупках пользователя с id = '. $this->id. ' : ',
                'data' => $operationDescription

            ];

            return json_encode($request, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        } else {

            $request = [
                'status' => false,
                'code' => 404,
                'msg' => 'Пользователь не совершал покупок '
            ];

            return json_encode($request, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
    }

}

