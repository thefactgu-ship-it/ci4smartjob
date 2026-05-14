<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCompanySelectTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'company_id' => [
                'type' => 'INT',
            ],
            'personal_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'status'     => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'default'    => 'pending',
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
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('company_id', 'company', 'company_id', '', 'CASCADE');
        $this->forge->addForeignKey('personal_id', 'personal_information', 'personal_id', '', 'CASCADE');
        $this->forge->createTable('company_select');
    }

    public function down()
    {
        $this->forge->dropTable('company_select');
    }
}
