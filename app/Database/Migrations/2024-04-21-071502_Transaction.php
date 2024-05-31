<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Transaction extends Migration
{
    public function up()
    {
        $this->forge->addField(
            [
                'id' => [
                    'type'              => 'INT',
                    'constraint'        => '11',
                    'unsigned'          => true,
                    'auto_increment'    => true
                ],
                'transaction_code' => [
                    'type'  => 'CHAR',
                    'constraint' => '16',
                    'null' => false
                ],
                'customer_name' => [
                    'type'  => 'VARCHAR',
                    'constraint' => '255'
                ],
                'customer_whatsapp' => [
                    'type'  => 'VARCHAR',
                    'constraint' => '255'
                ],
                'package' => [
                    'type' => 'VARCHAR',
                    'constraint' => '255'
                ],
                'weight' => [
                    'type' => 'FLOAT',
                    'unsigned' => true

                ],
                'total_payment' => [
                    'type' => 'INT',
                    'constraint'  => '11',
                    'unsigned'  => true
                ],
                'status' => [
                    'type' => 'VARCHAR',
                    'constraint' => '255'
                ],
                'created_at' => [
                    'type'  => 'DATETIME',
                    'null'  => true
                ],
                'updated_at' => [
                    'type'  => 'DATETIME',
                    'null'  => true
                ],
            ]
        );

        $this->forge->addKey('id', true);
        $this->forge->createTable('transaction');
    }

    public function down()
    {
        $this->forge->dropTable('transaction');
    }
}
