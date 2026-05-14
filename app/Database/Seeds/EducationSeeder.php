<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EducationSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['education_level' => 'ประถมศึกษา', 'school' => 'โรงเรียนพื้นบ้าน'],
            ['education_level' => 'มัธยมศึกษาต้น', 'school' => 'โรงเรียนมัธยม'],
            ['education_level' => 'มัธยมศึกษาปลาย', 'school' => 'โรงเรียนมัธยม'],
            ['education_level' => 'ปวช.', 'school' => 'วิทยาลัยอาชีวศึกษา'],
            ['education_level' => 'ปวส.', 'school' => 'วิทยาลัยอาชีวศึกษา'],
            ['education_level' => 'ปริญญาตรี', 'school' => 'มหาวิทยาลัย'],
            ['education_level' => 'ปริญญาโท', 'school' => 'มหาวิทยาลัย'],
        ];

        $this->db->table('educations')->insertBatch($data);
    }
}
