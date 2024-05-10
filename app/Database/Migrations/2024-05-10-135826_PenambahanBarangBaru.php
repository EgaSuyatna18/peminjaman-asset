<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PenambahanBarangBaru extends Migration
{
    public function up()
    {
        $this->forge->addField(array(
            'penambahan_barang_baru_id' => array(
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ),
            'tim_id' => array(
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ),
            'nama_pengusul' => array(
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ),
            'kak' => array(
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ),
            'status' => array(
                'type' => 'ENUM("Pending", "Diterima", "Ditolak")',
                'default' => 'Pending',
                'null' => FALSE,
            ),
        ));
        $this->forge->addKey('penambahan_barang_baru_id', true);
        $this->forge->addForeignKey('tim_id', 'tim', 'tim_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('penambahan_barang_baru');
    }

    public function down()
    {
        $this->forge->dropTable('penambahan_barang_baru');
    }
}
