<?php

use Illuminate\Http\Request;
use App\Http\Middleware\Admin;
use App\Http\Middleware\SuperAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
    //
    $middleware->alias([
        'admin' => Admin::class,
        'super' => SuperAdmin::class,

    ]);
    })
->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Throwable $e, Request $request) {
            // Temporary responder using your HttpResponses trait
            $responder = new class {
                use \App\Traits\HttpResponses;
            };

            // Default values
            $status  = 500;
            $message = 'Internal server error.';

            // Validation (422)
            if ($e instanceof ValidationException) {
                $status  = 422;
                // Get first validation error message if you want it
                $firstError = collect($e->errors())->flatten()->first();
                $message = $firstError ?: 'Validation failed.';

            // Unauthenticated (401)
            } elseif ($e instanceof AuthenticationException) {
                $status  = 401;
                $message = $e->getMessage() ?: 'Unauthenticated.';

            // Forbidden (403)
            } elseif ($e instanceof AuthorizationException) {
                $status  = 403;
                $message = $e->getMessage() ?: 'Forbidden.';

            // Too many requests (429)
            } elseif (
                $e instanceof ThrottleRequestsException ||
                $e instanceof TooManyRequestsHttpException
            ) {
                $status  = 429;
                $message = 'Too many requests.';

            // Model not found (404)
            } elseif ($e instanceof ModelNotFoundException) {
                $status  = 404;
                $model   = class_basename($e->getModel() ?? 'Resource');
                $message = "{$model} not found.";

            // Route not found (404)
            } elseif ($e instanceof NotFoundHttpException) {
                $status  = 404;
                $message = 'Route not found.';

            // Method not allowed (405)
            } elseif ($e instanceof MethodNotAllowedHttpException) {
                $status  = 405;
                $message = 'Method not allowed.';

            // Other HTTP exceptions
            } elseif ($e instanceof HttpExceptionInterface) {
                $status  = $e->getStatusCode();
                $message = $e->getMessage() ?: 'HTTP error.';

            } else {
                $status  = 500;
                $message = $e->getMessage() ?: 'Internal server error.';
            }

           return $responder->error($message, $status);
        });
    })
    ->create();
