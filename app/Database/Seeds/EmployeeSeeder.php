<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username'    => 'admin',
                'password'    => password_hash('admin123', PASSWORD_DEFAULT),
                'em_fullname' => 'Administrator',
                'position'    => 'Admin',
                'em_pic'      => null,
            ],
            [
                'username'    => 'staff',
                'password'    => password_hash('staff123', PASSWORD_DEFAULT),
                'em_fullname' => 'Staff Member',
                'position'    => 'Staff',
                'em_pic'      => null,
            ],
        ];

        $this->db->table('employee')->insertBatch($data);
    }
}
