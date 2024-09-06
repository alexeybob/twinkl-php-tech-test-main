<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (
            in_array($request->ip(), ["127.0.0.1", "127.0.0.2"])
        ) {
            $message = "Access from current IP address is not allowed.";

            if (
                $request->header("Content-Type") === "application/json" ||
                $request->ajax()
            ) {
                return new JsonResponse($message, 403);
            }

            abort(403, $message);
        }

        return $next($request);
    }
}
