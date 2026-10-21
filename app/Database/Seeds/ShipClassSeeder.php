<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class ShipClassSeeder extends Seeder
{
    public function run()
    {
        $now = Time::now()->toDateTimeString();

        $data = [
            [
                'size'       => 'S',
                'crew'       => 2,
                'power_min'  => 3,
                'power_max'  => 6,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'size'       => 'XS',
                'crew'       => 1,
                'power_min'  => 1,
                'power_max'  => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'size'       => 'XXL',
                'crew'       => 6,
                'power_min'  => 5,
                'power_max'  => 10,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'size'       => 'XL',
                'crew'       => 4,
                'power_min'  => 8,
                'power_max'  => 20,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // Insertion groupée dans la table 'ship_class'
        $this->db->table('ship_class')->insertBatch($data);
    }
}