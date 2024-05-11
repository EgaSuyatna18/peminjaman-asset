<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PeminjamanBarang extends BaseController
{
    protected $peminjaman_barang;
    protected $barang;

    function __construct() {
        $this->peminjaman_barang = new \App\Models\PeminjamanBarangModel();
        $this->barang = new \App\Models\BarangModel();
    }

    function index() {
        if(!self::isLoggedIn()) return redirect()->to('/')->with('error', 'Anda Belum Login!');
        $title = 'Peminjaman Barang';
        $peminjamans = $this->peminjaman_barang->select('barang.nama_barang, peminjaman_barang.*')->join('barang', 'barang.kode_barang = peminjaman_barang.kode_barang')->get()->getResult();
        $barangs = $this->barang->get()->getResult();
        return view('dashboard/peminjaman_barang/index', compact('title', 'peminjamans', 'barangs'));
    }

    function store() {
        if(!self::isLoggedIn()) return redirect()->to('/')->with('error', 'Anda Belum Login!');
        $rules = [
            'kode_barang' => 'required',
            'jumlah' => 'required',
            'deadline_kembali_date' => 'required',
            'deadline_kembali_time' => 'required',
            'penanggung_jawab_peminjaman' => 'required'
        ];

        $data = $this->request->getPost(array_keys($rules));
        $validation = \Config\Services::validation();
        
        if(!$this->validateData($data, $rules)) {
            session()->setFlashdata('errors', $validation);
            return redirect()->to('/peminjaman_barang');
        }
        
        $validData = $this->validator->getValidated();
        $validData['tanggal_pinjam'] = date('Y-m-d H:i:00');
        $validData['deadline_kembali'] = $validData['deadline_kembali_date'] . ' ' . $validData['deadline_kembali_time'];
        unset($validData['deadline_kembali_date']);
        unset($validData['deadline_kembali_time']);

        if(!$this->peminjaman_barang->tambah($validData)) {
            session()->setFlashdata('error', 'Gagal Hapus Data! Cek Input!');
            return redirect()->to('/peminjaman_barang');
        }

        session()->setFlashdata('success', 'Berhasil Menambah Data.');
        return redirect()->to('/peminjaman_barang');
    }

    function destroy($peminjaman_barang_id) {
        if(!self::isLoggedIn()) return redirect()->to('/')->with('error', 'Anda Belum Login!');
        if(!$this->peminjaman_barang->hapus($peminjaman_barang_id)) {
            session()->setFlashdata('error', 'Gagal Hapus Data! Cek Input!');
            return redirect()->to('/peminjaman_barang');
        }

        session()->setFlashdata('success', 'Berhasil Menghapus Data.');
        return redirect()->to('/peminjaman_barang');
    }

    function update($peminjaman_barang_id) {
        if(!self::isLoggedIn()) return redirect()->to('/')->with('error', 'Anda Belum Login!');
        $rules = [
            'kode_barang' => 'required',
            'jumlah' => 'required',
            'tanggal_pinjam_date' => 'required',
            'tanggal_pinjam_time' => 'required',
            'deadline_kembali_date' => 'required',
            'deadline_kembali_time' => 'required',
            'penanggung_jawab_peminjaman' => 'required'
        ];

        $data = $this->request->getPost(array_keys($rules));
        $validation = \Config\Services::validation();
        
        if(!$this->validateData($data, $rules)) {
            session()->setFlashdata('errors', $validation);
            return redirect()->to('/peminjaman_barang');
        }
        
        $validData = $this->validator->getValidated();
        $validData['deadline_kembali'] = $validData['deadline_kembali_date'] . ' ' . $validData['deadline_kembali_time'];
        unset($validData['deadline_kembali_date']);
        unset($validData['deadline_kembali_time']);
        $validData['tanggal_pinjam'] = $validData['tanggal_pinjam_date'] . ' ' . $validData['tanggal_pinjam_time'];
        unset($validData['tanggal_pinjam_date']);
        unset($validData['tanggal_pinjam_time']);

        if(!$this->peminjaman_barang->ubah($peminjaman_barang_id, $validData)) {
            session()->setFlashdata('error', 'Gagal Mengubah Data! Cek Input!');
            return redirect()->to('/peminjaman_barang');
        }

        session()->setFlashdata('success', 'Berhasil Mengubah Data.');
        return redirect()->to('/peminjaman_barang');
    }

    function isLoggedIn() {
        return session()->has('userdata');
    }
}
