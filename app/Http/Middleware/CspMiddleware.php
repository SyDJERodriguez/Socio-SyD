<?php

namespace App\Http\Middleware;

use Closure;

class CspMiddleware
{
  public function handle($request, Closure $next)
  {


    // Define la política CSP
    //$cspHeader = "script-src 'self'; frame-ancestors 'self' https://flex.twilio.com https://twilio.com https://stackpath.bootstrapcdn.com; trusted-types default;";
    //$cspHeader = "script-src 'unsafe-inline' 'https://flex.twilio.com' 'https://twilio.com'; trusted-types 'https://flex.twilio.com' 'https://twilio.com'; 'strict-dynamic' https;";

    // Agrega la cabecera CSP a la respuesta HTTP
    $response = $next($request);
    //$response->headers->set('Content-Security-Policy', $cspHeader);
    //$response->header('Content-Security-Policy', "default-src * 'unsafe-inline'; style-src * 'unsafe-inline'; script-src-elem *;");
    //$response->header('Content-Security-Policy', "default-src *; script-src * 'unsafe-inline' 'unsafe-eval'; style-src * 'unsafe-inline'; img-src * data:; font-src * data:");
    $response->header('Content-Security-Policy', "trusted-types TrustedHTML");
    return $response;
  }
}
