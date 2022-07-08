<?php

namespace App\Services;

class CurrencyConvertion
{
    private $currencyStr;
    private $currency;
    private $id;
    private $rubles;

    public function __construct(string $currency, int $id)
    {
        $this->id = $id;

        $this->currencyStr = $currency;

        $rubles = new GetAccount($id);
        $rubles = $rubles->getCount();
        $rubles = json_decode($rubles, true);

        if($rubles['status'] === false){
            $this->rubles = false;
        }else{
            $this->rubles = (double) $rubles['data'];
        }
    }

    public function convert()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.apilayer.com/exchangerates_data/convert?to=$this->currencyStr&from=RUB&amount=1",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: text/plain",
                "apikey: fbPbZRmpzJq7q6WVBOvymUTghkb2Q3wa"
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET"
        ));

        $response = json_decode(curl_exec($curl),true);

        curl_close($curl);

        if($this->rubles === false){

            $request = [
                'status' => false,
                'code' => 404,
                'msg' => 'Пользовтель не найден.'
            ];

            return json_encode($request,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);

        }else{

            $this->currency = $this->rubles * (double)$response['result'];

            $request = [
                'status' => true,
                'code' => 200,
                'msg' => 'Баланс пользователя: с id =('. $this->id.') ' . $this->currency . ' '. $this->currencyStr,
                'data' => $this->currency
            ];

            return json_encode($request,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        }
    }
}