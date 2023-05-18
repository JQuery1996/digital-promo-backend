<?php

namespace App\Http\Middleware;

use App\Models\Level;
use App\Models\SubscriberLevel;
use App\Traits\Response;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAvailableLevel
{
    use Response;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $authSubscriber = Auth::user();
        $level = Level::find($request->levelId);
        $subscriberLevel = SubscriberLevel::where('Msisdn',$authSubscriber->Msisdn)
        ->where('gameId',$level->gameId)
        ->where('levelId',$level->number)
        ->first();

        if(!$subscriberLevel){
            return $this->sendMessage(__('message.level is not available'),400);
        }

        if($subscriberLevel->status != 'P'){
            return $this->sendMessage(__('message.level is not available'),400);
        }

        return $next($request);
    }
}
