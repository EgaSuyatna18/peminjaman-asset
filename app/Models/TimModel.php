<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\Exceptions\DatabaseException;

class TimModel extends Model
{
    protected $table            = 'tim';
    protected $primaryKey       = 'tim_id';
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
            $builder = $this->db->table('tim');
            $builder->set($data);
            return $builder->insert();
        } catch (DatabaseException $e) {
            return false;
        }
    }

    function hapus($tim_id) {
        try {
            $builder = $this->db->table('tim');
            $builder->where('tim_id', $tim_id);
            return $builder->delete();
        } catch (DatabaseException $e) {
            return false;
        }
    }

    function ubah($tim_id, $data) {
        try {
            $builder = $this->db->table('tim');
            $builder->set($data);
            $builder->where('tim_id', $tim_id);
            return $builder->update();
        } catch (DatabaseException $e) {
            return false;
        }
    }
}
