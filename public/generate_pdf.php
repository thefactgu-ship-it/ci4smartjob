<?php

session_start();
require('..//fpdf/fpdf.php'); // Include FPDF library
include("../connect.php"); // Database connection

if (isset($_GET['alien_id'])) {
    $alien_id = $_GET['alien_id'];

    // Fetch alien data
    $query = "SELECT * FROM number31 INNER JOIN employer ON number31.employer_id = employer.employer_id inner join employ on number31.finance_id = employ.em_id inner join alien on number31.alien_id = alien.alien_id WHERE number31.alien_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $alien_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
// Define a list of prefixes
        $prefixes = array("MR.", "MISS", "MRS.", "MR", "MRS");

        // Get the alien's name
        $alien_name = $data['alien_name'];
        $original_name = $alien_name; // Save the original name for later use

        // Remove any repeated prefixes from the name
        foreach ($prefixes as $prefix) {
            // Check if the name starts with a prefix
            if (stripos($alien_name, $prefix) === 0) {
                // Remove the prefix from the name
                $alien_name = preg_replace('/^' . preg_quote($prefix, '/') . '\s*/i', '', $alien_name);
                break;  // Stop after removing the first match
            }
        }

        // Remove any subsequent matching prefix if the name still starts with the same prefix
        foreach ($prefixes as $prefix) {
            // Check if the name starts with a prefix again after removing the first one
            if (stripos($alien_name, $prefix) === 0) {
                // Remove the second occurrence of the prefix
                $alien_name = preg_replace('/^' . preg_quote($prefix, '/') . '\s*/i', '', $alien_name);
                break;  // Stop after removing the second occurrence
            }
        }

      // สร้าง PDF ขนาดหน้ากระดาษที่กำหนด
$pdf = new FPDF('P', 'mm', array(164, 204)); // กำหนดขนาดเป็น กว้าง 16.4 ซม. และ ยาว 20.4 ซม.

// ปิดระยะขอบและการแบ่งหน้าของ FPDF
$pdf->SetMargins(0, 0, 0); // กำหนดระยะขอบซ้าย บน ขวา เป็น 0
$pdf->SetAutoPageBreak(false); // ปิดการแบ่งหน้าของ FPDF

// เพิ่มหน้า
$pdf->AddPage();

// เพิ่มฟอนต์
$pdf->AddFont('sarabun', 'B', 'THSarabunB.php');
$pdf->AddFont('sarabun', '', 'THSarabun.php');
        // Set font
        $pdf->SetFont('sarabun', 'B', 14);  // กำหนดขนาดฟอนต์เป็น 16

        // Set position: X = 10.3 cm, Y = 2.5 cm
        $pdf->SetXY(10.1 * 10, 2.4 * 10);  // หน่วยเป็นเซ็นติเมตร
        $pdf->Cell(0, 5, iconv('utf-8', 'cp874', 'สำนักงานจัดหางานจังหวัดกระบี่'), 0, 1, 'L');

        // Get current date in Thai format (e.g., 25 ธันวาคม 2567)
        setlocale(LC_TIME, 'th_TH.UTF-8');  // Set the locale to Thai
        $current_date = strftime('%d          %B          %Y');  // Get the current date in the format of '25 ธันวาคม 2567'

        // Manually replace the month name with the Thai name if necessary
        $month_th = array(
            'January' => 'มกราคม',
            'February' => 'กุมภาพันธ์',
            'March' => 'มีนาคม',
            'April' => 'เมษายน',
            'May' => 'พฤษภาคม',
            'June' => 'มิถุนายน',
            'July' => 'กรกฎาคม',
            'August' => 'สิงหาคม',
            'September' => 'กันยายน',
            'October' => 'ตุลาคม',
            'November' => 'พฤศจิกายน',
            'December' => 'ธันวาคม'
        );

        // Replace English month with Thai month
        $current_date = str_replace(array_keys($month_th), array_values($month_th), $current_date);

        // Convert the year from AD (Anno Domini) to BE (Buddhist Era)
        $current_year = date("Y");  // Get current year in AD (Gregorian)
        $current_year_BE = $current_year + 543;  // Convert AD to BE by adding 543

        // Replace the year in the date with the Buddhist Era year
        $current_date = preg_replace('/\d{4}$/', $current_year_BE, $current_date);

        // Set position for date
        $pdf->SetXY(9.7 * 10, 3.2 * 10);  // หน่วยเป็นเซ็นติเมตร
        $pdf->Cell(0, 5, iconv('utf-8', 'cp874', $current_date), 0, 1, 'L');

        $pdf->SetXY(4.8 * 10, 4 * 10);  // หน่วยเป็นเซ็นติเมตร
        $pdf->Cell(0, 5, iconv('utf-8', 'cp874', $data['number33_run']), 0, 1, 'L');


// Display the alien name (now without repeated prefixes)
        $pdf->SetXY(4 * 10, 4.8 * 10);  // Set position
        $pdf->Cell(0, 5, iconv('utf-8', 'cp874', $original_name), 0, 1, 'L');
        $pdf->SetXY(3.4 * 10, 5.5 * 10);  // หน่วยเป็นเซ็นติเมตร
        $pdf->Cell(0, 5, iconv('utf-8', 'cp874', $data['nationality']), 0, 1, 'L');
        $pdf->SetXY(9.9 * 10, 5.5 * 10);  // หน่วยเป็นเซ็นติเมตร
        $pdf->Cell(0, 5, iconv('utf-8', 'cp874', $data['alien_id']), 0, 1, 'L');
        $pdf->SetXY(6.3 * 10, 6.2 * 10);  // หน่วยเป็นเซ็นติเมตร
        $pdf->Cell(0, 5, iconv('utf-8', 'cp874', $data['employer']), 0, 1, 'L');

        // Set position: X = 10.3 cm, Y = 2.5 cm
        $pdf->SetXY(2.5 * 10, 8.9 * 10);  // หน่วยเป็นเซ็นติเมตร
        $pdf->Cell(0, 5, iconv('utf-8', 'cp874', '/'), 0, 1, 'L');
        $pdf->SetXY(13.2 * 10, 8.9 * 10);  // หน่วยเป็นเซ็นติเมตร
        $pdf->Cell(0, 5, iconv('utf-8', 'cp874', '100.00'), 0, 1, 'L');

        // Set position: X = 10.3 cm, Y = 2.5 cm
        $pdf->SetXY(2.5 * 10, 15 * 10);  // หน่วยเป็นเซ็นติเมตร
        $pdf->Cell(0, 5, iconv('utf-8', 'cp874', '/'), 0, 1, 'L');
        $pdf->SetXY(3.4 * 10, 15 * 10);  // หน่วยเป็นเซ็นติเมตร
        $pdf->Cell(0, 5, iconv('utf-8', 'cp874', 'ขอรับใบอนุญาตทำงานได้ไม่เกิน 2 ปี'), 0, 1, 'L');
        $pdf->SetXY(12.7 * 10, 15 * 10);  // หน่วยเป็นเซ็นติเมตร
        $pdf->Cell(0, 5, iconv('utf-8', 'cp874', '1,800.00'), 0, 1, 'L');

        $pdf->SetXY(4.9 * 10, 16.7 * 10);  // หน่วยเป็นเซ็นติเมตร
        $pdf->Cell(0, 5, iconv('utf-8', 'cp874', 'หนึ่งพันเก้าร้อยบาทถ้วน'), 0, 1, 'L');
        $pdf->SetXY(12.7 * 10, 16.7 * 10);  // หน่วยเป็นเซ็นติเมตร
        $pdf->Cell(0, 5, iconv('utf-8', 'cp874', '1,900.00'), 0, 1, 'L');

        $pdf->SetXY(8.7 * 10, 19.1 * 10);  // Set position: X = 8.9 cm, Y = 17.7 cm
        $pdf->Cell(0, 5, iconv('utf-8', 'cp874', '( ' . $data['em_name'] . ' )'), 0, 1, 'L');
        $pdf->SetXY(8.99 * 10, 19.7 * 10);  // Set position: X = 8.9 cm, Y = 17.7 cm
        $pdf->Cell(0, 5, iconv('utf-8', 'cp874', $data['em_position']), 0, 1, 'L');

        // Output the PDF
        $pdf->Output();
    } else {
        echo "ไม่พบข้อมูลคนต่างด้าว";
    }

    $stmt->close();
} else {
    echo "ข้อมูลไม่ถูกต้อง";
}
?>
