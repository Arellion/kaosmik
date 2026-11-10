<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePlayerBuildingsTable extends Migration
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
            'player_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'building_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'construction_status' => [
                'type' => 'ENUM',
                'constraint' => ['Pas encore construit', 'En construction', 'construit']
            ],
            'level' => [
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => true,
                'default' => 1,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('player_id', 'players', 'id');
        $this->forge->addForeignKey('building_id', 'buildings', 'id');
        $this->forge->createTable('player_buildings');
    }

    public function down()
    {
        $this->forge->dropTable('player_buildings');
    }
}
