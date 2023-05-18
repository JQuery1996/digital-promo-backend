<?php

namespace App\Services;

use App\Enums\Constant;
use App\Models\Pin;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class SMS{
    public string $base_url = 'http://68.183.242.117/internal/';

    public array $operators = [
        'MTN-SY' => 6,
        'syriatel' => 10
    ];

    public array $keys;
    public array $languages = ['ar' => 2, 'en' => 1];

    public int $service_id = 8;

    public function __construct()
    {
        $this->keys = [
            0 => $this->operators['syriatel'],
            1 => $this->operators['syriatel'],
            2 => $this->operators['syriatel'],
            3 => $this->operators['syriatel'],
            4 => $this->operators['MTN-SY'],
            5 => $this->operators['MTN-SY'],
            6 => $this->operators['MTN-SY'],
            7 => $this->operators['syriatel'],
            8 => $this->operators['syriatel'],
            9 => $this->operators['syriatel'],
        ];
    }


    public function SendSMS($request){

        $pin_code = rand(0000, 9999);
        $pin_code = str_pad($pin_code, 4, '0', STR_PAD_LEFT);

        $sessionId =Carbon::now();
         $ExpiryTimestamp = Carbon::createFromFormat(Constant::DATE_TIME_FORMATE, now());
         $ExpiryTimestamp = $ExpiryTimestamp->addMinutes(Constant::VALIDATE_FOR);
        $sessionId=$sessionId->timestamp;
        $sessionId =(string)$sessionId.$request->Msisdn;

        $account= Constant::ACOUNT_NAME_MTN;

        if((integer)$this->keys[$request->Msisdn[4]]==10){
            $account= Constant::ACOUNT_NAME_SYRIATEL;
        }
        if((integer)$this->keys[$request->Msisdn[4]]==6){
            $account= Constant::ACOUNT_NAME_MTN;
        }

        $data= [
            'account'=>$account,// OPERATOR_Name,
            'msisdn'=>$request->Msisdn,
            'param1'=> $pin_code, // pin
            'param2'=>Constant::SERVICE_ID,
            'param3'=> 2, //LanguageId
        ];

        $response=  Http::timeout(6000000)->get($this->base_url.'otp/send',$data);

        if($response->status() != 200){

           return 'false';
        }

        Pin::create([
            'Msisdn'=>$request->Msisdn,
            'pin'=>$pin_code,
            'sessionId'=>$sessionId,
            'ExpiryTimestamp'=>$ExpiryTimestamp
        ]);

        return $sessionId;

    }
}
