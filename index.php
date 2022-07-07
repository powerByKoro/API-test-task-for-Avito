<?php

use App\Controllers\GetAccount;
use App\Controllers\PostAccount;
use App\Controllers\Trade;

require_once __DIR__. '/vendor/autoload.php';

header("Content-Type: application/json");

$requestUri = explode('/', trim($_SERVER['REQUEST_URI'],'/'));
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestParams = $_REQUEST;

if($requestMethod === 'GET') {
//GET получение баланса пользователя
    if ($requestUri[0] === 'users' && isset($requestUri[1]) && !isset($requestUri[2])) {

        //классы с большой буквы
        $balance = new GetAccount($requestUri[1]);
        $balance = $balance->getCount();
        $request = [
            'status' => true,
            'code' => 200,
            'msg' => 'Баланс пользователя' . $balance
        ];
        echo json_encode($request,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    }
}
elseif ($requestMethod === 'POST'){
    //POST увеличение баланса
    if($requestUri[0] === 'users' && isset($requestUri[1]) && $requestUri[1]==='increase' && !isset($requestUri[2])  && isset($requestParams['id'], $requestParams['balance'])){
        $balance = new PostAccount($requestParams['id'], $requestParams['balance']);
        $balance->increaseBalance();
    }
//POST уменьшение баланса
    elseif($requestUri[0] === 'users' && isset($requestUri[1]) && $requestUri[1]==='decrease' && !isset($requestUri[2])  && isset($requestParams['id'], $requestParams['balance'])){
        $balance = new PostAccount($requestParams['id'], $requestParams['balance']);
        $balance->decreaseBalance();
    }
//POST обмен деньгами пользователей
    elseif($requestUri[0] === 'users' && isset($requestUri[1]) && $requestUri[1]==='trade' && !isset($requestUri[2]) && isset($requestParams['first_user_id'], $requestParams['second_user_id'],$requestParams['sum'])){
        $balance = new Trade($requestParams['first_user_id'],$requestParams['second_user_id'],$requestParams['sum']);
        $balance->tradeCash();
    }
    else{
        $request = [
          'status' => false,
          'code' => 404,
          'msg' => 'неверно указаны параметры запроса'
        ];
        echo json_encode($request);
    }

}








