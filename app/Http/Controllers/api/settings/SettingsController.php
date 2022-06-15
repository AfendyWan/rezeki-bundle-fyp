<?php

namespace App\Http\Controllers\Api\settings;

use App\Models\State;
use App\Models\City;
use App\Models\Adminsetting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller{

    public function showAllStates()
    {
        $allStates = State::all();
        return response()->json($allStates);
    }
    public function showAllCities()
    {
        $allCities = City::all();
        return response()->json($allCities);
    }

    public function getAdminSettings()
    {       
        $getAdminSettings = Adminsetting::all();
        return response()->json($getAdminSettings);       
    }
}
