<?php

namespace App\Controllers;

use App\Models\EmployeeModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function login()
    {
        helper(['form']);
        echo view('login');
    }

    public function loginAuth()
    {
        $session = session();
        $model = new EmployeeModel();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $data = $model->where('username', $username)->first();

        if ($data) {
            $pass = $data['password'];
            $verify_pass = password_verify($password, $pass);
            if ($verify_pass) {
                $ses_data = [
                    'em_id' => $data['em_id'],
                    'username' => $data['username'],
                    'position' => $data['position'],
                    'em_fullname' => $data['em_fullname'],
                    'em_pic' => $data['em_pic'],
                    'logged_in' => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/home/default');
            } else {
                $session->setFlashdata('alert', 'danger');
                $session->setFlashdata('msg', 'Wrong Password');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('alert', 'danger');
            $session->setFlashdata('msg', 'Username not Found');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}
