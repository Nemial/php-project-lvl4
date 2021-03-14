<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (array_key_exists('HTTP_ACCEPT_LANGUAGE', $_SERVER)) {
            preg_match_all(
                '/([a-z]{1,8}(?:-[a-z]{1,8    })?)(?:;q=([0-9.]+))?/',
                strtolower($_SERVER["HTTP_ACCEPT_LANGUAGE"]),
                $matches
            );
            $langs = array_combine($matches[1], $matches[2]);
            foreach ($langs as $n => $v) {
                $langs[$n] = $v ? $v : 1;
            }
            arsort($langs);

            App::setLocale(key($langs));
        }

        return $next($request);
    }
}
