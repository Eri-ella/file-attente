<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    public function show () {
        $services = Service::all();

        return view('client.service', ['services'=> $services]);
    }

    public function reservation () {
        return view('client.reservation');
    }

}
