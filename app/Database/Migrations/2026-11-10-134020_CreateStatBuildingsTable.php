<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStatBuildingsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'bonus_experience_reward' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'unsigned' => true,
            ],
            'bonus_energy_reward' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'unsigned' => true,
            ],
            'bonus_credit_reward' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'unsigned' => true,
            ],
            'bonus_power' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('stat_buildings');
    }

    public function down()
    {
        $this->forge->dropTable('stat_buildings');
    }
}
