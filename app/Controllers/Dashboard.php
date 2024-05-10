<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{
    function index() {
        if(!self::isLoggedIn()) return redirect()->to('/')->with('error', 'Anda Belum Login!');
        $title = session()->get('userdata')->role . ' | Dashboard';
        return view('dashboard/index', compact('title'));
    }

    function isLoggedIn() {
        return session()->has('userdata');
    }
}
