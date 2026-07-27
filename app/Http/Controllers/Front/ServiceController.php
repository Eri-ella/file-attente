<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function show () {
        return view('client.service');
    }

    public function reservation () {
        return view('client.reservation');
    }
}
