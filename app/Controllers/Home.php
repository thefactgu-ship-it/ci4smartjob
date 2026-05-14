<?php

namespace App\Controllers;

use App\Models\PersonalInformationModel;
use App\Models\JobHistoryModel;
use App\Models\EmploymentInformationModel;
use App\Models\AddressModel;
use App\Models\EducationModel;

class Home extends BaseController
{
    public function index()
    {
        return view('login');
    }

    public function default()
    {
        return view('home/default');
    }

    public function empty_job()
    {
        $personalModel = new PersonalInformationModel();
        $addressModel = new AddressModel();
        $educationModel = new EducationModel();

        // ดึงข้อมูลเฉพาะ user_type ที่เป็น 'ขึ้นทะเบียนว่างงาน' และ queue_status เป็น 'รอคิว' หรือ 'กำลังดำเนินการ'
        $personalInformation = $personalModel->where('user_type', 'ขึ้นทะเบียนว่างงาน')
            ->whereIn('queue_status', ['รอคิว', 'กำลังดำเนินการ'])
            ->findAll();

        // ดึงข้อมูล addresses และ educations ที่เกี่ยวข้อง
        foreach ($personalInformation as &$info) {
            $info['address'] = $addressModel->find($info['address_id']);
            $info['education'] = $educationModel->find($info['education_id']);
        }

        $data['personalInformation'] = $personalInformation;

        // ดึงข้อมูลการแจ้งเตือน
        $data['alerts'] = $personalModel->getAlerts();

        // ส่งข้อมูลไปยัง view
        return view('home/emtyjob_list', $data);
    }

    public function report_list()
    {
        $personalModel = new PersonalInformationModel();
        $addressModel = new AddressModel();
        $educationModel = new EducationModel();

        // ดึงข้อมูลเฉพาะ user_type ที่เป็น 'ทั่วไป' และ queue_status เป็น 'รอคิว'
        $personalInformation = $personalModel->like('user_type', 'ขึ้นทะเบียนว่างงาน')
            ->where('queue_status', 'ดำเนินการสำเร็จ')
            ->findAll();

        // ดึงข้อมูล addresses และ educations ที่เกี่ยวข้อง
        foreach ($personalInformation as &$info) {
            $info['address'] = $addressModel->find($info['address_id']);
            $info['education'] = $educationModel->find($info['education_id']);
        }

        $data['personalInformation'] = $personalInformation;

        // ดึงข้อมูลการแจ้งเตือน
        $data['alerts'] = $personalModel->getAlerts();

        // ส่งข้อมูลไปยัง view
        return view('home/report_list', $data);
    }

    public function report_details($id)
    {
        $personalModel = new PersonalInformationModel();
        $jobModel = new JobHistoryModel();
        $employModel = new EmploymentInformationModel();
        $addressModel = new AddressModel();
        $educationModel = new EducationModel();

        $data['user'] = $personalModel->find($id); // ดึงข้อมูลบุคคลจาก id
        $data['job'] = $jobModel->where('personal_id', $id)->first();
        $data['employ'] = $employModel->where('personal_id', $id)->first();
        $data['user']['address'] = $addressModel->find($data['user']['address_id']);
        $data['user']['education'] = $educationModel->find($data['user']['education_id']);

        if (!$data['user']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("ไม่พบข้อมูลบุคคลที่มี ID: $id");
        }

        return view('home/report_details', $data); // ส่งข้อมูลไปยัง View
    }

    public function resume_job()
    {
        $personalModel = new PersonalInformationModel();
        $jobModel = new JobHistoryModel();
        $addressModel = new AddressModel();
        $educationModel = new EducationModel();

        $personalInformation = $personalModel->select('personal_information.personal_id, personal_information.*, job_history.id AS job_history_id, job_history.*')
            ->join('job_history', 'job_history.personal_id = personal_information.personal_id')
            ->like('personal_information.user_type', 'ฝากประวัติ')
            ->findAll();

        // ดึงข้อมูล addresses และ educations ที่เกี่ยวข้อง
        foreach ($personalInformation as &$info) {
            $info['address'] = $addressModel->find($info['address_id']);
            $info['education'] = $educationModel->find($info['education_id']);
        }

        $data['personalInformation'] = $personalInformation;

        // ดึงข้อมูลการแจ้งเตือน
        $data['alerts'] = $personalModel->getAlerts();

        // ส่งข้อมูลไปยัง view
        return view('home/resume_list', $data);
    }

    public function promote()
    {
        $personalModel = new PersonalInformationModel();
        $addressModel = new AddressModel();
        $educationModel = new EducationModel();
        $jobHistoryModel = new JobHistoryModel();

        // ดึงข้อมูลผู้ใช้ประเภท "ฝากประวัติ" ที่มีตำแหน่งงานที่ต้องการโปรโมท
        $personalInformation = $personalModel->select('personal_information.personal_id, personal_information.*')
            ->like('personal_information.user_type', 'ฝากประวัติ')
            ->join('job_history', 'job_history.personal_id = personal_information.personal_id')
            ->where('job_history.promote_occupation IS NOT NULL')
            ->where('job_history.promote_occupation !=', '')
            ->orderBy('personal_information.personal_id', 'DESC') // เพิ่มการเรียงลำดับข้อมูล (เรียงจากล่าสุด)
            ->get()
            ->getResultArray(); //ใช้ get() ร่วมกับ getResultArray()

        //ตรวจสอบว่ามีข้อมูลหรือไม่
        if (!empty($personalInformation)) {
            // ดึงข้อมูล job_history, addresses และ educations ที่เกี่ยวข้อง
            foreach ($personalInformation as &$info) {
                $info['jobHistory'] = $jobHistoryModel->where('personal_id', $info['personal_id'])->orderBy('id', 'DESC')->first();
                $info['address'] = $addressModel->find($info['address_id']);
                $info['education'] = $educationModel->find($info['education_id']);
            }
        }

        $data['personalInformation'] = $personalInformation;

        // ดึงข้อมูลการแจ้งเตือน
        $data['alerts'] = $personalModel->getAlerts();

        // ส่งข้อมูลไปยัง view
        return view('home/promote_list', $data);
    }


