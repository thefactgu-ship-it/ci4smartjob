<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCompanyTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'company_id'       => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'company_name'     => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'company_email'    => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'company_number'   => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'company_nationid' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'company_emfullname' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'company_add'      => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'company_telephone' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'created_at'       => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at'       => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('company_id', true);
        $this->forge->createTable('company');
    }

    public function down()
    {
        $this->forge->dropTable('company');
    }
}
