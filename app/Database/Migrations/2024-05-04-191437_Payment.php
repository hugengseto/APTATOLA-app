<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Payment extends Migration
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
                'transaction_code' => [
                    'type' => 'VARCHAR',
                    'constraint' => '255'
                ],
                'employee_id' => [
                    'type' => 'INT',
                    'constraint' => '11',
                    'null' => false
                ],
                'payment_status' => [
                    'type' => 'VARCHAR',
                    'constraint' => '255'
                ],
                'payment_method' => [
                    'type' => 'VARCHAR',
                    'constraint' => '255'
                ],
                'money_paid' => [
                    'type' => 'INT',
                    'constraint'  => '11',
                    'unsigned'  => true
                ],
                'refund' => [
                    'type' => 'FLOAT',
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
        $this->forge->createTable('payment');
    }

    public function down()
    {
        $this->forge->dropTable('payment');
    }
}
