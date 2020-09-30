<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VerifyPurchaserCountry
{
    protected $geoIpUrl = 'https://freegeoip.app/json/';

    protected $dissalowCountryCodes = [
        'AU',
        'CO'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $ip = Http::get($this->geoIpUrl . $request->ip())->json();

        if (isset($ip['country_code']) && in_array($ip['country_code'], $this->dissalowCountryCodes) ) {
            abort(403, 'Sorry, you can not purchase this product.');
        }

        return $next($request);
    }
}
