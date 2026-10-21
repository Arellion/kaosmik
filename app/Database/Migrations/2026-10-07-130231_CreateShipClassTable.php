<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateShipClassTable extends Migration
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
            'size' => [
                'type' => 'VARCHAR',
                'constraint' => 3,
                'null' => false,
            ],
            'crew' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'power_min' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'power_max' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
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
        $this->forge->createTable('ship_class');
    }

    public function down()
    {
        $this->forge->dropTable('ship_class');
    }
}
