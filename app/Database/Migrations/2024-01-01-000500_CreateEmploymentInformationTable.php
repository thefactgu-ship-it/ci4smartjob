<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmploymentInformationTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                 => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'personal_id'        => [
                'type' => 'INT',
            ],
            'job_status'         => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'termination_reason' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'company_name'       => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'company_type'       => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'date_out'           => [
                'type' => 'DATE',
                'null' => true,
            ],
            'job_position'       => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'company_address'    => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'company_province'   => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'company_district'   => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'company_subdistrict' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'salary'             => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
            ],
            'bank_name'          => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'bank_no'            => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
            ],
            'bank_pic'           => [
                'type' => 'LONGBLOB',
                'null' => true,
            ],
            'created_at'         => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at'         => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('personal_id', 'personal_information', 'personal_id', '', 'CASCADE');
        $this->forge->createTable('employment_information');
    }

    public function down()
    {
        $this->forge->dropTable('employment_information');
    }
}
