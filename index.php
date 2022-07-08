<?php

use App\Services\CurrencyConvertion;
use App\Services\GetAccount;
use App\Services\PostAccount;
use App\Services\Trade;

require_once __DIR__. '/vendor/autoload.php';

header("Content-Type: application/json");

$requestUri = explode('/', trim($_SERVER['REQUEST_URI'],'/'));
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestParams = $_REQUEST;

if($requestMethod === 'GET') {

    //Конвертация в выбранную валюту USD , EUR, GBP при наличии параметра ?currency
    if($requestUri[0] === 'users' && isset($requestUri[1]) && isset($requestParams['currency']) && $requestParams['currency']!== '' && is_numeric(strtok($requestUri[1],'?'))){

        $currency = new CurrencyConvertion($requestParams['currency'], $requestUri[1]);
        $currency = $currency->convert();

        echo $currency;
    }

    //GET получение баланса пользователя
    elseif ($requestUri[0] === 'users' && isset($requestUri[1]) && !isset($requestUri[2]) && is_numeric($requestUri[1])) {

        $balance = new GetAccount($requestUri[1]);
        $balance = $balance->getCount();

        echo $balance;
    }else{
        $request = [
            'status' => false,
            'code' => 404,
            'msg' => 'Неверно указаны параметры запроса'
        ];
        echo json_encode($request,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    }
}
elseif ($requestMethod === 'POST'){

    //POST увеличение баланса
    if($requestUri[0] === 'users' && isset($requestUri[1]) && $requestUri[1]==='increase' && !isset($requestUri[2])  && isset($requestParams['id'], $requestParams['balance']) && is_numeric($requestParams['id']) && is_numeric($requestParams['balance']) ){

        $balance = new PostAccount($requestParams['id'], $requestParams['balance']);
        $balance = $balance->increaseBalance();

        echo $balance;
    }

    //POST уменьшение баланса
    elseif($requestUri[0] === 'users' && isset($requestUri[1]) && $requestUri[1]==='decrease' && !isset($requestUri[2])  && isset($requestParams['id'], $requestParams['balance']) && is_numeric($requestParams['id']) && is_numeric($requestParams['balance'])){

        $balance = new PostAccount($requestParams['id'], $requestParams['balance']);
        $balance = $balance->decreaseBalance();

        echo $balance;
    }

    //POST обмен деньгами пользователей
    elseif($requestUri[0] === 'users' && isset($requestUri[1]) && $requestUri[1]==='trade' && !isset($requestUri[2]) && isset($requestParams['first_user_id'], $requestParams['second_user_id'],$requestParams['sum'])){

        $balance = new Trade($requestParams['first_user_id'],$requestParams['second_user_id'],$requestParams['sum']);
        $balance = $balance->tradeCash();

        echo $balance;
    }
    else{

        $request = [
          'status' => false,
          'code' => 404,
          'msg' => 'Неверно указаны параметры запроса'
        ];

        echo json_encode($request,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    }

}








