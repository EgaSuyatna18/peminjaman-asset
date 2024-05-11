<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PenambahanBarangBaru extends BaseController
{
    protected $penambahan_barang_baru;
    protected $tim;

    function __construct() {
        $this->penambahan_barang_baru = new \App\Models\PenambahanBarangBaruModel();
        $this->tim = new \App\Models\TimModel();
    }

    function index() {
        if(!self::isLoggedIn()) return redirect()->to('/')->with('error', 'Anda Belum Login!');
        $title = 'Penambahan Barang Baru';
        $penambahan_barang_barus = $this->penambahan_barang_baru->join('tim', 'tim.tim_id = penambahan_barang_baru.tim_id')->get()->getResult();
        $tims = $this->tim->get()->getResult();
        return view('dashboard/penambahan_barang_baru/index', compact('title', 'penambahan_barang_barus', 'tims'));
    }

    function store() {
        if(!self::isLoggedIn()) return redirect()->to('/')->with('error', 'Anda Belum Login!');
        $rules = [
            'tim_id' => 'required',
            'nama_pengusul' => 'required',
            'kak' => 'uploaded[kak]|mime_in[kak,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document]|max_size[kak, 4096]'
        ];

        $data = $this->request->getPost(array_keys($rules));
        $kak = $this->request->getFile('kak');
        $validation = \Config\Services::validation();
        
        if(!$this->validateData($data, $rules)) {
            session()->setFlashdata('error', 'Gagal Menambah Data! Cek Input!');
            return redirect()->to('/penambahan_barang_baru');
        }
        
        $validData = $this->validator->getValidated();

        if ($kak->isValid() && !$kak->hasMoved()) {
            $newName = $kak->getRandomName();
            $kak->move('uploads/kak/', $newName);

            $validData['kak'] = ['kak' => 'uploads/kak/' . $newName];

            if(!$this->penambahan_barang_baru->tambah($validData)) {
                session()->setFlashdata('error', 'Gagal Menambah Data! Cek Input!');
                return redirect()->to('/penambahan_barang_baru');
            }

            session()->setFlashdata('success', 'Berhasil Menambah Data.');
            return redirect()->to('/penambahan_barang_baru');
        }

        session()->setFlashdata('error', 'Gagal Menambah Data! Cek Input!');
        return redirect()->to('/penambahan_barang_baru');
    }

    function destroy($penambahan_barang_baru_id) {
        if(!self::isLoggedIn()) return redirect()->to('/')->with('error', 'Anda Belum Login!');
        $img = $this->penambahan_barang_baru->getWhere(['penambahan_barang_baru_id' => $penambahan_barang_baru_id])->getRow()->kak;
        unlink($img);
        if(!$this->penambahan_barang_baru->hapus($penambahan_barang_baru_id)) {
            session()->setFlashdata('error', 'Gagal Hapus Data! Cek Input!');
            return redirect()->to('/penambahan_barang_baru');
        }

        session()->setFlashdata('success', 'Berhasil Menghapus Data.');
        return redirect()->to('/penambahan_barang_baru');
    }

    function update($penambahan_barang_baru_id) {
        if(!self::isLoggedIn()) return redirect()->to('/')->with('error', 'Anda Belum Login!');
        $rules = [
            'tim_id' => 'required',
            'nama_pengusul' => 'required'
        ];

        $kak = $this->request->getFile('kak');

        if($kak->isValid()) {
            $rules['kak'] = 'uploaded[kak]|mime_in[kak,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document]|max_size[kak, 4096]';
        }

        $data = $this->request->getPost(array_keys($rules));
        $validation = \Config\Services::validation();
        
        if(!$this->validateData($data, $rules)) {
            session()->setFlashdata('error', 'Gagal Mengubah Data! Cek Input!');
            return redirect()->to('/penambahan_barang_baru');
        }
        
        $validData = $this->validator->getValidated();

        if($kak->isValid()) {
            $img = $this->penambahan_barang_baru->getWhere(['penambahan_barang_baru_id' => $penambahan_barang_baru_id])->getRow()->kak;
            unlink($img);

            $newName = $kak->getRandomName();
            $kak->move('uploads/kak/', $newName);

            $validData['kak'] = ['kak' => 'uploads/kak/' . $newName];
        }

        if(!$this->penambahan_barang_baru->ubah($penambahan_barang_baru_id, $validData)) {
            session()->setFlashdata('error', 'Gagal Mengubah Data! Cek Input!');
            return redirect()->to('/penambahan_barang_baru');
        }

        session()->setFlashdata('success', 'Berhasil Mengubah Data.');
        return redirect()->to('/penambahan_barang_baru');
    }

    function isLoggedIn() {
        return session()->has('userdata');
    }

    function diterima($penambahan_barang_baru_id) {
        if(!self::isLoggedIn()) return redirect()->to('/')->with('error', 'Anda Belum Login!');
        if(!$this->penambahan_barang_baru->diterima($penambahan_barang_baru_id)) {
            session()->setFlashdata('error', 'Gagal Mengubah Status Data! Cek Input!');
            return redirect()->to('/penambahan_barang_baru');
        }
        
        session()->setFlashdata('success', 'Berhasil Menerima Data.');
        return redirect()->to('/penambahan_barang_baru');
    }

    function ditolak($penambahan_barang_baru_id) {
        if(!self::isLoggedIn()) return redirect()->to('/')->with('error', 'Anda Belum Login!');
        if(!$this->penambahan_barang_baru->ditolak($penambahan_barang_baru_id)) {
            session()->setFlashdata('error', 'Gagal Mengubah Status Data! Cek Input!');
            return redirect()->to('/penambahan_barang_baru');
        }
        
        session()->setFlashdata('success', 'Berhasil Menolak Data.');
        return redirect()->to('/penambahan_barang_baru');
    }
}
