<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{
    function index() {
        if(!self::isLoggedIn()) return redirect()->to('/')->with('error', 'Anda Belum Login!');
        $title = session()->get('userdata')->role . ' | Dashboard';
        $user = new \App\Models\UserModel();
        $petugasBMN = $user->where('role', 'Petugas BMN')->countAllResults();
        $ketuaBagianUmum = $user->where('role', 'Ketua Bagian Umum')->countAllResults();
        $pengurus = $user->where('role', 'Pengurus Peralatan Pengeboran / Survei Explorasi')->countAllResults();
        $ketuaTimKelompokKerja = $user->where('role', 'Ketua Tim Kelompok Kerja')->countAllResults();
        $kepalaPSDMBP = $user->where('role', 'Kepala PSDMBP')->countAllResults();

        return view('dashboard/index', compact('title', 'petugasBMN', 'ketuaBagianUmum', 'pengurus', 'ketuaTimKelompokKerja', 'kepalaPSDMBP'));
    }

    function isLoggedIn() {
        return session()->has('userdata');
    }
}
