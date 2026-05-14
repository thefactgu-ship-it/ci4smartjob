<?php

namespace App\Controllers;

use App\Models\PersonalInformationModel;
use App\Models\EmploymentInformationModel;
use App\Models\JobHistoryModel;
use App\Models\AddressModel;
use App\Models\EducationModel;

class User extends BaseController
{
    private $personalModel;
    private $employmentModel;
    private $jobHistoryModel;
    private $addressModel;
    private $educationModel;

    public function __construct()
    {
        $this->personalModel = new PersonalInformationModel();
        $this->employmentModel = new EmploymentInformationModel();
        $this->jobHistoryModel = new JobHistoryModel();
        $this->addressModel = new AddressModel();
        $this->educationModel = new EducationModel();
    }

    public function index()
    {
        return view('user/home', ['title' => 'home']);
    }

    public function form_test()
    {
        return view('user/form_test', ['title' => 'ขึ้นทะเบียนว่างงานเพื่อรับเงินชดเชย']);
    }

    public function form_history()
    {
        return view('user/form_history', ['title' => 'ฝากประวัติคนหางาน']);
    }

    public function form_part_time()
    {
        return view('user/form_part_time', ['title' => 'ประสงค์สมัครงานระหว่างการศึกษา']);
    }

    public function status($personalId = null)
    {
        $personal = ($personalId) ? $this->personalModel->find($personalId) : null;
        return view('user/status_view', ['personal' => $personal]);
    }

    public function getStatus($personalId)
    {
        $personalData = $this->personalModel->find($personalId);

        if ($personalData) {
            return $this->response->setJSON([
                'success' => true,
                'status' => $personalData['queue_status'],
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ไม่พบข้อมูล',
            ]);
        }
    }

    private function savePersonalData(array $data)
    {
        //กำหนด Address และ Education
        $addressData = [
            'address' => $data['address'],
            'province' => $data['province'],
            'district' => $data['district'],
            'subdistrict' => $data['subdistrict'],
        ];
        $addressId = $this->addressModel->insert($addressData);

        $educationData = [
            'education_level' => $data['education_level'],
            'school' => $data['school'],
        ];
        $educationId = $this->educationModel->insert($educationData);

        $personalData = [
            'title' => $data['title'],
            'first_name' => $data['firstName'],
            'last_name' => $data['lastName'],
            'gender' => $data['gender'],
            'national_id' => $data['nationnalid'],
            'back_id' => $data['backid'],
            'birth' => $data['birth'],
            'email' => $data['email'],
            'telephone' => $data['telephone'],
            'user_type' => $data['user_type'],
            'queue_status' => ($data['user_type'] === 'นักเรียนนักศึกษา' || strpos($data['user_type'], 'ฝากประวัติ') !== false) ? 'ดำเนินการสำเร็จ' : 'รอคิว',
            'queue_ref' => 'Q' . date('Ymd') . rand(1000, 9999),
            'address_id' => $addressId,
            'education_id' => $educationId
        ];

        //จัดการรูปภาพ
        $profilePic = $this->request->getFile('profile_pic');
        if ($profilePic->isValid() && !$profilePic->hasMoved()) {
            $newName = $profilePic->getRandomName();
            $uploadPath = FCPATH . 'uploads';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $profilePic->move($uploadPath, $newName);
            $personalData['profile_pic'] = $newName;
        }

        $personalId = $this->personalModel->insert($personalData);
        return $personalId;
    }

    private function saveEmploymentData(int $personalId, array $data)
    {
        $employmentData = [
            'personal_id' => $personalId,
            'job_status' => $data['job_status'],
            'termination_reason' => $data['termination_reason'],
            'company_name' => $data['company_name'],
            'company_type' => $data['company_type'],
            'date_out' => $data['date_out'],
            'job_position' => $data['job'],
            'company_address' => $data['company_address'],
            'company_province' => $data['province1'],
            'company_district' => $data['district1'],
            'company_subdistrict' => $data['subdistrict1'],
            'salary' => $data['salary'],
            'bank_name' => $data['bank'],
            'bank_no' => $data['bank_no'],
        ];

        //จัดการรูปภาพ
        $bank_pic = $this->request->getFile('bank_pic');
        if ($bank_pic->isValid() && !$bank_pic->hasMoved()) {
            $newName = $bank_pic->getRandomName();
            $uploadPath = FCPATH . 'uploads';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $bank_pic->move($uploadPath, $newName);
            $employmentData['bank_pic'] = $newName;
        }

        $this->employmentModel->insert($employmentData);
    }

    private function saveJobHistoryData(int $personalId, array $data)
    {
        $jobHistoryData = [
            'personal_id' => $personalId,
            'position' => $data['position'],
            'salary' => $data['salary'],
            'description' => isset($data['additional_textarea']) ? json_encode($data['additional_textarea']) : '', // ตรวจสอบว่ามีค่าหรือไม่
            'promote_occupation' => $data['occupationInput'] ?? '', // ตรวจสอบว่ามีค่าหรือไม่
            'consent' => $data['consentCheckbox'] ? 1 : 0,
        ];
        $this->jobHistoryModel->insert($jobHistoryData);
    }


    public function save()
    {
        $data = $this->request->getPost();
        $personalId = $this->savePersonalData($data);

        // หากไม่ใช่การฝากประวัติ หรือ สมัครงานระหว่างการศึกษา จะต้องมีการกรอกข้อมูลการทำงานก่อนหน้า
        if (strpos($data['user_type'], 'ฝากประวัติ') === false && $data['user_type'] !== 'นักเรียนนักศึกษา') {
            $this->saveEmploymentData($personalId, $data);
        }

        //ต้องกรอกข้อมูลประวัติการทำงานทุกกรณี
        $this->saveJobHistoryData($personalId, $data);

        session()->setFlashdata('message', 'ข้อมูลบันทึกสำเร็จ');
        return redirect()->to("user/status/{$personalId}")->with('message', 'ข้อมูลบันทึกสำเร็จ');
    }

    public function save_history()
    {
        // เหมือน save ทุกอย่างแค่ไม่มี employmentdata
        $data = $this->request->getPost();
        $personalId = $this->savePersonalData($data);
        $this->saveJobHistoryData($personalId, $data);

        session()->setFlashdata('message', 'ข้อมูลบันทึกสำเร็จ');
        return redirect()->to("user/status/{$personalId}")->with('message', 'ข้อมูลบันทึกสำเร็จ');
    }

    public function save_student()
    {
        // เหมือน save_history ทุกอย่าง 
        $data = $this->request->getPost();
        $personalId = $this->savePersonalData($data);
        $this->saveJobHistoryData($personalId, $data);

        session()->setFlashdata('message', 'ข้อมูลบันทึกสำเร็จ');
        return redirect()->to("user/status/{$personalId}")->with('message', 'ข้อมูลบันทึกสำเร็จ');
    }

    public function search()
    {
        $queueRef = $this->request->getGet('queue_ref');

        if (!empty($queueRef)) {
            $personal = $this->personalModel->where('queue_ref', $queueRef)->first();

            return view('status', [
                'personal' => $personal,
                'message' => $personal ? 'ค้นหาข้อมูลสำเร็จ' : 'ไม่พบข้อมูลที่ตรงกับรหัสคิวนี้'
            ]);
        } else {
            return view('status', [
                'message' => 'กรุณากรอกรหัสคิวในการค้นหา'
            ]);
        }
    }
}
