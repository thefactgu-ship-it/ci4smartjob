<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<!-- Begin Page Content -->

<style>
    .chart-area,
    .chart-pie {
        height: 100% !important;
    }
</style>

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

    <!-- Content Row -->
    <div class="row">

        <!-- จำนวนผู้มาใช้บริการ Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                จำนวนผู้มาใช้บริการทั้งหมด (ราย)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalUsers ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- จำนวนผู้ใช้ที่เป็นบุคคลทั่วไป Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                จำนวนผู้ใช้บริการที่ขึ้นทะเบียนว่างงาน (ราย)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $generalUsers ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- จำนวนผู้ใช้ที่เป็นนักเรียนนักศึกษา Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                จำนวนผู้ใช้บริการที่เป็นนักเรียนนักศึกษา (ราย)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $studentUsers ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                จำนวนผู้ใช้บริการที่ต้องการคำปรึกษาด้านประกอบอาชีพ (ราย)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $pendingRequests ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-md fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Line Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">จำนวนผู้ใช้บริการในแต่ละเดือน (ราย)</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myUserChart" style="height:400px;"></canvas> <!-- ตั้งค่าความสูงของ canvas -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">จำนวนผู้มาใช้บริการ ชาย/หญิง</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <!-- Add this inside your card body -->
                    <div class="chart-pie">
                        <canvas id="genderPieChart" style="height:400px;"></canvas> <!-- ตั้งค่าความสูงของ canvas -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Page Content -->
<?= $this->endSection() ?>
<?= $this->include('layout/scripts') ?>

<script>
    var ctx = document.getElementById('genderPieChart').getContext('2d');
    var genderPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['ชาย', 'หญิง'],
            datasets: [{
                data: [<?= $maleUsers ?>, <?= $femaleUsers ?>], // ข้อมูลที่ดึงจาก Controller
                backgroundColor: ['#4e73df', '#ff6384'],
                hoverBackgroundColor: ['#2e59d9', '#e91e63'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    boxWidth: 20,
                    fontColor: '#858796',
                    padding: 10,
                }
            },
            cutoutPercentage: 80,
        },
    });
</script>

<script>
    var monthNames = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
    var yearMonths = <?= json_encode($yearMonths) ?>;
    var monthLabels = yearMonths.map(function(yearMonth) {
        var parts = yearMonth.split('-');
        var year = parseInt(parts[0]) + 543; // แปลงปี ค.ศ. เป็น พ.ศ.
        var month = parseInt(parts[1]);
        return monthNames[month - 1] + ' ' + year;
    });
    var generalUserCounts = <?= json_encode($generalUserCounts) ?>;
    var resumeUserCounts = <?= json_encode($resumeUserCounts) ?>;
    var studentUserCounts = <?= json_encode($studentUserCounts) ?>;
    var promoteOccupationCounts = <?= json_encode($promoteOccupationCounts) ?>;
    // ปรับปี ค.ศ. เป็น พ.ศ.
    var currentYear = new Date().getFullYear() + 543;

    var ctx = document.getElementById('myUserChart').getContext('2d');
    var myBarChart = new Chart(ctx, {
        type: 'bar', // เปลี่ยนประเภทกราฟเป็นกราฟแท่ง
        data: {
            labels: monthLabels, // ใช้ monthLabels ที่ถูกต้อง
            datasets: [{
                    label: 'ขึ้นทะเบียนว่างงาน',
                    data: generalUserCounts,
                    backgroundColor: 'rgba(78, 115, 223, 0.8)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 1
                },
                {
                    label: 'ฝากประวัติ',
                    data: resumeUserCounts,
                    backgroundColor: 'rgba(54, 185, 204, 0.8)',
                    borderColor: 'rgba(54, 185, 204, 1)',
                    borderWidth: 1
                },
                {
                    label: 'นักเรียนนักศึกษา',
                    data: studentUserCounts,
                    backgroundColor: 'rgba(246, 194, 62, 0.8)',
                    borderColor: 'rgba(246, 194, 62, 1)',
                    borderWidth: 1
                },
                {
                    label: 'ผู้ต้องการคำปรึกษาด้านอาชีพ', // เพิ่ม label ใหม่
                    data: promoteOccupationCounts, // ข้อมูลจาก promoteOccupationCounts
                    backgroundColor: 'rgba(255, 99, 132, 0.8)', // สีแดง
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                x: { // แก้ไขจาก xAxes เป็น x
                    title: {
                        display: true,
                        text: 'เดือน' // เปลี่ยนชื่อแกน x เป็น "เดือน"
                    },
                    grid: { // แก้ไขจาก gridLines เป็น grid
                        display: false,
                        drawBorder: false
                    },
                    ticks: { // แก้ไขจาก ticks เป็น ticks
                        maxTicksLimit: 12
                    }
                },
                y: { // แก้ไขจาก yAxes เป็น y
                    title: {
                        display: true,
                        text: 'จำนวนผู้ใช้' // เปลี่ยนชื่อแกน y เป็น "จำนวนผู้ใช้"
                    },
                    ticks: { // แก้ไขจาก ticks เป็น ticks
                        beginAtZero: true // ให้แสดงค่าเริ่มต้นจาก 0
                    },
                    grid: { // แก้ไขจาก gridLines เป็น grid
                        color: 'rgba(234, 236, 244, 1)',
                        zeroLineColor: 'rgba(234, 236, 244, 1)',
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                },
            },
            legend: {
                display: true // แสดง legend
            },
            tooltips: {
                backgroundColor: 'rgb(255,255,255)',
                bodyFontColor: '#858796',
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: true,
                intersect: false,
                mode: 'index',
                caretPadding: 10,
            }
        }
    });
</script>