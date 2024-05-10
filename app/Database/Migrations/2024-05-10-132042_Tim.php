<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tim extends Migration
{
    public function up()
    {
        $this->forge->addField(array(
            'tim_id' => array(
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ),
            'nama_tim' => array(
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'unique'     => TRUE
            ),
            'nip' => array(
                'type'       => 'VARCHAR',
                'constraint' => '15',
            ),
            'gender' => array(
                'type' => 'ENUM("Laki-laki", "Perempuan")',
                'null' => FALSE,
            ),
            'telepon' => array(
                'type'       => 'VARCHAR',
                'constraint' => '15',
            ),
        ));
        $this->forge->addKey('tim_id', true);
        $this->forge->createTable('tim');
    }

    public function down()
    {
        $this->forge->dropTable('tim');
    }
}
