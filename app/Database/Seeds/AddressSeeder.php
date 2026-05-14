<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AddressSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'address'     => '123 ถนนสายหลัก',
                'district'    => 'บางกะปิ',
                'province'    => 'กรุงเทพมหานคร',
                'postal_code' => '10110',
            ],
            [
                'address'     => '456 ซอยสวนแคว',
                'district'    => 'สวนหลวง',
                'province'    => 'กรุงเทพมหานคร',
                'postal_code' => '10250',
            ],
            [
                'address'     => '789 ถนนโชคชัย',
                'district'    => 'จตุจักร',
                'province'    => 'กรุงเทพมหานคร',
                'postal_code' => '10900',
            ],
            [
                'address'     => '321 ถนนรัชดา',
                'district'    => 'ดินแดง',
                'province'    => 'กรุงเทพมหานคร',
                'postal_code' => '10400',
            ],
        ];

        $this->db->table('address')->insertBatch($data);
    }
}
