<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Barang extends Migration
{
    public function up()
    {
        // $this->forge->addField(array(
        //     'kode_barang' => array(
        //         'type'           => 'INT',
        //         'constraint'     => 5,
        //         'unsigned'       => true,
        //         'auto_increment' => true,
        //     ),
        //     'nama_barang' => array(
        //         'type'       => 'VARCHAR',
        //         'constraint' => '50',
        //         'unique'     => TRUE
        //     ),
        //     'klasifikasi' => array(
        //         'type'       => 'VARCHAR',
        //         'constraint' => '25'
        //     ),
        //     'jumlah' => array(
        //         'type'       => 'INT',
        //         'unsigned'       => true
        //     ),
        //     'kondisi' => array(
        //         'type' => 'ENUM("Baik","Tidak Lengkap","Rusak")',
        //         'null' => FALSE,
        //     ),
        //     'merk' => array(
        //         'type'       => 'VARCHAR',
        //         'constraint' => '25'
        //     ),
        //     'supplier_id' => array(
        //         'type'           => 'INT',
        //         'constraint'     => 5,
        //         'unsigned'       => true,
        //     ),
        //     'lokasi' => array(
        //         'type'       => 'VARCHAR',
        //         'constraint' => '25'
        //     ),
        //     'tanggal_beli DATETIME DEFAULT CURRENT_TIMESTAMP'
        // ));
        // $this->forge->addKey('barang_id', true);
        // $this->forge->addForeignKey('supplier_id', 'supplier', 'supplier_id', 'CASCADE', 'CASCADE');
        // $this->forge->createTable('barang');
    }

    public function down()
    {
        // $this->forge->dropTable('barang');
    }
}
