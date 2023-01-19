<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Auth;

trait AuthTrait
{
    public function retornaUserId()
    {
        return (Auth::guard('api')->check()) ? Auth::guard('api')->user()->id : null;
    }
}
