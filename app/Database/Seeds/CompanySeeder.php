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
                'company_email'     => 'company001@example.com',
                'company_number'    => 'DEMO-COMPANY-001',
                'company_nationid'  => 'DEMO-TAX-001',
                'company_emfullname' => 'นายสมชาย สมศรี',
                'company_add'       => '789 ถนนเพชรบุรี แขวงมักกะสัน เขตราชเทวี กรุงเทพมหานคร',
                'company_telephone' => 'DEMO-PHONE-101',
            ],
            [
                'company_name'      => 'บริษัท กรีนแอปส์ จำกัด',
                'company_email'     => 'company002@example.com',
                'company_number'    => 'DEMO-COMPANY-002',
                'company_nationid'  => 'DEMO-TAX-002',
                'company_emfullname' => 'นางสาวมะลิ เชียงพัฒน์',
                'company_add'       => '456 ถนนสุขุมวิท แขวงบางนา เขตบางนา กรุงเทพมหานคร',
                'company_telephone' => 'DEMO-PHONE-102',
            ],
            [
                'company_name'      => 'บริษัท อินโนเวท โซลูชัน',
                'company_email'     => 'company003@example.com',
                'company_number'    => 'DEMO-COMPANY-003',
                'company_nationid'  => 'DEMO-TAX-003',
                'company_emfullname' => 'นายวิทยา ศรีวัฒน์',
                'company_add'       => '321 ถนนสีลม แขวงบางรัก เขตบางรัก กรุงเทพมหานคร',
                'company_telephone' => 'DEMO-PHONE-103',
            ],
            [
                'company_name'      => 'บริษัท สมาร์ทแรม จำกัด',
                'company_email'     => 'company004@example.com',
                'company_number'    => 'DEMO-COMPANY-004',
                'company_nationid'  => 'DEMO-TAX-004',
                'company_emfullname' => 'นายพรหม พรมาณ',
                'company_add'       => '654 ถนนพระราม 4 แขวงกุมเภวง เขตป้อมปราบศัตรูพ่าย กรุงเทพมหานคร',
                'company_telephone' => 'DEMO-PHONE-104',
            ],
            [
                'company_name'      => 'บริษัท ดิจิทัลไทย เวิร์คส',
                'company_email'     => 'company005@example.com',
                'company_number'    => 'DEMO-COMPANY-005',
                'company_nationid'  => 'DEMO-TAX-005',
                'company_emfullname' => 'นางสาวนันท์ฉัตร นิ่มนวล',
                'company_add'       => '987 ถนนวิทยุ แขวงลุมพินี เขตปทุมวัน กรุงเทพมหานคร',
                'company_telephone' => 'DEMO-PHONE-105',
            ],
        ];

        $this->db->table('company')->insertBatch($data);
    }
}
