<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\ApiResponse;

class EnsureTokenIsValid
{
    use ApiResponse;
    
    public function handle(Request $request, Closure $next): Response
    {
        if (validateKey($request->header('X-API-Key'))) {
            return $next($request);
        } else {
            return $this->errorResponse(null, 'Unauthorized', 401);       
        }        
    }
}
