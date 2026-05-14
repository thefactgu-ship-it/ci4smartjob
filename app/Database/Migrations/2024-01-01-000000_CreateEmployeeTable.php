<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmployeeTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'em_id'       => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'username'    => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'password'    => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'em_fullname' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'position'    => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'em_pic'      => [
                'type' => 'LONGBLOB',
                'null' => true,
            ],
            'created_at'  => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at'  => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('em_id', true);
        $this->forge->createTable('employee');
    }

    public function down()
    {
        $this->forge->dropTable('employee');
    }
}
