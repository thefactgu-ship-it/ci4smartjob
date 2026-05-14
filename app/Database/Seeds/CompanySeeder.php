<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'company_name'      => 'บริษัท ไทยเทค จำกัด',
                'company_email'     => 'contact@thaitech.co.th',
                'company_number'    => '02-1234567',
                'company_nationid'  => '0123456789012',
                'company_emfullname' => 'นายสมชาย สมศรี',
                'company_add'       => '789 ถนนเพชรบุรี แขวงมักกะสัน เขตราชเทวี กรุงเทพมหานคร',
                'company_telephone' => '08-1234567',
            ],
            [
                'company_name'      => 'บริษัท กรีนแอปส์ จำกัด',
                'company_email'     => 'info@greenapps.co.th',
                'company_number'    => '02-7654321',
                'company_nationid'  => '0123456789013',
                'company_emfullname' => 'นางสาวมะลิ เชียงพัฒน์',
                'company_add'       => '456 ถนนสุขุมวิท แขวงบางนา เขตบางนา กรุงเทพมหานคร',
                'company_telephone' => '08-7654321',
            ],
            [
                'company_name'      => 'บริษัท อินโนเวท โซลูชัน',
                'company_email'     => 'hello@innovate.co.th',
                'company_number'    => '02-5555555',
                'company_nationid'  => '0123456789014',
                'company_emfullname' => 'นายวิทยา ศรีวัฒน์',
                'company_add'       => '321 ถนนสีลม แขวงบางรัก เขตบางรัก กรุงเทพมหานคร',
                'company_telephone' => '08-5555555',
            ],
            [
                'company_name'      => 'บริษัท สมาร์ทแรม จำกัด',
                'company_email'     => 'support@smartram.co.th',
                'company_number'    => '02-9999999',
                'company_nationid'  => '0123456789015',
                'company_emfullname' => 'นายพรหม พรมาณ',
                'company_add'       => '654 ถนนพระราม 4 แขวงกุมเภวง เขตป้อมปราบศัตรูพ่าย กรุงเทพมหานคร',
                'company_telephone' => '08-9999999',
            ],
            [
                'company_name'      => 'บริษัท ดิจิทัลไทย เวิร์คส',
                'company_email'     => 'work@digitalthailand.co.th',
                'company_number'    => '02-3333333',
                'company_nationid'  => '0123456789016',
                'company_emfullname' => 'นางสาวนันท์ฉัตร นิ่มนวล',
                'company_add'       => '987 ถนนวิทยุ แขวงลุมพินี เขตปทุมวัน กรุงเทพมหานคร',
                'company_telephone' => '08-3333333',
            ],
        ];

        $this->db->table('company')->insertBatch($data);
    }
}
