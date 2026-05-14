<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Email\Email;

class EmailController extends Controller
{
    public function send()
    {
        $email = \Config\Services::email();

        $email->setTo(env('EMAIL_TEST_TO', env('EMAIL_FROM', 'no-reply@example.com')));
        $email->setFrom(env('EMAIL_FROM', 'no-reply@example.com'), env('EMAIL_FROM_NAME', 'SmartJob System'));
        $email->setSubject('ทดสอบการส่ง Email ผ่าน Gmail SMTP');
        $email->setMessage('<h3>ทดสอบส่งอีเมลจาก CodeIgniter 4 ผ่าน Gmail SMTP สำเร็จ!</h3>');

        if ($email->send()) {
            return '✅ Email ส่งสำเร็จ!';
        } else {
            return '❌ ส่ง Email ไม่สำเร็จ: ' . $email->printDebugger(['headers']);
        }
    }
}
