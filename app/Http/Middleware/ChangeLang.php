<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChangeLang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {

        $lang = $request->lang ? $request->lang : $request->header('lang');

        $langCode = Language::where('code', $lang)->first()?->code ?? 'ar';

        app()->setLocale($langCode);
        Carbon::setLocale($langCode);

        return $next($request);
    }
}
