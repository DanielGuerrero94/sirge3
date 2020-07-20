<?php

namespace App\Http\Middleware;

use Closure;
use Log;
use Auth;

class LogDebug
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($user = Auth::user()) {
            $requestFormat = $this->formatRequest($request);
            $userFormat = $this->formatUser($user);
            $data = array_merge($requestFormat, $userFormat);
            Log::debug(json_encode($data));
        }
        return $next($request);
    }

    private function formatRequest($request)
    {
        return ['method' => $request->method(), 'path' => $request->path()];
    }

    private function formatUser($user)
    {
        return ['id' => $user->id_usuario, 'nombre' => $user->nombre];
    }

}
