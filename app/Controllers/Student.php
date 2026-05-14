<?php

namespace App\Controllers;

use App\Models\PersonalInformationModel;
use App\Models\JobHistoryModel;
use App\Models\EmploymentInformationModel;
use App\Models\AddressModel;
use App\Models\EducationModel;

class Student extends BaseController
{
    public function index()
    {
        $model = new PersonalInformationModel();

        // ดึงข้อมูลเฉพาะ user_type ที่เป็น 'นักเรียนนักศึกษา' และ join กับตาราง job_history
        $data['personalInformation'] = $model->select('personal_information.personal_id, personal_information.*, job_history.*')
            ->join('job_history', 'job_history.personal_id = personal_information.personal_id', 'left')
            ->where('personal_information.user_type', 'นักเรียนนักศึกษา')
            ->findAll();

        // ดึงข้อมูลการแจ้งเตือน
        $data['alerts'] = $model->getAlerts();

        // ส่งข้อมูลไปยัง view
        return view('home/student_list', $data);
    }

    // ฟังก์ชันสำหรับดึงข้อมูลแจ้งเตือนแบบ AJAX
    public function getAlertsAjax()
    {
        $model = new PersonalInformationModel();
        $alerts = $model->getAlerts();

        // ส่งข้อมูลแจ้งเตือนกลับในรูปแบบ JSON
        return $this->response->setJSON($alerts);
    }


    public function student_details($id)
    {
        $personalModel = new PersonalInformationModel();
        $jobModel = new JobHistoryModel();
        $addressModel = new AddressModel();
        $educationModel = new EducationModel();

        $user = $personalModel->find($id);

        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("ไม่พบข้อมูลบุคคลที่มี ID: $id");
        }

        // Fetch related data using the new structure
        $user['address'] = $addressModel->find($user['address_id']);
        $user['education'] = $educationModel->find($user['education_id']);
        $job = $jobModel->where('personal_id', $id)->first();

        $data['user'] = $user;
        $data['job'] = $job;

        return view('home/student_details', $data);
    }

    public function updateStatus($id)
    {
        $model = new PersonalInformationModel();

        // อัปเดตสถานะ queue_status
        $model->update($id, ['queue_status' => 'ดำเนินการสำเร็จ']);

        // กลับไปหน้า Home
        return redirect()->to(base_url('home/emtyjob'))->with('success', 'ดำเนินการสำเร็จแล้ว');
    }

    public function delete($id)
    {
        $personalModel = new \App\Models\PersonalInformationModel();
        $employmentModel = new \App\Models\EmploymentInformationModel();
        $jobHistoryModel = new \App\Models\JobHistoryModel(); // โหลด Model ของตาราง job_history

        // ลบข้อมูลใน job_history ที่เกี่ยวข้องกับ personal_id
        $jobHistoryModel->where('personal_id', $id)->delete();

        // ลบข้อมูลใน employment_information ที่เกี่ยวข้องกับ personal_id
        $employmentModel->where('personal_id', $id)->delete();

        // ลบข้อมูลใน personal_information
        if ($personalModel->delete($id)) {
            return redirect()->to('home')->with('success', 'ลบข้อมูลสำเร็จ');
        } else {
            return redirect()->to('home')->with('error', 'ไม่สามารถลบข้อมูลได้');
        }
    }
}
