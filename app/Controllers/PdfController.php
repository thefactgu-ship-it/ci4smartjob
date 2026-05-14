<?php

namespace App\Controllers;

use App\Models\PersonalInformationModel;
use App\Models\JobHistoryModel;
use App\Models\EmploymentInformationModel;
use \TCPDF;

class PdfController extends BaseController
{
    public function generateResume($id)
    {
        $personal = new PersonalInformationModel();
        $job = new JobHistoryModel();
        $employ = new EmploymentInformationModel();

        $data['user'] = $personal->find($id); // ดึงข้อมูลบุคคลจาก id
        $data['job'] = $job->where('personal_id', $id)->first();
        $data['employ'] = $employ->where('personal_id', $id)->first();

        $decodedDescription = json_decode($data['job']['description'], true);
        // ตรวจสอบว่าข้อมูลมีค่าหรือไม่
        if (!empty($decodedDescription)) {
            $formattedDescription = implode("\n", $decodedDescription); // รวมแต่ละบรรทัด
        } else {
            $formattedDescription = '-'; // แสดง "-" หากไม่มีข้อมูล
        }

        // ตรวจสอบว่ามีข้อมูลหรือไม่
        if (empty($data['user'])) {
            return redirect()->back()->with('error', 'ไม่พบข้อมูลผู้ใช้ที่ระบุ');
        }

        // สร้าง PDF
        $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('SmartJob Demo');
        $pdf->SetTitle('Resume');
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetAutoPageBreak(TRUE, 10);
        $pdf->AddPage();

        // เพิ่มฟอนต์จาก public/font
        define('THSARABUN_REGULAR', \TCPDF_FONTS::addTTFfont(FCPATH . 'font/THSarabunNew.ttf', 'TrueTypeUnicode'));
        define('THSARABUN_BOLD', \TCPDF_FONTS::addTTFfont(FCPATH . 'font/THSarabunNew-Bold.ttf', 'TrueTypeUnicode'));

        // ตั้งค่าฟอนต์
        $pdf->SetFont(THSARABUN_REGULAR, '', 20);

        // CSS สำหรับจัดสไตล์
        $css = '
            .header { background-color: #FFD700; color: #000; padding: 15px; text-align: center; }
            .header h1 { font-size: 20px; font-weight: bold; }
            .header h2 { font-size: 16px; margin-top: -10px; }
            .section-title { background-color: #FFD700; padding: 5px; font-weight: bold; }
            .content { font-size: 10px; line-height: 1.5; }
            .skills ul, .languages ul { list-style: none; padding: 0; }
            .skills li, .languages li { margin-bottom: 5px; }
            .table { width: 100%; }
            .left-col { width: 35%; padding-right: 10px; }
            .right-col { width: 65%; }
        ';

        // ดึง path รูปภาพโปรไฟล์จากฐานข้อมูล
        $profilePic = $data['user']['profile_pic'];
        $imagePath = FCPATH . 'uploads/' . $profilePic;

        // โลโก้ที่มุมขวาด้านบน

        // ตรวจสอบว่ามีรูปโปรไฟล์หรือไม่
        if (file_exists($imagePath) && !empty($profilePic)) {
            // ดึงข้อมูลส่วนขยายไฟล์
            $fileInfo = pathinfo($imagePath);
            $extension = strtolower($fileInfo['extension']); // แปลงส่วนขยายเป็นตัวพิมพ์เล็ก

            // ตรวจสอบประเภทไฟล์ที่รองรับ (JPG, PNG, GIF ฯลฯ)
            $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($extension, $validExtensions)) {
                $img = @imagecreatefrompng($imagePath);
                if ($img === false) {
                    // หากไฟล์ไม่ใช่รูปที่รองรับ ใช้ default
                    $pdf->Image(FCPATH . 'uploads/default-profile.png', 15, 30, 30, 30, 'JPG', '', '', true, 150, '', false, false, 0, false, false, true);
                } else {
                    $pdf->Image($imagePath, 15, 30, 30, 30, strtoupper($extension), '', '', true, 150, '', false, false, 0, false, false, true);
                }
            } else {
                // หากไฟล์ไม่ใช่รูปที่รองรับ ใช้ default
                $pdf->Image(FCPATH . 'uploads/default-profile.png', 15, 30, 30, 30, 'JPG', '', '', true, 150, '', false, false, 0, false, false, true);
            }
        } else {
            // หากไม่มีรูป ใช้ default
            $pdf->Image(FCPATH . 'uploads/default-profile.png', 15, 30, 30, 30, 'JPG', '', '', true, 150, '', false, false, 0, false, false, true);
        }

        // HTML รูปแบบ Resume
        $html = '
            <div class="header text-center">
                <h1>' . $data['user']['first_name'] . ' ' . $data['user']['last_name'] . '</h1>
                <h2>Resume</h2>
            </div>
            <div class="content">
                <table class="table" cellpadding="5">
                    <tr>
                        <td class="left-col">
                            <p><h1>ข้อมูลการติดต่อ</h1></p>
                            <p>' . $data['user']['address'] . ' <br>
                             ' . $data['user']['subdistrict'] . ' <br>
                             ' . $data['user']['district'] . ' <br>
                             ' . $data['user']['province'] . '<br>
                            เบอร์โทร: ' . $data['user']['telephone'] . '</p>
                            <p><h1>การศึกษา</h1></p>
                            <p>ระดับ ' . $data['user']['education_level'] . '<br>
                            จบจากสถาบัน ' . $data['user']['school'] . '</p>
                       </td>
                        <td class="right-col">
                            <p class="section-title">ตำแหน่งงานที่สนใจ</p>
                            <p>สนใจทำงานในตำแหน่ง ' . (!empty($data['job']['position']) ? $data['job']['position'] : '-') . ' และมีประสบการณ์ในตำแหน่งเป็นอย่างดี พร้อมจะนำประสบการณ์ในการทำงานมาพัฒนาปรับปรุงให้ดียิ่งขึ้น ทำงานเป็นทีมได้ดี มีความยืเหยุ่นในการทำงาน</p>

                            <p class="section-title">ประสบการณ์การทำงาน</p>
                            <p><strong>สถานที่ทำงานล่าสุด</strong></p>
                            <p>ชื่อบริษัท: ' . (!empty($data['employ']['company_name']) ? $data['employ']['company_name'] : '-') . '</p>
                            <p>ตำแหน่ง: ' . (!empty($data['employ']['job_position']) ? $data['employ']['job_position'] : '-') . '</p>
                            <p><strong>ประสบการณ์การทำงาน</strong></p>
                            <p>' . nl2br($formattedDescription) . '</p>
                        </td>
                    </tr>
                </table>
            </div>
        ';

        // รวม CSS และ HTML เข้าใน PDF
        $pdf->writeHTML("<style>{$css}</style>" . $html, true, false, true, false, '');

        // ส่งออก PDF
        // ตั้งค่า Header
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . $data['user']['first_name'] . '.pdf"');

        // ส่งออก PDF และเปิดในเบราว์เซอร์
        $pdf->Output('' . $data['user']['first_name'] . '.pdf', 'D');
    }
}
