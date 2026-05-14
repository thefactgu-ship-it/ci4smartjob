<?php

namespace App\Controllers;

use App\Models\AddressModel;
use App\Models\EducationModel;
use App\Models\EmploymentInformationModel;
use App\Models\JobHistoryModel;
use App\Models\PersonalInformationModel;
use TCPDF;

class PdfController extends BaseController
{
    public function generateResume($id)
    {
        $personalModel = new PersonalInformationModel();
        $jobModel = new JobHistoryModel();
        $employmentModel = new EmploymentInformationModel();
        $addressModel = new AddressModel();
        $educationModel = new EducationModel();

        $user = $personalModel->find($id);

        if (empty($user)) {
            return redirect()->back()->with('error', 'ไม่พบข้อมูลผู้ใช้ที่ระบุ');
        }

        $job = $jobModel->where('personal_id', $id)->first() ?? [];
        $employment = $employmentModel->where('personal_id', $id)->first() ?? [];
        $address = !empty($user['address_id']) ? ($addressModel->find($user['address_id']) ?? []) : [];
        $education = !empty($user['education_id']) ? ($educationModel->find($user['education_id']) ?? []) : [];

        $description = $job['description'] ?? '';
        $decodedDescription = json_decode($description, true);
        $formattedDescription = !empty($decodedDescription)
            ? implode("\n", $decodedDescription)
            : ($description ?: '-');

        $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('SmartJob Demo');
        $pdf->SetTitle('Resume');
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetAutoPageBreak(true, 10);
        $pdf->AddPage();

        if (! defined('THSARABUN_REGULAR')) {
            define('THSARABUN_REGULAR', \TCPDF_FONTS::addTTFfont(FCPATH . 'font/THSarabunNew.ttf', 'TrueTypeUnicode'));
        }

        if (! defined('THSARABUN_BOLD')) {
            define('THSARABUN_BOLD', \TCPDF_FONTS::addTTFfont(FCPATH . 'font/THSarabunNew-Bold.ttf', 'TrueTypeUnicode'));
        }

        $pdf->SetFont(THSARABUN_REGULAR, '', 20);

        $profilePic = $user['profile_pic'] ?? '';
        $imagePath = FCPATH . 'uploads/' . $profilePic;
        $defaultImagePath = FCPATH . 'uploads/default-profile.png';

        if (!empty($profilePic) && is_file($imagePath)) {
            $extension = strtoupper(pathinfo($imagePath, PATHINFO_EXTENSION));
            $pdf->Image($imagePath, 15, 30, 30, 30, $extension, '', '', true, 150, '', false, false, 0, false, false, true);
        } elseif (is_file($defaultImagePath)) {
            $pdf->Image($defaultImagePath, 15, 30, 30, 30, 'PNG', '', '', true, 150, '', false, false, 0, false, false, true);
        }

        $fullName = trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''));
        $safeFullName = esc($fullName ?: 'Applicant');
        $addressText = esc($address['address'] ?? '-');
        $subdistrict = esc($address['subdistrict'] ?? '-');
        $district = esc($address['district'] ?? '-');
        $province = esc($address['province'] ?? '-');
        $telephone = esc($user['telephone'] ?? '-');
        $educationLevel = esc($education['education_level'] ?? '-');
        $school = esc($education['school'] ?? '-');
        $position = esc($job['position'] ?? '-');
        $companyName = esc($employment['company_name'] ?? '-');
        $jobPosition = esc($employment['job_position'] ?? '-');
        $workDescription = nl2br(esc($formattedDescription));

        $css = '
            .header { background-color: #FFD700; color: #000; padding: 15px; text-align: center; }
            .header h1 { font-size: 20px; font-weight: bold; }
            .header h2 { font-size: 16px; margin-top: -10px; }
            .section-title { background-color: #FFD700; padding: 5px; font-weight: bold; }
            .content { font-size: 10px; line-height: 1.5; }
            .table { width: 100%; }
            .left-col { width: 35%; padding-right: 10px; }
            .right-col { width: 65%; }
        ';

        $html = '
            <div class="header text-center">
                <h1>' . $safeFullName . '</h1>
                <h2>Resume</h2>
            </div>
            <div class="content">
                <table class="table" cellpadding="5">
                    <tr>
                        <td class="left-col">
                            <p><h1>ข้อมูลการติดต่อ</h1></p>
                            <p>' . $addressText . '<br>
                            ' . $subdistrict . '<br>
                            ' . $district . '<br>
                            ' . $province . '<br>
                            เบอร์โทร: ' . $telephone . '</p>
                            <p><h1>การศึกษา</h1></p>
                            <p>ระดับ ' . $educationLevel . '<br>
                            จบจากสถาบัน ' . $school . '</p>
                        </td>
                        <td class="right-col">
                            <p class="section-title">ตำแหน่งงานที่สนใจ</p>
                            <p>สนใจทำงานในตำแหน่ง ' . $position . '</p>
                            <p class="section-title">ประสบการณ์การทำงาน</p>
                            <p><strong>สถานที่ทำงานล่าสุด</strong></p>
                            <p>ชื่อบริษัท: ' . $companyName . '</p>
                            <p>ตำแหน่ง: ' . $jobPosition . '</p>
                            <p><strong>รายละเอียดประสบการณ์</strong></p>
                            <p>' . $workDescription . '</p>
                        </td>
                    </tr>
                </table>
            </div>
        ';

        $pdf->writeHTML("<style>{$css}</style>" . $html, true, false, true, false, '');
        $pdf->Output(($user['first_name'] ?? 'resume') . '.pdf', 'D');
    }
}
