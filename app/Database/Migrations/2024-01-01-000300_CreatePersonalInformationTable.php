<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePersonalInformationTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'personal_id'  => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'title'        => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'first_name'   => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'last_name'    => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'gender'       => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'national_id'  => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'back_id'      => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'birth'        => [
                'type' => 'DATE',
                'null' => true,
            ],
            'profile_pic'  => [
                'type' => 'LONGBLOB',
                'null' => true,
            ],
            'address_id'   => [
                'type' => 'INT',
                'null' => true,
            ],
            'education_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'telephone'    => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'queue_status' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'default'    => 'pending',
                'null'       => true,
            ],
            'queue_ref'    => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'user_type'    => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'created_at'   => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at'   => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('personal_id', true);
        $this->forge->addForeignKey('address_id', 'address', 'address_id', '', 'CASCADE');
        $this->forge->addForeignKey('education_id', 'educations', 'education_id', '', 'CASCADE');
        $this->forge->createTable('personal_information');
    }

    public function down()
    {
        $this->forge->dropTable('personal_information');
    }
}
