<?php

namespace App\Http\Controllers\Subscribe;

use App\Enums\Constant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Subscribe\SubscribeRequest;
use App\Models\Subscriber;
use App\Traits\Response;
use GrahamCampbell\ResultType\Success;
use App\Enums\SubscriberStatus;
use App\Http\Requests\Pin\VerifyPinRequest;
use App\Http\Resources\Subscriber\SubscriberInfoResource;
use App\Http\Resources\Subscriber\SubscriberResource;
use App\Models\Pin;
use App\Services\SDP;
use App\Services\SMS;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    public array $operators = [
        'MTN-SY' => 6,
        'syriatel' => 10
    ];

    public array $keys;

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


    public function Subscribe(Request $request)
    {

        if (!$request->Msisdn) {

            return $this->sendMessage(__('message.Mobile required'), 400);
        }

        // try {
            $sdp = new SDP();
            $convertMsisdn = $sdp->ConvertMSISDN($request);
           
            if ($convertMsisdn->ErrorCode == 3) {
                return $this->sendMessage(__('message.Unrecognized'), 400);
            } elseif ($convertMsisdn->ErrorCode == 100) {
                return $this->sendMessage(__('message.Technical Error'), 400);
            }


            $dataResponse = $convertMsisdn->Data;
            $request->Msisdn = $dataResponse->Msisdn;

            $responseSubscriptionStatusSDP = $sdp->SubscriptionStatus($request);
            

            if ($responseSubscriptionStatusSDP->ErrorCode == 10) {

                return $this->sendMessage(__('message.Validation Error'), 400);
            }
            if ($responseSubscriptionStatusSDP->ErrorCode != 0) {

                return $this->sendMessage(__('message.Technical Error'), 400);
            }
            $dataResponseSubscriptionStatus = $responseSubscriptionStatusSDP->Data;
            if ($dataResponseSubscriptionStatus->status == "D") {

                   $responseSendPIN_SDP = json_decode($sdp->SendPIN($request));



                if ($responseSendPIN_SDP->ErrorCode != 0) {

                    return $this->sendMessage(__('message.Technical Error'), 400);
                }

                $dataResponseSendPIN_SDP = $responseSendPIN_SDP->Data;
                $SessionId = $dataResponseSendPIN_SDP->SessionId;

                $data = [
                    'SessionId' => $SessionId,
                    'verifyType' => 'SDP',
                ];
                return $this->sendResponse($data, __('message.new subscriber'), 200);
            } else if ($dataResponseSubscriptionStatus->status == "A" || $dataResponseSubscriptionStatus->status == "PA" || $dataResponseSubscriptionStatus->status == "P") {

                $sms = new SMS();
                $smsResponse = $sms->SendSMS($request);
                $SessionId = $smsResponse;

                $data = [
                    'SessionId' => $SessionId,
                    'verifyType' => 'DB',
                ];

                return $this->sendResponse($data, __('message.subscriber exists'), 200);
            }
        // } catch (Exception $e) {
        //     return $this->sendMessage(__('message.Connection Error'), 400);
        // }
    }



    public function VerifyPinAndActivate(Request $request)
    {

        // try {
            $sdp = new SDP();

            $convertMsisdn = json_decode($sdp->ConvertMSISDN($request));
            if ($convertMsisdn->ErrorCode == 3) {
                return $this->sendMessage(__('message.Unrecognized'), 400);
            } elseif ($convertMsisdn->ErrorCode == 100) {
                return $this->sendMessage(__('message.Technical Error'), 400);
            }


            $dataResponse = $convertMsisdn->Data;
            $request->Msisdn = $dataResponse->Msisdn;

            $responseVerifyPinAndActivate_SDP = json_decode($sdp->VerifyPinAndActivate($request));

            switch ($responseVerifyPinAndActivate_SDP->ErrorCode) {

                case 100: {
                        return $this->sendMessage(__('message.Technical Error'), 400);
                        break;
                    }
                case 4: {
                        return $this->sendMessage(__('message.PIN Mismatch'), 400);
                        break;
                    }
                case 1: {
                        return $this->sendMessage(__('message.Already Activated'), 400);
                        break;
                    }
                case 0: {
                        $subscriber = Subscriber::where('Msisdn', $request->Msisdn)->first();
                        if (!$subscriber) {

                            $subscriber = Subscriber::create([
                                'Msisdn' => $request->Msisdn,
                                'operatorId' => $this->keys[$request->Msisdn[4]],
                                'status' => SubscriberStatus::Active,
                            ]);
                        }

                        $token = $subscriber->createToken('Digital-Promo')->accessToken;

                        $data = [
                            'subscriber' => new SubscriberInfoResource($subscriber),
                            'token' => $token
                        ];


                        return $this->sendResponse(
                            $data,
                            __('message.Activated Successfully'),
                            200
                        );
                    }
                    break;
            }

            return $this->sendMessage(
                $responseVerifyPinAndActivate_SDP->ErrorMessage,
                400
            );
        // } catch (Exception $e) {
        //     return $this->sendMessage(__('message.Connection Error'), 400);
        // }
    }

    public function reSendPinDB(Request $request)
    {
        try {

            $sms = new SMS();
            $smsResponse = $sms->SendSMS($request);
            if ($smsResponse == "false") {
                return $this->sendMessage(__('message.Error sending pin'), 400);
            }
            $data = [
                'sessionId' => $smsResponse,
                'verifyType' => 'DB',
            ];
            return $this->sendResponse($data, __('message.Success'), 200);
        } catch (Exception $e) {
            return $this->sendMessage(__('message.Connection Error'), 400);
        }
    }


    public function reSendPinSDP(Request $request)
    {
        try {

            $sdp = new SDP();
            $responseSendPIN_SDP = json_decode($sdp->SendPIN($request));
            if ($responseSendPIN_SDP->ErrorCode != 0) {

                return $this->sendMessage(__('message.Technical Error'), 400);
            }
            $dataResponseSendPIN_SDP = $responseSendPIN_SDP->Data;
            $SessionId = $dataResponseSendPIN_SDP->SessionId;

            $data = [
                'SessionId' => $SessionId,
                'verifyType' => 'SDP',
            ];
            return $this->sendResponse($data, __('message.Success'), 200);
        } catch (Exception $e) {
            return $this->sendMessage(__('message.Connection Error'), 400);
        }
    }
    public function VerifyPinLogin(Request $request)
    {

        try {
            $pin = Pin::where('sessionId', $request->SessionId)
                ->where('ExpiryTimestamp', '>=', now())->first();

                $sdp = new SDP();
                $convertMsisdn = json_decode($sdp->ConvertMSISDN($request));
                if ($convertMsisdn->ErrorCode == 3) {
                    return $this->sendMessage(__('message.Unrecognized'), 400);
                } elseif ($convertMsisdn->ErrorCode == 100) {
                    return $this->sendMessage(__('message.Technical Error'), 400);
                }


                $dataResponse = $convertMsisdn->Data;
                $request->Msisdn = $dataResponse->Msisdn;


            if ($pin && $pin->pin == $request->Pin && $pin->Msisdn == $request->Msisdn) {

                $subscriber = Subscriber::where('Msisdn', $request->Msisdn)->first();
                if (!$subscriber) {

                    $subscriber = Subscriber::create([
                        'Msisdn' => $request->Msisdn,
                        'operatorId' => $this->keys[$request->Msisdn[4]],
                        'status' => SubscriberStatus::Active,
                    ]);
                }

                $token = $subscriber->createToken('Digital-Promo')->accessToken;
                // $token->expires_at = Carbon::now()->addMinutes(1);
                $data = [
                    'subscriber' => new SubscriberInfoResource($subscriber),
                    'token' => $token
                ];

                return $this->sendResponse($data, __('message.login Success'), 200);
            }
            return $this->sendMessage(__('message.pin is not valid'), 400);
        } catch (Exception $e) {
            return $this->sendMessage(__('message.Connection Error'), 400);
        }
    }


    public function Profile(Request $request)
    {

        try {

            $subscriber = Subscriber::where('Msisdn', $request->Msisdn)->get();

            return $this->sendResponse(SubscriberResource::collection($subscriber), 'Success');
        } catch (Exception $e) {
            return $this->sendMessage(__('message.Connection Error'), 400);
        }
    }

    public function logout()
    {
        DB::beginTransaction();
        try {
            $user = auth()->user()->token();

            return $this->sendMessage(
                __('message.logout successfully')
            );
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->sendMessage(
                $th->getMessage(),
                500
            );
        }
    }
}
