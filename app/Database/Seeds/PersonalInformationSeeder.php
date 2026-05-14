<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PersonalInformationSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title'        => 'นาย',
                'first_name'   => 'สมชาย',
                'last_name'    => 'ใจมา',
                'gender'       => 'ชาย',
                'national_id'  => '1234567890123',
                'back_id'      => null,
                'birth'        => '1990-05-15',
                'profile_pic'  => null,
                'address_id'   => 1,
                'education_id' => 6,
                'telephone'    => '08-1111111',
                'queue_status' => 'pending',
                'queue_ref'    => 'REF-001',
                'user_type'    => 'job_seeker',
            ],
            [
                'title'        => 'นางสาว',
                'first_name'   => 'มารีย',
                'last_name'    => 'โสภณ',
                'gender'       => 'หญิง',
                'national_id'  => '1234567890124',
                'back_id'      => null,
                'birth'        => '1992-03-22',
                'profile_pic'  => null,
                'address_id'   => 2,
                'education_id' => 6,
                'telephone'    => '08-2222222',
                'queue_status' => 'approved',
                'queue_ref'    => 'REF-002',
                'user_type'    => 'job_seeker',
            ],
            [
                'title'        => 'นาย',
                'first_name'   => 'ประเสริฐ',
                'last_name'    => 'ศรีสวรรค์',
                'gender'       => 'ชาย',
                'national_id'  => '1234567890125',
                'back_id'      => null,
                'birth'        => '1988-11-10',
                'profile_pic'  => null,
                'address_id'   => 3,
                'education_id' => 7,
                'telephone'    => '08-3333333',
                'queue_status' => 'approved',
                'queue_ref'    => 'REF-003',
                'user_type'    => 'job_seeker',
            ],
            [
                'title'        => 'นางสาว',
                'first_name'   => 'จิราพร',
                'last_name'    => 'นยไหม',
                'gender'       => 'หญิง',
                'national_id'  => '1234567890126',
                'back_id'      => null,
                'birth'        => '1995-07-08',
                'profile_pic'  => null,
                'address_id'   => 4,
                'education_id' => 5,
                'telephone'    => '08-4444444',
                'queue_status' => 'pending',
                'queue_ref'    => 'REF-004',
                'user_type'    => 'student',
            ],
            [
                'title'        => 'นาย',
                'first_name'   => 'รัฐพล',
                'last_name'    => 'กิจวิทยา',
                'gender'       => 'ชาย',
                'national_id'  => '1234567890127',
                'back_id'      => null,
                'birth'        => '1993-09-30',
                'profile_pic'  => null,
                'address_id'   => 1,
                'education_id' => 6,
                'telephone'    => '08-5555555',
                'queue_status' => 'approved',
                'queue_ref'    => 'REF-005',
                'user_type'    => 'job_seeker',
            ],
        ];

        $this->db->table('personal_information')->insertBatch($data);
    }
}
