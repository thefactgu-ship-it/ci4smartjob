<?= $this->extend('user/base') ?>

<?= $this->section('content') ?>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // สร้างตัวแปรเพื่อตรวจสอบว่า SweetAlert ถูกแสดงแล้วหรือยัง
    let isAlertShown = false;

    // ฟังก์ชันที่จะดึงสถานะจากเซิร์ฟเวอร์
    function fetchStatus() {
        var personalId = "<?= $personal['id'] ?>"; // ใช้ personalId แทน queue_ref

        axios.get('<?= site_url('user/get-status/') ?>' + personalId)
            .then(function(response) {
                if (response.data.success) {
                    // อัปเดตสถานะในหน้าเว็บ
                    const statusText = response.data.status;
                    document.getElementById('status').innerText = statusText;

                    // แสดง SweetAlert เมื่อสถานะเป็น "ดำเนินการสำเร็จ" และยังไม่แสดงมาก่อน
                    if (statusText === 'ดำเนินการสำเร็จ' && !isAlertShown) {
                        Swal.fire({
                            icon: 'success',
                            title: 'สำเร็จ!',
                            text: 'การดำเนินการเสร็จสมบูรณ์แล้ว',
                            confirmButtonText: 'ตกลง'
                        });

                        // ตั้งค่าให้ SweetAlert ไม่แสดงอีก
                        isAlertShown = true;
                    }
                } else {
                    console.log(response.data.message);
                }
            })
            .catch(function(error) {
                console.log('Error: ', error);
            });
    }

    // เรียกฟังก์ชันทุกๆ 5 วินาที
    setInterval(fetchStatus, 5000);
</script>

<div class="container">

    <!-- แสดงข้อความจากฟังก์ชัน save -->
    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-info mt-3"><?= session()->getFlashdata('message') ?></div>
    <?php endif; ?>

    <h2>ตรวจสอบสถานะ</h2>
    <!-- แสดงข้อมูลที่บันทึก -->
    <?php if (isset($personal)): ?>
        <h3>ข้อมูลการใช้บริการขึ้นทะเบียนว่างงาน</h3>
        <p><strong>ชื่อ:</strong> <?= $personal['first_name'] . ' ' . $personal['last_name'] ?></p>
        <p><strong>รหัสคิว:</strong> <?= $personal['queue_ref'] ?></p> <!-- ใช้ id เป็นรหัสคิว -->
        <p><strong>สถานะ:</strong> <span id="status"><?= $personal['queue_status'] ?></span></p>
        <!-- เพิ่มข้อมูลที่ต้องการแสดงได้ที่นี่ -->
    <?php else: ?>
        <p>ไม่พบข้อมูลผู้สมัคร</p>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>