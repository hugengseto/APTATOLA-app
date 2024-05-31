<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
use DateTime;
use Faker\Factory;

class PackageSeeder extends Seeder
{
    public function run()
    {
        $fake = Factory::create('id_ID');

        for ($i = 0; $i < 3; $i++) {
            $data = [
                'package_name'      => $fake->userName(),
                'description'       => $fake->text(),
                'price'             => $fake->randomNumber(5, true),
                'duration'          => $fake->numberBetween(1, 5)
            ];

            $this->db->table('package')->insert($data);
        }
    }
}
