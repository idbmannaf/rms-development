<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function getRegionToZones(Region $region)
    {
        $zones = $region->zones;
        return $zones;
    }
}
