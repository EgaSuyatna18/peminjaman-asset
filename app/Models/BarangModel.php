<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table            = 'barang';
    protected $primaryKey       = 'kode_barang';
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
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
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
            $builder = $this->db->table('barang');
            $builder->set($data);
            return $builder->insert();
        } catch (DatabaseException $e) {
            return false;
        }
    }

    function hapus($kode_barang) {
        try {
            $builder = $this->db->table('barang');
            $builder->where('kode_barang', $kode_barang);
            return $builder->delete();
        } catch (DatabaseException $e) {
            return false;
        }
    }

    function ubah($kode_barang, $data) {
        try {
            $builder = $this->db->table('barang');
            $builder->set($data);
            $builder->where('kode_barang', $kode_barang);
            return $builder->update();
        } catch (DatabaseException $e) {
            return false;
        }
    }
}