    // ฟังก์ชันสำหรับดึงข้อมูลแจ้งเตือนแบบ AJAX
    public function getAlertsAjax()
    {
        $model = new PersonalInformationModel();
        $alerts = $model->getAlerts();

        // ส่งข้อมูลแจ้งเตือนกลับในรูปแบบ JSON
        return $this->response->setJSON($alerts);
    }

    public function details($id)
    {
        $personalModel = new PersonalInformationModel();
        $jobModel = new JobHistoryModel();
        $employModel = new EmploymentInformationModel();
        $addressModel = new AddressModel(); // เพิ่ม AddressModel
        $educationModel = new EducationModel(); // เพิ่ม EducationModel

        // อัปเดตค่า queue_status เป็น "กำลังดำเนินการ"
        $personalModel->update($id, ['queue_status' => 'กำลังดำเนินการ']);

        $user = $personalModel->find($id); // ดึงข้อมูลบุคคลจาก id

        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("ไม่พบข้อมูลบุคคลที่มี ID: $id");
        }

        //ดึงข้อมูลที่อยู่
        $user['address'] = $addressModel->find($user['address_id']);

        //ดึงข้อมูลการศึกษา
        $user['education'] = $educationModel->find($user['education_id']);

        $data['user'] = $user;
        $data['job'] = $jobModel->where('personal_id', $id)->first();
        $data['employ'] = $employModel->where('personal_id', $id)->first();

        return view('home/person_details', $data); // ส่งข้อมูลไปยัง View
    }


    public function promote_details($id)
    {
        $personalModel = new PersonalInformationModel();
        $jobModel = new JobHistoryModel();
        $addressModel = new AddressModel(); // Added
        $educationModel = new EducationModel(); // Added

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

        return view('home/promote_details', $data);
    }

    public function resume_details($id)
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

        return view('home/resume_details', $data);
    }

    public function updateStatus($id)
    {
        $model = new PersonalInformationModel();

        // ดึงข้อมูลผู้ใช้ปัจจุบัน
        $user = $model->find($id);

        // เช็คว่ามีสถานะ 'ฝากประวัติ' หรือไม่ ถ้าไม่มีให้เพิ่มเข้าไป
        if (strpos($user['user_type'], 'ฝากประวัติ') === false) {
            $userType = $user['user_type'] . ',ฝากประวัติ';
        } else {
            $userType = $user['user_type'];
        }
        // อัปเดตสถานะ queue_status และ user_type
        $model->update($id, [
            'queue_status' => 'ดำเนินการสำเร็จ',
            'user_type' => $userType
        ]);

        // กลับไปหน้า Home
        return redirect()->to(base_url('home/emtyjob'))->with('success', 'ดำเนินการสำเร็จแล้ว');
    }


    public function delete($id)
    {
        $personalModel = new \App\Models\PersonalInformationModel();
        $employmentModel = new \App\Models\EmploymentInformationModel();
        $jobHistoryModel = new \App\Models\JobHistoryModel();
        $addressModel = new \App\Models\AddressModel();
        $educationModel = new \App\Models\EducationModel();

        // ดึงข้อมูล personal_information ก่อนทำการลบ
        $personalInfo = $personalModel->find($id);

        if (!$personalInfo) {
            return redirect()->to(previous_url())->with('error', 'ไม่พบข้อมูลที่ต้องการลบ');
        }

        // เริ่ม Transaction เพื่อให้ rollback ได้หากเกิดข้อผิดพลาด
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // ลบข้อมูลใน job_history ที่เกี่ยวข้องกับ personal_id
            $jobHistoryModel->where('personal_id', $id)->delete();

            // ลบข้อมูลใน employment_information ที่เกี่ยวข้องกับ personal_id
            $employmentModel->where('personal_id', $id)->delete();

            // ลบข้อมูลใน personal_information
            $personalModel->delete($id);

            // ลบ address
            if (isset($personalInfo['address_id'])) {
                $addressModel->delete($personalInfo['address_id']);
            }

            // ลบ education
            if (isset($personalInfo['education_id'])) {
                $educationModel->delete($personalInfo['education_id']);
            }

            // ตรวจสอบว่า transaction สำเร็จหรือไม่
            $db->transComplete();

            if ($db->transStatus() === false) {
                // หากล้มเหลว rollback transaction และแจ้งข้อผิดพลาด
                $db->transRollback();
                return redirect()->to(previous_url())->with('error', 'เกิดข้อผิดพลาดในการลบข้อมูล');
            }

            // หากสำเร็จ commit transaction และแจ้งสำเร็จ
            $db->transCommit();
            return redirect()->to(previous_url())->with('success', 'ลบข้อมูลสำเร็จ');
        } catch (\Exception $e) {
            // หากมี exception เกิดขึ้น rollback transaction และแจ้งข้อผิดพลาด
            $db->transRollback();
            log_message('error', 'เกิดข้อผิดพลาดในการลบข้อมูล: ' . $e->getMessage());
            return redirect()->to(previous_url())->with('error', 'เกิดข้อผิดพลาดในการลบข้อมูล');
        }
    }
}
