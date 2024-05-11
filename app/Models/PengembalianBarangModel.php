<?php

namespace App\Models;

use CodeIgniter\Model;

class PengembalianBarangModel extends Model
{
    protected $table            = 'pengembalian_barang';
    protected $primaryKey       = 'pengembalian_barang_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'tanggal_kembali';
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
            $builder = $this->db->table('pengembalian_barang');
            $builder->set($data);
            return $builder->insert();
        } catch (DatabaseException $e) {
            return false;
        }
    }

    function hapus($pengembalian_barang_id) {
        try {
            $builder = $this->db->table('pengembalian_barang');
            $builder->where('pengembalian_barang_id', $pengembalian_barang_id);
            return $builder->delete();
        } catch (DatabaseException $e) {
            return false;
        }
    }

    function ubah($pengembalian_barang_id, $data) {
        try {
            $builder = $this->db->table('pengembalian_barang');
            $builder->set($data);
            $builder->where('pengembalian_barang_id', $pengembalian_barang_id);
            return $builder->update();
        } catch (DatabaseException $e) {
            return false;
        }
    }
}
