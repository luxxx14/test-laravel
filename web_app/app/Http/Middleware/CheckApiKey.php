<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckApiKey
{
  public function handle(Request $request, Closure $next)
  {
    $apiKey = $request->header('X-API-KEY');

    if ($apiKey !== config('api.api_key')) {
      return response()->json(['error' => 'Unauthorized'], 401);
    }

    return $next($request);
  }
}
