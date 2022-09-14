<?php

namespace App\Services;

use App\Models\User;
use Dadata\DadataClient;
use Illuminate\Support\Facades\Auth;

class GeoService
{
    /**
     * @param string $ip
     * @return mixed
     */
    public function getAllDataByIp(string $ip)
    {
        return (new DadataClient(config('app.data_api'), null))->iplocate($ip);
    }

    public function getCityByIp(string $ip)
    {
        if ($this->getAllDataByIp($ip)) {
            return $this->getAllDataByIp($ip)['data']['city'];
        } else {
            return null;
        }
    }

    public static function getFromCacheOrNewRequest($request)
    {
        if (session()->has('userCity')) {
            $userCity = session('userCity');
        } elseif (Auth::user()) {

            if (Auth::user()->city) {
                $userCity = Auth::user()->city()->first()->name;
                if (Auth::user()->city()->first()->name != $userCity) {
                    $user = User::find(Auth::user()->id);
                    $user->update(['city_id' => session('userCityId')]);
                }
                session(['userCity' => $userCity]);
            } else {
                $userCity = (new GeoService)->getCityByIp($request->ip());
                session(['userCity' => $userCity]);
            }

        } else {
            $userCity = (new GeoService)->getCityByIp($request->ip());
            session(['userCity' => $userCity]);
        }
        return $userCity;
    }

    public function needShowChangeBubble($userCity)
    {
        if (!session()->has('showCityChoice') && !session('showCityChoice') && $userCity) {
            if (Auth::user() && Auth::user()->city()->first()->name == $userCity) {
                session(['showCityChoice' => false]);
            } else {
                session(['showCityChoice' => true]);
            }
        }
    }
}
