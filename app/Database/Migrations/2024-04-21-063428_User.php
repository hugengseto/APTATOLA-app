<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
    public function up()
    {
        $this->forge->addField(
            [
                'username' => [
                    'type' => 'VARCHAR',
                    'constraint' => '255',
                ],
                'fullname' => [
                    'type' => 'VARCHAR',
                    'constraint' => '255'
                ],
                'email' => [
                    'type' => 'VARCHAR',
                    'constraint' => '255'
                ],
                'whatsapp' => [
                    'type' => 'VARCHAR',
                    'constraint' => '255'
                ],
                'status'    => [
                    'type'  => 'VARCHAR',
                    'constraint' => '255'
                ],
                'password'  => [
                    'type'  => 'VARCHAR',
                    'constraint' => '255'
                ],
                'photo'  => [
                    'type'  => 'VARCHAR',
                    'constraint' => '255'
                ],
                'user_role' => [
                    'type'  => 'INT',
                    'constraint' => '11',
                    'unsigned' => true
                ]
            ]
        );
        $this->forge->addKey('username', true);
        $this->forge->createTable('user');
    }

    public function down()
    {
        $this->forge->dropTable('user');
    }
}
