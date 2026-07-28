<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConnexionController extends Controller
{
    // administrateur
    public function connexionAdmin () {
        return view('admin.connexionAdmin');
    }

    // manager
    public function connexionManager () {
        return view('manager.pageManager'); 
    }
}
