<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'admin' => function ($request, $next) {
            $user = $request->user();
            // Cek harus sama dengan logic di '/'
            if ($user && ($user->email === 'admin@adminsuper.com' || $user->name === 'admin')) {
                return $next($request);
            }
            return redirect()->route('dashboard');
        },
    ]);
})
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();