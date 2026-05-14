<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEducationsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'education_id'  => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'education_level' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'school'        => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'created_at'    => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at'    => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('education_id', true);
        $this->forge->createTable('educations');
    }

    public function down()
    {
        $this->forge->dropTable('educations');
    }
}
