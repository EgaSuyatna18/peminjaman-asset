<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PeminjamanBarang extends Migration
{
    public function up()
    {
        $this->forge->addField(array(
            'peminjaman_barang_id' => array(
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ),
            'kode_barang' => array(
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ),
            'jumlah' => array(
                'type'           => 'INT',
                'unsigned'       => true,
            ),
            'deadline_kembali' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'penanggung_jawab_peminjaman' => array(
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ),
            'tanggal_pinjam DATETIME DEFAULT CURRENT_TIMESTAMP'
        ));
        $this->forge->addKey('peminjaman_barang_id', true);
        $this->forge->addForeignKey('kode_barang', 'barang', 'kode_barang', 'CASCADE', 'CASCADE');
        $this->forge->createTable('peminjaman_barang');
    }

    public function down()
    {
        $this->forge->dropTable('peminjaman_barang');
    }
}
