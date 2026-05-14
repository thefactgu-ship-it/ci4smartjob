<?php

namespace App\Controllers;

use App\Models\PersonalInformationModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $personalInformationModel = new PersonalInformationModel();

        // ดึงข้อมูลจำนวนผู้ใช้ทั้งหมด
        $totalUsers = $personalInformationModel->countAllResults();

        // ดึงข้อมูลจำนวนผู้ใช้ที่เป็นบุคคลทั่วไป
        $generalUsers = $personalInformationModel->like('user_type', 'ขึ้นทะเบียนว่างงาน')->countAllResults();

        // ดึงข้อมูลจำนวนผู้ใช้ที่เป็นนักเรียนนักศึกษา
        $studentUsers = $personalInformationModel->where('user_type', 'นักเรียนนักศึกษา')->countAllResults();

        // ดึงข้อมูลจำนวนผู้ใช้ที่เป็นชายและหญิง
        $maleUsers = $personalInformationModel->where('gender', 'ชาย')->countAllResults();
        $femaleUsers = $personalInformationModel->where('gender', 'หญิง')->countAllResults();

        // ดึงข้อมูลจำนวนผู้ใช้แต่ละประเภทในแต่ละเดือน
        // ใช้ DATE_FORMAT(created_at, '%Y-%m') แทน MONTH(created_at)
        $monthlyUsersQuery = $personalInformationModel->select("DATE_FORMAT(created_at, '%Y-%m') as `year_month`, 
            SUM(CASE WHEN user_type LIKE '%ขึ้นทะเบียนว่างงาน%' THEN 1 ELSE 0 END) as general_users,
            SUM(CASE WHEN user_type LIKE '%ฝากประวัติ%' THEN 1 ELSE 0 END) as resume_users,
            SUM(CASE WHEN user_type LIKE '%นักเรียนนักศึกษา%' THEN 1 ELSE 0 END) as student_users")
            ->groupBy("`year_month`") // ใส่ backticks ครอบ year_month
            ->orderBy("`year_month`")// เพิ่มการเรียงลำดับ
            ->get()->getResultArray();

        $yearMonths = []; // เปลี่ยนจาก months เป็น yearMonths
        $generalUserCounts = [];
        $resumeUserCounts = [];
        $studentUserCounts = [];

        foreach ($monthlyUsersQuery as $row) {
            $yearMonths[] = $row['year_month']; // เปลี่ยนจาก month เป็น year_month
            $generalUserCounts[] = $row['general_users'];
            $resumeUserCounts[] = $row['resume_users'];
            $studentUserCounts[] = $row['student_users'];
        }

        // ดึงข้อมูลจำนวนผู้ใช้ที่ต้องการส่งเสริมการประกอบอาชีพ
        $pendingRequests = $personalInformationModel->join('job_history', 'job_history.personal_id = personal_information.personal_id')
            ->where('job_history.promote_occupation IS NOT NULL')
            ->where('job_history.promote_occupation !=', 'ไม่ต้องการ')
            ->where('job_history.promote_occupation !=', '')
            ->countAllResults();

        // ดึงข้อมูลจำนวนผู้ใช้ที่มีข้อมูล promote_occupation ในแต่ละเดือน
        // ใช้ DATE_FORMAT(created_at, '%Y-%m') แทน MONTH(created_at)
        $promoteOccupationUsersQuery = $personalInformationModel->join('job_history', 'job_history.personal_id = personal_information.personal_id')
            ->select("DATE_FORMAT(personal_information.created_at, '%Y-%m') as `year_month`, COUNT(*) as user_count") // เปลี่ยนจาก month เป็น year_month
            ->where('job_history.promote_occupation IS NOT NULL')
            ->where('job_history.promote_occupation !=', 'ไม่ต้องการ')
            ->where('job_history.promote_occupation !=', '')
            ->groupBy("`year_month`") // ใส่ backticks ครอบ year_month
            ->orderBy("`year_month`")// เพิ่มการเรียงลำดับ
            ->get()->getResultArray();

        $promoteOccupationCounts = [];
        $promoteOccupationYearMonths = []; // สร้าง array ใหม่
        foreach ($promoteOccupationUsersQuery as $row) {
            $promoteOccupationYearMonths[] = $row['year_month']; // เก็บ year_month
            $promoteOccupationCounts[] = $row['user_count'];
        }

        $data = [
            'totalUsers' => $totalUsers,
            'generalUsers' => $generalUsers,
            'studentUsers' => $studentUsers,
            'maleUsers' => $maleUsers,
            'femaleUsers' => $femaleUsers,
            'yearMonths' => $yearMonths, // เปลี่ยนจาก months เป็น yearMonths
            'generalUserCounts' => $generalUserCounts,
            'resumeUserCounts' => $resumeUserCounts,
            'studentUserCounts' => $studentUserCounts,
            'promoteOccupationCounts' => $promoteOccupationCounts,
            'promoteOccupationYearMonths' => $promoteOccupationYearMonths,// เพิ่ม array ใหม่
            'pendingRequests' => $pendingRequests
        ];

        return view('home/dashboard', $data);
    }
}
