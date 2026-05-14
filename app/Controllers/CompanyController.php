<?php

namespace App\Controllers;

use App\Models\PersonalInformationModel;
use App\Models\CompanyModel;
use App\Models\CompanySelectModel;
use App\Models\JobHistoryModel;
use App\Models\AddressModel;
use App\Models\EducationModel;
use CodeIgniter\Email\Email;
use Config\Services;

class CompanyController extends BaseController
{
    public function index()
    {
        return view('home/chk_company');
    }

    public function coppy_list()
    {
        $model = new PersonalInformationModel();
        $jobHistoryModel = new JobHistoryModel();
        $addressModel = new AddressModel();
        $educationModel = new EducationModel();

        $personalInformation = $model->like('user_type', 'ฝากประวัติ')->findAll();

        $formattedPersonalInformation = [];
        foreach ($personalInformation as $info) {
            $jobHistory = $jobHistoryModel->where('personal_id', $info['personal_id'])->first();
            $address = $addressModel->find($info['address_id']);
            $education = $educationModel->find($info['education_id']);

            $formattedPersonalInformation[] = [
                'personal_id' => $info['personal_id'],
                'first_name' => $info['first_name'],
                'last_name' => $info['last_name'],
                'gender' => $info['gender'],
                'user_type' => $info['user_type'],
                'job_history_id' => $jobHistory ? $jobHistory['id'] : null,
                'position' => $jobHistory ? $jobHistory['position'] : null,
                'address' => $address,
                'education' => $education,
                // Add other relevant fields from $info, $jobHistory if needed.
            ];
        }
        $data['personalInformation'] = $formattedPersonalInformation;
        $data['alerts'] = $model->getAlerts();

        $company_id = session()->get('company_id');
        if ($company_id) {
            $companyModel = new CompanyModel();
            $data['employerData'] = $companyModel->find($company_id);
        } else {
            $data['employerData'] = null;
        }

        return view('home/company_list', $data);
    }

    public function addCompany()
    {
        return view('home/add_company');
    }

    public function chk_company()
    {
        $model = new CompanyModel();
        $company_number = $this->request->getPost('company_number');
        $data['company'] = $model->where('company_number', $company_number)->first();

        if ($data['company'] === null) {
            session()->setFlashdata('alert', 'danger');
            session()->setFlashdata('msg', 'ไม่พบข้อมูลนายจ้าง/สถานประกอบการ');
            return redirect()->to('/company/addCompany');
        } else {
            session()->set('company_id', $data['company']['company_id']);
            return redirect()->to('/company/coppy_list');
        }
    }

