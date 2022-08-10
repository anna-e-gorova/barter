<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Queries\QueryBuilderAds;
use App\Queries\QueryBuilderCategories;
use App\Queries\QueryBuilderCities;
use App\Queries\QueryBuilderStatuses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function index()
    {
        return view('user.profile.index');
    }

    public function createAd(
        QueryBuilderCategories $categoriesList,
        QueryBuilderCities $citiesList
    ) {
        return view('user.profile.createAd', [
            'categoriesList' => $categoriesList->listItems(['id', 'title']),
            'citiesList' => $citiesList->listItems(['id', 'name'])
        ]);
    }

    public function listAds(QueryBuilderAds $adsList)
    {
        return view('user.profile.listAds', ['ads' => $adsList->listAdsByUser(Auth::user()->id)]);
    }

    public function editAd(
        Request $request,
        QueryBuilderAds $adsDetail,
        QueryBuilderCategories $categoriesList,
        QueryBuilderCities $citiesList,
        QueryBuilderStatuses $statusesList
    ) {
        return view('user.profile.editAd', [
            'ad' => $adsDetail->getAdDetailById($request->ad),
            'categoriesList' => $categoriesList->listItems(['id', 'title']),
            'citiesList' => $citiesList->listItems(['id', 'name']),
            'statusesList' => $statusesList->listItems(['id', 'description'])
        ]);
    }
}
