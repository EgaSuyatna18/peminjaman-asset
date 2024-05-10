<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Supplier extends Migration
{
    public function up()
    {
        $this->forge->addField(array(
            'supplier_id' => array(
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ),
            'nama_supplier' => array(
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'unique'     => TRUE
            ),
            'alamat' => array(
                'type'       => 'TEXT',
            ),
            'telepon' => array(
                'type'       => 'VARCHAR',
                'constraint' => '15',
            ),
        ));
        $this->forge->addKey('supplier_id', true);
        $this->forge->createTable('supplier');
    }

    public function down()
    {
        $this->forge->dropTable('supplier');
    }
}
