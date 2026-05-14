<?php

namespace App\Controllers;

use App\Models\EmployeeModel;
use CodeIgniter\Controller;

class EmployeeController extends Controller
{
    public function save()
    {
        $model = new EmployeeModel();
        $username = $this->request->getPost('username');

        // ตรวจสอบว่า username ซ้ำหรือไม่
        $existingUser = $model->where('username', $username)->first();

        if ($existingUser) {
            // ส่งข้อความแจ้งเตือนว่า username ซ้ำ
            session()->setFlashdata('alert', 'danger');
            session()->setFlashdata('msg', 'Username already exists. Please choose a different one.');
            return redirect()->to('/employeecontroller/create');
        }

        // รับไฟล์รูปภาพและตรวจสอบว่าไฟล์มีการอัปโหลดหรือไม่
        $profilePic = $this->request->getFile('em_pic');
        if ($profilePic->isValid() && !$profilePic->hasMoved()) {
            // สร้างชื่อไฟล์ใหม่
            $newName = $profilePic->getRandomName();

            // กำหนดโฟลเดอร์สำหรับจัดเก็บไฟล์ (public/uploads)
            $uploadPath = FCPATH . 'uploads';

            // ตรวจสอบว่าโฟลเดอร์ uploads มีอยู่หรือไม่ หากไม่มีให้สร้าง
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // ย้ายไฟล์ไปยังโฟลเดอร์ public/uploads
            $profilePic->move($uploadPath, $newName);
        }

        $data = [
            'username' => $username,
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'em_fullname' => $this->request->getPost('fullname'),
            'position' => $this->request->getPost('position'),
            'em_pic' => $newName
        ];

        $model->insert($data);
        session()->setFlashdata('alert', 'success');
        session()->setFlashdata('msg', 'Employee added successfully');
        return redirect()->to('/employeecontroller/create');
    }

    public function create()
    {
        return view('home/add_employee');
    }

    public function profile()
    {
        return view('home/updateProfile');
    }

    public function updateProfile()
    {
        $session = session();  // ดึง session เพื่อใช้งาน
        $em_id = $session->get('em_id');
        $model = new EmployeeModel();

        // จัดการรูปภาพ
        $img = $this->request->getFile('em_pic');
        if ($img->isValid() && !$img->hasMoved()) {
            $newName = $img->getRandomName();
            $img->move(WRITEPATH . '../public/uploads', $newName);

            // เพิ่มชื่อไฟล์รูปภาพในข้อมูล
            $data = [
                'em_fullname' => $this->request->getVar('em_fullname'),
                'position' => $this->request->getVar('position'),
                'em_pic' => $newName
            ];
        } else {
            // ไม่มีการอัพโหลดรูปภาพใหม่
            $data = [
                'em_fullname' => $this->request->getVar('em_fullname'),
                'position' => $this->request->getVar('position')
            ];
        }

        if ($model->update($em_id, $data)) {
            session()->setFlashdata('msg', 'บันทึกข้อมูลเรียบร้อยแล้ว');
            session()->setFlashdata('alert', 'success');
            // อัพเดท session
            $sessionData = [
                'username' => $model->find($em_id)['username'],
                'position' => $data['position'],
                'em_fullname' => $data['em_fullname']
            ];

            if (isset($data['em_pic'])) {
                $sessionData['em_pic'] = $data['em_pic'];
            }

            $session->set($sessionData);
        } else {
            session()->setFlashdata('msg', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล');
            session()->setFlashdata('alert', 'danger');
        }

        $session->set($sessionData);
        return redirect()->to('/employeecontroller/profile');
    }

    public function updatePassword()
    {
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        if ($newPassword === $confirmPassword) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $model = new EmployeeModel();
            $updateResult = $model->where('em_id', session()->get('em_id'))
                ->set(['password' => $hashedPassword])
                ->update();

            if ($updateResult) {
                session()->setFlashdata('msg', 'รหัสผ่านของคุณได้รับการอัปเดตเรียบร้อยแล้ว');
                session()->setFlashdata('alert', 'success');
            } else {
                session()->setFlashdata('msg', 'เกิดข้อผิดพลาดในการอัปเดตรหัสผ่าน');
                session()->setFlashdata('alert', 'danger');
            }
        } else {
            session()->setFlashdata('msg', 'รหัสผ่านไม่ตรงกัน กรุณาลองใหม่');
            session()->setFlashdata('alert', 'danger');
        }

        return redirect()->back();
    }

    public function employeeList()
    {
        $model = new EmployeeModel();
        $data['employees'] = $model->findAll();

        return view('home/employee_list', $data);
    }

    public function updateEmployee()
    {
        if ($this->request->isAJAX()) { // ตรวจสอบว่าเป็น AJAX Request หรือไม่
            $em_id = $this->request->getPost('em_id');
            $username = $this->request->getPost('username');
            $fullname = $this->request->getPost('em_fullname');
            $position = $this->request->getPost('position');

            if (empty($username) || empty($fullname) || empty($position)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'กรุณากรอกข้อมูลให้ครบถ้วน'
                ]);
            }

            $data = [
                'username' => $username,
                'em_fullname' => $fullname,
                'position' => $position
            ];

            $model = new EmployeeModel();
            $updateResult = $model->update($em_id, $data);

            if ($updateResult) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'ข้อมูลพนักงานได้รับการอัปเดตเรียบร้อยแล้ว'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'เกิดข้อผิดพลาดในการอัปเดตข้อมูลพนักงาน'
                ]);
            }
        }

        return redirect()->back();
    }

    public function deleteEmployee($em_id)
    {
        $model = new EmployeeModel();
        $deleteResult = $model->delete($em_id);

        if ($deleteResult) {
            session()->setFlashdata('msg', 'ลบพนักงานเรียบร้อยแล้ว');
            session()->setFlashdata('alert', 'success');
        } else {
            session()->setFlashdata('msg', 'เกิดข้อผิดพลาดในการลบพนักงาน');
            session()->setFlashdata('alert', 'danger');
        }

        return redirect()->back();
    }
}
