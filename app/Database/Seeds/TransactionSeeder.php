<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
use DateTime;
use Faker\Factory;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        $fake = Factory::create('id_ID');

        function generateTransactionCode($length = 8)
        {
            // Karakter yang digunakan untuk kode transaksi
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

            // Panjang kode transaksi
            $codeLength = strlen($characters);

            // Inisialisasi variabel untuk menyimpan kode transaksi
            $code = '';

            // Generate kode transaksi secara acak
            for ($i = 0; $i < $length; $i++) {
                $code .= $characters[rand(0, $codeLength - 1)];
            }

            return $code;
        }

        function generateStatus($length = 1)
        {
            // Karakter yang digunakan untuk kode transaksi
            $characters = '123';

            // Panjang kode transaksi
            $codeLength = strlen($characters);

            // Inisialisasi variabel untuk menyimpan kode transaksi
            $status = $characters[rand(0, $codeLength - 1)];

            // Generate status transaksi secara acak
            if ($status == 1) {
                $status = "Done";
            } else if ($status == 2) {
                $status = "In Progress";
            } else {
                $status = "In Queue";
            };

            return $status;
        }

        for ($i = 0; $i < 100; $i++) {
            $transaction_code = generateTransactionCode(10);
            $status = generateStatus();
            $data = [
                'transaction_code'  => $transaction_code,
                'customer_name'     => $fake->name(),
                'customer_whatsapp' => $fake->phoneNumber(),
                'package'           => $fake->numberBetween(1, 3),
                'weight'            => $fake->numberBetween(1, 10),
                'total_payment'     => $fake->randomNumber(5, true),
                'status'            => $status,
                'created_at'        => Time::createFromTimestamp($fake->unixTime(new DateTime())),
                'updated_at'        => Time::now(),
            ];

            $this->db->table('transaction')->insert($data);
        }
    }
}
