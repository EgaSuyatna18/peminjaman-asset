<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PengembalianBarang extends BaseController
{
    protected $pengembalian_barang;
    protected $peminjaman_barang;

    function __construct() {
        $this->pengembalian_barang = new \App\Models\PengembalianBarangModel();
        $this->peminjaman_barang = new \App\Models\PeminjamanBarangModel();
    }

    function index() {
        if(!self::isLoggedIn()) return redirect()->to('/')->with('error', 'Anda Belum Login!');
        $title = 'Pengembalian Barang';
        $pengembalians = $this->pengembalian_barang->select('barang.nama_barang, pengembalian_barang.*')->join('barang', 'barang.kode_barang = pengembalian_barang.kode_barang')->get()->getResult();
        $peminjamans = $this->peminjaman_barang->select('barang.nama_barang, peminjaman_barang.*')->join('barang', 'barang.kode_barang = peminjaman_barang.kode_barang')->get()->getResult();
        return view('dashboard/pengembalian_barang/index', compact('title', 'pengembalians', 'peminjamans'));
    }

    function store() {
        if(!self::isLoggedIn()) return redirect()->to('/')->with('error', 'Anda Belum Login!');
        $rules = [
            'peminjaman_barang_id' => 'required',
            'kondisi_barang_kembali' => 'required',
            'dokumentasi' => 'uploaded[dokumentasi]|mime_in[dokumentasi,image/png,image/jpg,image/jpeg]|max_size[dokumentasi, 4096]',
            'lokasi' => 'required',
            'penanggung_jawab_pengembalian' => 'required',
            'jumlah' => 'required'
        ];

        $data = $this->request->getPost(array_keys($rules));
        $dokumentasi = $this->request->getFile('dokumentasi');
        $validation = \Config\Services::validation();
        
        if(!$this->validateData($data, $rules)) {
            var_dump($validation->getErrors()); die;
            session()->setFlashdata('error', 'Gagal Menambah Data! Cek Input!');
            return redirect()->to('/pengembalian_barang');
        }
        
        $validData = $this->validator->getValidated();
        $validData['tanggal_kembali'] = date('Y-m-d H:i:00');
        $validData['kode_barang'] = $this->peminjaman_barang->getWhere(['peminjaman_barang_id' => $validData['peminjaman_barang_id']])->getRow()->kode_barang;
        unset($validData['peminjaman_barang_id']);

        if ($dokumentasi->isValid() && !$dokumentasi->hasMoved()) {
            $newName = $dokumentasi->getRandomName();
            $dokumentasi->move('uploads/dokumentasi/', $newName);

            $validData['dokumentasi'] = ['dokumentasi' => 'uploads/dokumentasi/' . $newName];

            if(!$this->pengembalian_barang->tambah($validData)) {
                session()->setFlashdata('error', 'Gagal Menambah Data! Cek Input!');
                return redirect()->to('/pengembalian_barang');
            }

            session()->setFlashdata('success', 'Berhasil Menambah Data.');
            return redirect()->to('/pengembalian_barang');
        }

        session()->setFlashdata('error', 'Gagal Menambah Data! Cek Input!');
        return redirect()->to('/pengembalian_barang');
    }

    function destroy($pengembalian_barang_id) {
        if(!self::isLoggedIn()) return redirect()->to('/')->with('error', 'Anda Belum Login!');
        $img = $this->pengembalian_barang->getWhere(['pengembalian_barang_id' => $pengembalian_barang_id])->getRow()->dokumentasi;
        unlink($img);
        if(!$this->pengembalian_barang->hapus($pengembalian_barang_id)) {
            session()->setFlashdata('error', 'Gagal Hapus Data! Cek Input!');
            return redirect()->to('/pengembalian_barang');
        }

        session()->setFlashdata('success', 'Berhasil Menghapus Data.');
        return redirect()->to('/pengembalian_barang');
    }

    function update($pengembalian_barang_id) {
        if(!self::isLoggedIn()) return redirect()->to('/')->with('error', 'Anda Belum Login!');
        $rules = [
            'tanggal_kembali_date' => 'required',
            'tanggal_kembali_time' => 'required',
            'kondisi_barang_kembali' => 'required',
            'lokasi' => 'required',
            'penanggung_jawab_pengembalian' => 'required',
        ];

        $dokumentasi = $this->request->getFile('dokumentasi');

        if($dokumentasi->isValid()) {
            $rules['dokumentasi'] = 'uploaded[dokumentasi]|mime_in[dokumentasi,image/png,image/jpg,image/jpeg]|max_size[dokumentasi, 4096]';
        }

        $data = $this->request->getPost(array_keys($rules));
        $validation = \Config\Services::validation();

        if(!$this->validateData($data, $rules)) {
            var_dump($validation->getErrors()); die;
            session()->setFlashdata('error', 'Gagal Mengubah Data! Cek Input!');
            return redirect()->to('/pengembalian_barang');
        }
        
        $validData = $this->validator->getValidated();
        unset($validData['tanggal_kembali_date']);
        unset($validData['tanggal_kembali_time']);

        if($dokumentasi->isValid()) {
            $img = $this->pengembalian_barang->getWhere(['pengembalian_barang_id' => $pengembalian_barang_id])->getRow()->dokumentasi;
            unlink($img);

            $newName = $dokumentasi->getRandomName();
            $dokumentasi->move('uploads/dokumentasi/', $newName);

            $validData['dokumentasi'] = ['dokumentasi' => 'uploads/dokumentasi/' . $newName];
        }

        if(!$this->pengembalian_barang->ubah($pengembalian_barang_id, $validData)) {
            session()->setFlashdata('error', 'Gagal Mengubah Data! Cek Input!');
            return redirect()->to('/pengembalian_barang');
        }

        session()->setFlashdata('success', 'Berhasil Mengubah Data.');
        return redirect()->to('/pengembalian_barang');
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
