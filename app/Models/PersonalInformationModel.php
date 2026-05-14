<?php

namespace App\Models;

use CodeIgniter\Model;

class PersonalInformationModel extends Model
{
    protected $table = 'personal_information';
    protected $primaryKey = 'personal_id';

    // กำหนดฟิลด์ที่สามารถบันทึกได้
    protected $allowedFields = [
        'title',
        'first_name',
        'last_name',
        'gender',
        'national_id',
        'back_id',
        'birth',
        'profile_pic',
        'address_id', // เพิ่ม address_id
        'education_id', // เพิ่ม education_id
        'telephone', // เก็บเบอร์โทรไว้ใน personal_information
        'queue_status',
        'queue_ref',
        'user_type'
    ];

    // ใช้กรณีการตั้งค่า $useTimestamps = true ถ้าต้องการจัดการเวลา
    protected $createdField = 'created_at'; // ระบุฟิลด์เวลาเมื่อสร้างข้อมูล
    protected $updatedField = 'updated_at'; // ระบุฟิลด์เวลาเมื่อมีการอัปเดตข้อมูล

    // ถ้าคุณต้องการให้ป้องกันจากการเก็บข้อมูลอื่นๆ ที่ไม่ได้ตั้งใน allowedFields
    protected $returnType = 'array'; // หรือ 'object' ขึ้นอยู่กับรูปแบบที่คุณต้องการ

    // ฟังก์ชันสำหรับดึงข้อมูลการแจ้งเตือน
    public function getAlerts()
    {
        // ตัวอย่างการดึงข้อมูลการแจ้งเตือนจากตาราง
        // ปรับตามความต้องการจริง เช่น ใช้เงื่อนไขเฉพาะ เช่น การแจ้งเตือนจากสถานะหรือประเภทผู้ใช้งาน
        return $this->where('queue_status', 'รอคิว') // สมมติว่า 'pending' คือสถานะที่ต้องการแจ้งเตือน
                    ->findAll();
    }
}