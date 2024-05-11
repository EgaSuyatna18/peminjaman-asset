<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Supplier extends BaseController
{

    protected $supplier;

    function __construct() {
        $this->supplier = new \App\Models\SupplierModel();
    }

    function index() {
        if(!self::isLoggedIn()) return redirect()->to('/')->with('error', 'Anda Belum Login!');
        $title = 'Supplier';
        $suppliers = $this->supplier->get()->getResult();
        return view('dashboard/supplier/index', compact('title', 'suppliers'));
    }

    function store() {
        if(!self::isLoggedIn()) return redirect()->to('/')->with('error', 'Anda Belum Login!');
        $rules = [
            'nama_supplier' => 'required',
            'alamat' => 'required',
            'telepon' => 'required'
        ];

        $data = $this->request->getPost(array_keys($rules));
        $validation = \Config\Services::validation();
        
        if(!$this->validateData($data, $rules)) {
            session()->setFlashdata('errors', $validation);
            return redirect()->to('/supplier');
        }
        
        $validData = $this->validator->getValidated();

        if(!$this->supplier->tambah($validData)) {
            session()->setFlashdata('error', 'Nama Supplier Sudah Ada!');
            return redirect()->to('/supplier');
        }

        session()->setFlashdata('success', 'Berhasil Menambah Data.');
        return redirect()->to('/supplier');
    }

    function destroy($supplier_id) {
        if(!self::isLoggedIn()) return redirect()->to('/')->with('error', 'Anda Belum Login!');
        if(!$this->supplier->hapus($supplier_id)) {
            session()->setFlashdata('error', 'Gagal Hapus Data! Cek Input!');
            return redirect()->to('/supplier');
        }

        session()->setFlashdata('success', 'Berhasil Menghapus Data.');
        return redirect()->to('/supplier');
    }

    function update($supplier_id) {
        if(!self::isLoggedIn()) return redirect()->to('/')->with('error', 'Anda Belum Login!');
        $rules = [
            'nama_supplier' => 'required',
            'alamat' => 'required',
            'telepon' => 'required'
        ];

        $data = $this->request->getPost(array_keys($rules));
        $validation = \Config\Services::validation();
        
        if(!$this->validateData($data, $rules)) {
            session()->setFlashdata('errors', $validation);
            return redirect()->to('/supplier');
        }
        
        $validData = $this->validator->getValidated();

        if(!$this->supplier->ubah($supplier_id, $validData)) {
            session()->setFlashdata('error', 'Gagal Mengubah Data! Cek Input!');
            return redirect()->to('/supplier');
        }

        session()->setFlashdata('success', 'Berhasil Mengubah Data.');
        return redirect()->to('/supplier');
    }

    function isLoggedIn() {
        return session()->has('userdata');
    }
}
