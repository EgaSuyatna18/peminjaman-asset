<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PengambalianBarang extends Migration
{
    public function up()
    {
        $this->forge->addField(array(
            'pengembalian_barang_id' => array(
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
            'kondisi_barang_kembali' => array(
                'type' => 'ENUM("Baik", "Tidak Lengkap", "Rusak")',
                'null' => FALSE,
            ),
            'dokumentasi' => array(
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ),
            'lokasi' => array(
                'type'       => 'TEXT',
            ),
            'penanggung_jawab_pengembalian' => array(
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ),
            'jumlah' => array(
                'type'           => 'INT',
                'unsigned'       => true,
            ),
            'tanggal_kembali DATETIME DEFAULT CURRENT_TIMESTAMP'
        ));
        $this->forge->addKey('pengembalian_barang_id', true);
        $this->forge->addForeignKey('kode_barang', 'barang', 'kode_barang', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pengembalian_barang');
    }

    public function down()
    {
        $this->forge->dropTable('pengembalian_barang');
    }
}
