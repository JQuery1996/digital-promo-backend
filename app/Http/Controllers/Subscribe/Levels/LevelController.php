<?php

namespace App\Http\Controllers\Subscribe\Levels;

use App\Enums\Constant;
use App\Http\Controllers\Controller;
use App\Http\Resources\Level\firstLevelResource;
use App\Http\Resources\Level\LevelResource;
use App\Http\Resources\Level\unlockLevelResource;
use App\Models\Level;
use App\Models\LevelMetaData;
use App\Models\Subscriber;
use App\Models\SubscriberLevel;
use App\Services\SDP;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LevelController extends Controller
{
    public function index(Request $request){


        $request->Msisdn =Auth::user()->Msisdn;
        $subscriberLevels = SubscriberLevel::where('Msisdn',$request->Msisdn)
        ->where('gameId',$request->gameId)->first();
        $subscriber = Subscriber::where('Msisdn',$request->Msisdn)->first();

        $gameLevel = Level::where('gameId',$request->gameId)->get();

        if(count($gameLevel)==0){
         return $this->sendMessage(__('message.no levels in this game'),400);
        }
        $firstGame=$gameLevel->first();

        if(!$subscriberLevels){
            $subscriberLevels = SubscriberLevel::create([
                'gameId'=>$request->gameId,
                'Msisdn'=>$request->Msisdn,
                'levelId'=>$firstGame->number,////++ id
                'rounds'=>$firstGame->rounds,
                'tries'=>$firstGame->tries,
                'status'=> 'P',
           ]);
        }

        if(!$subscriber->lastPlayDate){
            $subscriber->update([
                'lastPlayDate' => now(),
                'monthlyBalanceDate' => now(),
                'daliyBalanceDate' => now(),

            ]);

            return $this->sendResponse(firstLevelResource::collection($gameLevel),__('message.Success'),200);

        }else{
            $lastPlayDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $subscriber->lastPlayDate);
            $lastMonthlyPlayDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $subscriber->monthlyBalanceDate);
            $now = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', now());
            $diff_In_Hours_lastPlayDate_and_now = $lastPlayDate->diffInHours($now);
            // $now="2016-03-01 00:00:00";
            // $now1="2016-02-1 00:00:00";
            // $now1 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $now1);
            // $diff_In_Month = $now1->diffInDays($now);
            $diff_In_Month = $lastMonthlyPlayDate->diffInMonths($now);

            // return [
            //     'D'=>$now,
            //     'H' =>$diff_In_Hours_lastPlayDate_and_now,
            //     'M' =>$diff_In_Month,

            // ];

            if($diff_In_Hours_lastPlayDate_and_now >= 24){
                $subscriber->update([
                    'lastPlayDate' => now(),
                    'daliyBalanceValue' =>null,
                    'daliyBalanceDate' => now(),

                ]);
                if($diff_In_Month > 0){
                    $subscriber->update([
                        'monthlyBalanceDate' => now(),
                        'monthlyBalanceValue' =>null,

                    ]);

                }


                $subscriberLevels->update([
                    'levelId'=>$firstGame->number,////  ++ id
                    'rounds'=>$firstGame->rounds,
                    'tries'=>$firstGame->tries,
                    'status'=> 'P',
                ]);

                return $this->sendResponse(firstLevelResource::collection($gameLevel),__('message.Success'),200);

            }else{

                $lastMonthlyPlayDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $subscriber->monthlyBalanceDate);
                $now = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', now());
                $diff_In_Month = $lastMonthlyPlayDate->diffInMonths($now);
                if($diff_In_Month > 0){
                    $subscriber->update([
                        'monthlyBalanceDate' => now(),
                        'monthlyBalanceValue' =>null,

                    ]);
                }

                return $this->sendResponse(LevelResource::collection($gameLevel),__('message.Success'),200);


                // if($subscriberLevels->status =='P'){
                //     $gameLevel = Level::where('gameId',$request->gameId)->get();
                //     $firstGame=$gameLevel->first();
                //     if($firstGame->id==$subscriberLevels->levelId){
                //         return $this->sendResponse(firstLevelResource::collection($gameLevel),__('message.Success'),200);
                //     }else{
                //         return $this->sendResponse(LevelResource::collection($gameLevel),__('message.Success'),200);
                //     }
                // }

            }
        }

    }

    public function unlockLevel(Request $request){

        try{
            $request->Msisdn =Auth::user()->Msisdn;
            $level = Level::find($request->levelId);
            $subscriberLevels = SubscriberLevel::where('Msisdn',$request->Msisdn)
            ->where('gameId',$level->gameId)
            ->where('levelId',$level->number)->first();

            if(!$subscriberLevels){
                $subscriberLevels = SubscriberLevel::create([
                    'gameId'=>$level->gameId,
                    'Msisdn'=>$request->Msisdn,
                    'levelId'=>$level->number,
                    'rounds'=>$level->rounds,
                    'tries'=>$level->tries,
                    'status'=> 'P',
               ]);
            }elseif($subscriberLevels->status == 'P'){
                return $this->sendMessage(__('message.level is available'),400);
            }else{
                $subscriberLevels->update([
                    'status'=> 'P',
                ]);
            }


            $sdp  = new SDP();
            $responseUnlockLevel = $sdp->unlockLevel($request);

            if(!$responseUnlockLevel){
                return $this->sendMessage(__('message.Blocked level'),400);
            }

               $levelMetaData = LevelMetaData::where('levelId',$request->levelId)->first();

            return $this->sendResponse([new unlockLevelResource($levelMetaData)],__('message.Success'),200);


        }catch(Exception $e){
            return $this->sendMessage(__('message.Connection Error'),400);
        }
    }

    public function levelInfo(Request $request){


        $level = Level::find($request->levelId);

        if(!$level){
            return $this->sendMessage(__('message.level is available'),400);
        }
        $Msisdn =Auth::user()->Msisdn;
        $subscriberLevels = SubscriberLevel::where('Msisdn',$Msisdn)
        ->where('gameId',$level->gameId)
        ->where('levelId',$level->number)->get();

        if(count($subscriberLevels)!=0){

            foreach($subscriberLevels as $subscriberLevel){
                $subscriberLevel->update([
                    'status' => 'C'
                ]);
            }
        }


        return $this->sendResponse(new unlockLevelResource($level),__('message.Success'),200);
    }





}


