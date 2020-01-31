<?php
namespace App\Http\Middleware;
use Closure;
use Config;
use App\Language;

class IsApi
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

        $local = ($request->hasHeader('X-localization')) ? $request->header('X-localization') : 'en';
        if( Language::where('ShortName')->count()==0){
           $local='en'; 
        }
        Config::set('lang_prefix',$local) ; 
        return $next($request);
    }
}