<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;

class LanguageManager
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response
     */
    public function handle(Request $request, Closure $next)
    {
        $lang = $request->header('Accept-Language') !== null ? $request->header('Accept-Language') : "ar";
        App::setLocale($lang);
        return $next($request);
    }
}


