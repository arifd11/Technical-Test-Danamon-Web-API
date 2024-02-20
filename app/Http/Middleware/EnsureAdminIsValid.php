<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\ApiResponse;
use App\Models\User;

class EnsureAdminIsValid
{
    use ApiResponse;

    public function handle(Request $request, Closure $next): Response
    {
        $id = $request->id;
        
        $user = User::where('id', '=', $id)->first();     
                
        if ($user == null) {
            return $this->errorResponse(null, 'Id not found', 404);                           
        } else {
            if ($user->role == "normal") {
                return $this->errorResponse(null, 'You dont have permission to access', 403);                                           
            }
            return $next($request);        
        }
    }
}
