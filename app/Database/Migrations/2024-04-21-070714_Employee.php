<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Employee extends Migration
{
    public function up()
    {
        $this->forge->addField(
            [
                'id' => [
                    'type' => 'INT',
                    'constraint' => '11',
                    'unsigned'  => true,
                    'auto_increment' => true
                ],
                'name' => [
                    'type' => 'VARCHAR',
                    'constraint' => '255'
                ],
                'whatsapp' => [
                    'type' => 'VARCHAR',
                    'constraint' => '255'
                ],
                'address' => [
                    'type'  => 'TEXT'
                ],
                'photo'  => [
                    'type' => 'VARCHAR',
                    'constraint' => '255'
                ]
            ]
        );
        $this->forge->addKey('id', true);
        $this->forge->createTable('employee');
    }

    public function down()
    {
        $this->forge->dropTable('employee');
    }
}
