<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiKeyMiddleware
{
    // /**
    //  * Handle an incoming request.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
    //  * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
    //  */
    public function handle(Request $request, Closure $next)
    {
        // Mendapatkan API key dari header
        $apiKey = $request->header('X-API-KEY');

        // Mendapatkan API key yang benar dari environment atau tempat lain yang aman
        $validApiKey = env('API_KEY', 'default_key');

        // Mendapatkan application key dari header
        $applicationKey = $request->header('APPLICATION-KEY');

        // Mendapatkan Application key yang benar dari environment atau tempat lain yang aman
        $validApplicatonKey = env('APPLICATION_KEY', 'default_key');

        // Memeriksa kecocokan API key
        if ($apiKey !== $validApiKey) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if($applicationKey !== $validApplicatonKey){
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Jika API key cocok, lanjutkan permintaan
        return $next($request);
    }
}
