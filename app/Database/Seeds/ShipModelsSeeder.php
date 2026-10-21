<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
class ShipModelsSeeder extends Seeder
{
    public function run()
    {
        $now = Time::now()->toDateTimeString();

        $data = [
            [
                'ship_class_id' => 1,
                'name'          => 'Faucon Millenium',
                'description'   => 'Un cargo YT-1300 fortement personnalisé avec hyperdrive de classe 0.5.',
                'created_at'    => $now,
            ],
            [
                'ship_class_id' => 2,
                'name'          => 'X-Wing',
                'description'   => 'Chasseur d d\'assaut polyvalent équipé de quatre canons laser.',
                'created_at'    => $now,
            ],
            [
                'ship_class_id' => 3,
                'name'          => 'TIE',
                'description'   => 'Chasseur rapide sans bouclier déflecteur produit en série.',
                'created_at'    => $now,
            ],
            [
                'ship_class_id' => 4,
                'name'          => 'L\'Exécuteur',
                'description'   => 'Vaisseau amiral doté d\'une puissance de feu colossale.',
                'created_at'    => $now,
            ],
        ];

        // Insertion groupée dans la table 'ship_models'
        $this->db->table('ship_models')->insertBatch($data);
    }
}
