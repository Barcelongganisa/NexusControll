<?php

// app/Http/Middleware/RedirectByRole.php
namespace App\Http\Middleware;

use App\Enums\RoleEnum;
use Closure;
use Illuminate\Http\Request;

class RedirectByRole
{
    public function handle(Request $request, Closure $next)
    {
        // Check if route exists and is named 'dashboard'
        if ($request->route()?->named('dashboard')) {
    $user = $request->user();
    // dd($user->role);

    if ($user && $user->role === RoleEnum::Employee) {
        return redirect()->route('dashboard');
    }
    else  {
        return redirect()->route('dashboard');
    }
}
        return $next($request);
    }
}
