<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Cookie;
use Illuminate\Session\TokenMismatchException;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];

    /**
     * Determine if the session and input CSRF tokens match.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function tokensMatch($request)
    {
        $sessionToken = $request->session()->token();

        $token = $request->input('_token') ?: $request->header('X-CSRF-TOKEN-SIRGE');

        if (! $token && $header = $request->header('X-XSRF-TOKEN-SIRGE')) {
            $token = $this->encrypter->decrypt($header);
        }

        if (! is_string($sessionToken) || ! is_string($token)) {
            return false;
        }

        return Str::equals($sessionToken, $token);
    }

    /**
     * Add the CSRF token to the response cookies.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return \Illuminate\Http\Response
     */
    protected function addCookieToResponse($request, $response)
    {
        $config = config('session');

        $response->headers->setCookie(
            new Cookie(
                'XSRF-TOKEN-SIRGE', $request->session()->token(), time() + 60 * 120,
                $config['path'], $config['domain'], $config['secure'], false
            )
        );

        return $response;
    }
}