    public function saveAdd_company()
    {
        $validation = Services::validation();
        $validation->setRules([
            'company_name' => 'required',
            'company_number' => 'required|numeric',
            'company_nationid' => 'required',
            'company_emfullname' => 'required',
            'company_add' => 'required',
            'company_telephone' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $model = new CompanyModel();
        $data = [
            'company_name' => $this->request->getPost('company_name'),
            'company_number' => $this->request->getPost('company_number'),
            'company_nationid' => $this->request->getPost('company_nationid'),
            'company_emfullname' => $this->request->getPost('company_emfullname'),
            'company_add' => $this->request->getPost('company_add'),
            'company_telephone' => $this->request->getPost('company_telephone')
        ];

        try {
            $model->insert($data);
            session()->setFlashdata('alert', 'success');
            session()->setFlashdata('msg', 'เพิ่มข้อมูลสถานประกอบการสำเร็จ');
        } catch (\Exception $e) {
            log_message('error', 'เกิดข้อผิดพลาดในการเพิ่มข้อมูลบริษัท: ' . $e->getMessage());
            session()->setFlashdata('alert', 'danger');
            session()->setFlashdata('msg', 'เกิดข้อผิดพลาดในการเพิ่มข้อมูลสถานประกอบการ');
        }

        return redirect()->to('/company/addCompany');
    }

    public function bulkAction()
    {
        $selectedIds = $this->request->getPost('selectedIds');

        if (!is_array($selectedIds)) {
            $selectedIds = explode(',', $selectedIds);
        }
        session()->setFlashdata('selectedIds', $selectedIds);

        return redirect()->to('company/summary');
    }

    public function summary()
    {
        $company_id = session()->get('company_id');
        if (!$company_id) {
            return redirect()->to('/company/chk_company');
        }

        $companyModel = new CompanyModel();
        $personalModel = new PersonalInformationModel();
        $jobHistoryModel = new JobHistoryModel(); // โหลด JobHistoryModel

        $selectedIds = session()->getFlashdata('selectedIds');
        // $selectedIds = $this->request->getGet('ids'); // ลบออกเพราะไม่ได้ใช้ get
        $selectedIdsArray = !empty($selectedIds) ? $selectedIds : [];

        if (empty($selectedIdsArray)) {
            return redirect()->to('/company/coppy_list')->with('error', 'ไม่พบผู้สมัครที่เลือก');
        }

        $data['selectedApplicants'] = $personalModel->whereIn('personal_id', $selectedIdsArray)->findAll();
        $data['companyInfo'] = $companyModel->find($company_id);
        $data['selectedIds'] = $selectedIds;

        // ดึงข้อมูลประวัติการทำงาน
        foreach ($data['selectedApplicants'] as &$applicant) {
            $applicant['jobHistory'] = $jobHistoryModel->where('personal_id', $applicant['personal_id'])->findAll();
        }

        return view('home/summary', $data);
    }

    public function saveSelection()
    {
        $company_id = session()->get('company_id');
        if (!$company_id) {
            return redirect()->to('/company/chk_company');
        }

        $selectedIds = $this->request->getPost('selectedIds');

        if (empty($selectedIds)) {
            return redirect()->to('company/coppy_list')->with('error', 'กรุณาเลือกผู้สมัครงานก่อนบันทึก');
        }

        if (!is_array($selectedIds)) {
            $selectedIds = explode(',', $selectedIds);
        }

        $model = new CompanySelectModel();
        $personalModel = new PersonalInformationModel();
        $companyModel = new CompanyModel();

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $model->where('company_id', $company_id)->delete();

            $dataBatch = [];
            foreach ($selectedIds as $personal_id) {
                $dataBatch[] = [
                    'company_id' => $company_id,
                    'personal_id' => $personal_id
                ];
            }

            if (!empty($dataBatch)) {
                $model->insertBatch($dataBatch);
            }

            $db->transComplete();
            $company = $companyModel->find($company_id);
            foreach ($selectedIds as $personal_id) {
                $jobSeeker = $personalModel->where('personal_id', $personal_id)->first();
                if ($jobSeeker && !empty($jobSeeker['email'])) {
                    $this->sendEmailNotification($jobSeeker['email'], $jobSeeker['first_name'], $company['company_name']);
                }
            }

            return redirect()->to('company/coppy_list')->with('success', 'บันทึกข้อมูลเรียบร้อย'); // Redirect to the list page
        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'เกิดข้อผิดพลาดในการบันทึกข้อมูลการเลือก: ' . $e->getMessage());
            return redirect()->to('company/coppy_list')->with('error', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล'); // Redirect to the list page
        }
    }
    private function sendEmailNotification($toEmail, $firstName, $companyName)
    {
        $email = \Config\Services::email();

        $email->setFrom(env('EMAIL_FROM', 'no-reply@example.com'), env('EMAIL_FROM_NAME', 'SmartJob System'));
        $email->setTo($toEmail);

        $subject = 'แจ้งเตือน: คุณถูกเลือกโดยนายจ้าง!';
        $message = "
            <h2>เรียนคุณ $firstName,</h2>
            <p>ขณะนี้ <strong>$companyName</strong> ได้ทำการเลือกคุณเข้าสู่กระบวนการพิจารณา.</p>
            <p>กรุณาตรวจสอบสถานะของคุณผ่านระบบ SmartJob.</p>
            <br>
            <p>ขอบคุณที่ใช้บริการ SmartJob</p>
        ";

        $email->setSubject($subject);
        $email->setMessage($message);

        if (!$email->send()) {
            log_message('error', 'ไม่สามารถส่งอีเมลได้: ' . $email->printDebugger(['headers', 'body']));
        }
    }
}
