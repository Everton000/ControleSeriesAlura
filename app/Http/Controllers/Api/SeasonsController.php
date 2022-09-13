<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Series;
use App\Models\Season;

class SeasonsController extends Controller
{
    public function index(Series $series)
    {
        return $series->season;
    }
}
