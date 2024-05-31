<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Package extends Migration
{
    public function up()
    {
        $this->forge->addField(
            [
                'id' => [
                    'type' => 'INT',
                    'constraint' => '11',
                    'unsigned' => true,
                    'auto_increment' => true
                ],
                'package_name' => [
                    'type' => 'VARCHAR',
                    'constraint' => '255',
                ],
                'description' => [
                    'type' => 'TEXT'
                ],
                'price' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true
                ],
                'duration' => [
                    'type' => 'VARCHAR',
                    'constraint' => '255'
                ]
            ]
        );
        $this->forge->addKey('id', true);
        $this->forge->createTable('package');
    }

    public function down()
    {
        $this->forge->dropTable('package');
    }
}
