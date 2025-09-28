<?php

namespace App\Http\Controllers\Auth;

use Laravel\Fortify\Contracts\LogoutResponse as LogoutResponseContract;

class LogoutResponse implements LogoutResponseContract
{
    public function toResponse($request)
    {
        $role = session('auth_role');
        session()->forget('auth_role');

        if ($user && $user->role === 'admin') {
            return redirect('/admin/login');
        }

        return redirect('/login');
    }
}
