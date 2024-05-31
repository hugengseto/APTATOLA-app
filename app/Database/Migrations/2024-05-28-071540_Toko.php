<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Store extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'store_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'store_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'store_address' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'store_telp' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'store_email' => [
                'type'  => 'VARCHAR',
                'constraint'    => '255'
            ]
        ]);
        $this->forge->addKey('store_id', true);
        $this->forge->createTable('store');
    }

    public function down()
    {
        $this->forge->dropTable('store');
    }
}
