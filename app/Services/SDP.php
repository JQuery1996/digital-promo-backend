<?php

namespace App\Services;

use App\Enums\Constant;
use Illuminate\Support\Facades\Http;

class SDP{
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

    public function SubscriptionStatus($request){

        $data= [
            'Msisdn'=>$request->Msisdn,
            'ServiceId'=>Constant::SERVICE_ID,
            'OperatorId'=>$this->keys[$request->Msisdn[4]]//Constant::OPERATOR_ID,
        ];

        $response=  Http::get($this->base_url.'lp/subscription/check',$data);


        return $response;


    }


    public function SendPIN($request){


        $PlanId= Constant::PLAN_ID_MTN;

        if((integer)$this->keys[$request->Msisdn[4]]==10){
            $PlanId= Constant::PLAN_ID_SYRIATEL;
        }
        if((integer)$this->keys[$request->Msisdn[4]]==6){
            $PlanId= Constant::PLAN_ID_MTN;
        }

          $data= [
            'Msisdn'=>(string)$request->Msisdn,
            'ServiceId'=>Constant::SERVICE_ID,
            'OperatorId'=>$this->keys[$request->Msisdn[4]],//Constant::OPERATOR_ID,Constant::OPERATOR_ID,
            'LanguageId'=> 2,
            'PlanId'=> $PlanId,
            'ChannelId'=>Constant::CHANNEL_ID
        ];

        return $response=  Http::post($this->base_url.'lp/pin/send',$data);



    }

    public function VerifyPinAndActivate($request){
        $PlanId= Constant::PLAN_ID_MTN;

        if((integer)$this->keys[$request->Msisdn[4]]==10){
            $PlanId= Constant::PLAN_ID_SYRIATEL;
        }
        if((integer)$this->keys[$request->Msisdn[4]]==6){
            $PlanId= Constant::PLAN_ID_MTN;
        }

        $data= [
            'Msisdn'=>(string)$request->Msisdn,
            'ServiceId'=>Constant::SERVICE_ID,
            'OperatorId'=>$this->keys[$request->Msisdn[4]],//Constant::OPERATOR_ID,Constant::OPERATOR_ID,
            'LanguageId'=> 1,
            'PlanId'=> $PlanId,
            'ChannelId'=>Constant::CHANNEL_ID,
            'Pin'=>(string)$request->Pin,
            'SessionId'=>(string)$request->SessionId
        ];

        $response=  Http::post($this->base_url.'lp/pin/activate',$data);
        return  $response;
    }


    public function ConvertMSISDN($request){

        $data=[
            'Msisdn'=>$request->Msisdn,
            'OperatorId'=>$this->keys[$request->Msisdn[4]],
            'Format'=>Constant::SIGNIFICANT_INTERNATIONAL,
        ];

        $response=  Http::get($this->base_url.'general/msisdn/convert',$data);
        return  $response;

    }

    public function Award($request){

        $data=[
            'Msisdn'=>$request->Msisdn,
            'AwardId'=>$request->AwardId,
            'OperatorId'=>$this->keys[$request->Msisdn[4]],
            'ServiceId'=>Constant::SERVICE_ID,
            'LanguageId'=> 1,
        ];

        $response=  Http::post($this->base_url.'internal/dp/award',$data);
        return  $response;

    }


    public function UnlockLevel($request){

        $data=[
            // data UnlockLevel ..
        ];

        // $response=  Http::post('url UnlockLevel',$data);
        return  true;
    }
}
