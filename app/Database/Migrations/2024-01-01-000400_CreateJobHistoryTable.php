<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJobHistoryTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                   => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'personal_id'          => [
                'type' => 'INT',
            ],
            'position'             => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'salary'               => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
            ],
            'description'          => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'promote_occupation'   => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'consent'              => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'default'    => 'no',
                'null'       => true,
            ],
            'created_at'           => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at'           => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('personal_id', 'personal_information', 'personal_id', '', 'CASCADE');
        $this->forge->createTable('job_history');
    }

    public function down()
    {
        $this->forge->dropTable('job_history');
    }
}
