<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanBarangModel extends Model
{
    protected $table            = 'peminjaman_barang';
    protected $primaryKey       = 'peminjaman_barang_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'tanggal_pinjam';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    function tambah($data) {
        try {
            $builder = $this->db->table('peminjaman_barang');
            $builder->set($data);
            return $builder->insert();
        } catch (DatabaseException $e) {
            return false;
        }
    }

    function hapus($peminjaman_barang_id) {
        try {
            $builder = $this->db->table('peminjaman_barang');
            $builder->where('peminjaman_barang_id', $peminjaman_barang_id);
            return $builder->delete();
        } catch (DatabaseException $e) {
            return false;
        }
    }

    function ubah($peminjaman_barang_id, $data) {
        try {
            $builder = $this->db->table('peminjaman_barang');
            $builder->set($data);
            $builder->where('peminjaman_barang_id', $peminjaman_barang_id);
            return $builder->update();
        } catch (DatabaseException $e) {
            return false;
        }
    }
}
