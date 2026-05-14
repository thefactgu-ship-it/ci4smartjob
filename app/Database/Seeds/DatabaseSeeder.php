<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('EmployeeSeeder');
        $this->call('EducationSeeder');
        $this->call('AddressSeeder');
        $this->call('CompanySeeder');
        $this->call('PersonalInformationSeeder');
    }
}
