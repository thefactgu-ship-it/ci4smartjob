<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAddressTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'address_id' => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'address'    => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'district'   => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'province'   => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'postal_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('address_id', true);
        $this->forge->createTable('address');
    }

    public function down()
    {
        $this->forge->dropTable('address');
    }
}
