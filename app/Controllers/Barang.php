<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Barang extends BaseController
{
    protected $barang;
    protected $supplier;

    function __construct() {
        $this->barang = new \App\Models\BarangModel();
        $this->supplier = new \App\Models\SupplierModel();
    }

    function index() {
        if(!self::isLoggedIn()) return redirect()->to('/')->with('error', 'Anda Belum Login!');
        $title = 'Barang';
        $barangs = $this->barang->join('supplier', 'supplier.supplier_id = barang.supplier_id')->get()->getResult();
        $suppliers = $this->supplier->get()->getResult();
        return view('dashboard/barang/index', compact('title', 'barangs', 'suppliers'));
    }

    function store() {
        if(!self::isLoggedIn()) return redirect()->to('/')->with('error', 'Anda Belum Login!');
        $rules = [
            'nama_barang' => 'required',
            'klasifikasi' => 'required',
            'jumlah' => 'required',
            'kondisi' => 'required',
            'merk' => 'required',
            'supplier_id' => 'required',
            'lokasi' => 'required',
            'penanggung_jawab' => 'required',
        ];

        $data = $this->request->getPost(array_keys($rules));
        $validation = \Config\Services::validation();
        
        if(!$this->validateData($data, $rules)) {
            session()->setFlashdata('errors', $validation);
            return redirect()->to('/barang');
        }
        
        $validData = $this->validator->getValidated();
        $validData['tanggal_beli'] = date('Y-m-d H:i:00');

        if(!$this->barang->tambah($validData)) {
            session()->setFlashdata('error', 'Nama Barang Sudah Ada!');
            return redirect()->to('/barang');
        }

        session()->setFlashdata('success', 'Berhasil Menambah Data.');
        return redirect()->to('/barang');
    }

    function destroy($barang_id) {
        if(!self::isLoggedIn()) return redirect()->to('/')->with('error', 'Anda Belum Login!');
        if(!$this->barang->hapus($barang_id)) {
            session()->setFlashdata('error', 'Gagal Hapus Data! Cek Input!');
            return redirect()->to('/barang');
        }

        session()->setFlashdata('success', 'Berhasil Menghapus Data.');
        return redirect()->to('/barang');
    }

    function update($barang_id) {
        if(!self::isLoggedIn()) return redirect()->to('/')->with('error', 'Anda Belum Login!');
        $rules = [
            'nama_barang' => 'required',
            'klasifikasi' => 'required',
            'tanggal_beli_date' => 'required',
            'tanggal_beli_time' => 'required',
            'jumlah' => 'required',
            'kondisi' => 'required',
            'merk' => 'required',
            'supplier_id' => 'required',
            'lokasi' => 'required',
            'penanggung_jawab' => 'required',
        ];

        $data = $this->request->getPost(array_keys($rules));
        $validation = \Config\Services::validation();
        
        if(!$this->validateData($data, $rules)) {
            session()->setFlashdata('errors', $validation);
            return redirect()->to('/barang');
        }
        
        $validData = $this->validator->getValidated();
        $validData['tanggal_beli'] = $validData['tanggal_beli_date'] . ' ' . $validData['tanggal_beli_time'];
        unset($validData['tanggal_beli_date']);
        unset($validData['tanggal_beli_time']);

        if(!$this->barang->ubah($barang_id, $validData)) {
            session()->setFlashdata('error', 'Gagal Mengubah Data! Cek Input!');
            return redirect()->to('/barang');
        }

        session()->setFlashdata('success', 'Berhasil Mengubah Data.');
        return redirect()->to('/barang');
    }

    function isLoggedIn() {
        return session()->has('userdata');
    }
}
