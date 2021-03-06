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
        Config::set('lang_prefix',$local) ; 
        if( Language::where('ShortName',$local)->count()==0){
            $local='en'; 
         }
        return $next($request);
    }
}