<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField(array(
            'user_id' => array(
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ),
            'role' => array(
                'type' => 'ENUM("Petugas BMN","Ketua Bagian Umum","Pengurus Peralatan Pengeboran / Survei Explorasi", "Ketua Tim Kelompok Kerja", "Kepala PSDMBP")',
                'null' => FALSE,
            ),
            'nama' => array(
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ),
            'username' => array(
                'type'       => 'VARCHAR',
                'constraint' => '25',
                'unique'     => TRUE
            ),
            'password' => array(
                'type'       => 'VARCHAR',
                'constraint' => '25',
            ),
        ));
        $this->forge->addKey('user_id', true);
        $this->forge->createTable('user');
    }

    public function down()
    {
        $this->forge->dropTable('user');
    }
}
