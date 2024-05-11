<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Tim extends BaseController
{
    protected $tim;

    function __construct() {
        $this->tim = new \App\Models\TimModel();
    }

    function index() {
        if(!self::isLoggedIn()) return redirect()->to('/')->with('error', 'Anda Belum Login!');
        $title = 'Tim';
        $tims = $this->tim->get()->getResult();
        return view('dashboard/tim/index', compact('title', 'tims'));
    }

    function store() {
        if(!self::isLoggedIn()) return redirect()->to('/')->with('error', 'Anda Belum Login!');
        $rules = [
            'nama_tim' => 'required',
            'nip' => 'required',
            'gender' => 'required',
            'telepon' => 'required'
        ];

        $data = $this->request->getPost(array_keys($rules));
        $validation = \Config\Services::validation();
        
        if(!$this->validateData($data, $rules)) {
            session()->setFlashdata('errors', $validation);
            return redirect()->to('/tim');
        }
        
        $validData = $this->validator->getValidated();

        if(!$this->tim->tambah($validData)) {
            session()->setFlashdata('error', 'Nama Tim Sudah Ada!');
            return redirect()->to('/tim');
        }

        session()->setFlashdata('success', 'Berhasil Menambah Data.');
        return redirect()->to('/tim');
    }

    function destroy($tim_id) {
        if(!self::isLoggedIn()) return redirect()->to('/')->with('error', 'Anda Belum Login!');
        if(!$this->tim->hapus($tim_id)) {
            session()->setFlashdata('error', 'Gagal Hapus Data! Cek Input!');
            return redirect()->to('/tim');
        }

        session()->setFlashdata('success', 'Berhasil Menghapus Data.');
        return redirect()->to('/tim');
    }

    function update($tim_id) {
        if(!self::isLoggedIn()) return redirect()->to('/')->with('error', 'Anda Belum Login!');
        $rules = [
            'nama_tim' => 'required',
            'nip' => 'required',
            'gender' => 'required',
            'telepon' => 'required'
        ];

        $data = $this->request->getPost(array_keys($rules));
        $validation = \Config\Services::validation();
        
        if(!$this->validateData($data, $rules)) {
            session()->setFlashdata('errors', $validation);
            return redirect()->to('/tim');
        }
        
        $validData = $this->validator->getValidated();

        if(!$this->tim->ubah($tim_id, $validData)) {
            session()->setFlashdata('error', 'Gagal Mengubah Data! Cek Input!');
            return redirect()->to('/tim');
        }

        session()->setFlashdata('success', 'Berhasil Mengubah Data.');
        return redirect()->to('/tim');
    }

    function isLoggedIn() {
        return session()->has('userdata');
    }
}
