<?= $this->extend('layout/main') ?>

<?php helper('date'); ?>

<?= $this->section('content') ?>
<!-- Begin Page Content -->

<!-- Add CSS for paragraph styles -->
<style>
    .profile-detail {
        font-size: 18px;
        color: black;
    }

    .profile-detail strong {
        color: #4e73df;
    }

    .profile-detail img {
        border-radius: 5px;
    }

    .profile-detail p {
        margin-bottom: 10px;
    }

    .copy-button {
        background-color: #4e73df;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 5px 10px;
        cursor: pointer;
        margin-left: 10px;
    }

    .copy-button:hover {
        background-color: #2e59d9;
    }
</style>

<div class="container mt-5 mb-3">
    <div class="card">
        <div class="card-header text-center">
            <h1>รายละเอียดข้อมูลบุคคล</h1>
        </div>
        <div class="card-body profile-detail">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>คำนำหน้า:</strong> <?= esc($user['title']) ?></p>
                    <p><strong>ชื่อ:</strong> <?= esc($user['first_name']) ?> <?= esc($user['last_name']) ?>
                        <button class="copy-button" onclick="copyText('<?= esc($user['first_name']) ?> <?= esc($user['last_name']) ?>')">คัดลอก</button>
                    </p>
                    <p><strong>เพศ:</strong> <?= esc($user['gender']) ?></p>
                    <p><strong>หมายเลขบัตรประชาชน:</strong> <?= esc($user['national_id']) ?>
                        <button class="copy-button" onclick="copyText('<?= esc($user['national_id']) ?>')">คัดลอก</button>
                    </p>
                    <p><strong>เลขหลังบัตร:</strong> <?= esc($user['back_id']) ?>
                        <button class="copy-button" onclick="copyText('<?= esc($user['back_id']) ?>')">คัดลอก</button>
                    </p>
                    <p><strong>วันเดือนปีเกิด:</strong> <?= thai_date($user['birth']) ?> <!-- แปลงวันที่ --></p>
                    <p><strong>ระดับการศึกษา:</strong> <?= esc($user['education']['education_level']) ?> <strong>สถาบันที่จบ:</strong> <?= esc($user['education']['school']) ?>
                        <button class="copy-button" onclick="copyText('<?= esc($user['education']['school']) ?>')">คัดลอก</button>
                    </p>
                </div>
                <div class="col-md-6">
                    <p><strong>ที่อยู่:</strong></p>
                    <p><?= esc($user['address']['address']) ?> <?= esc($user['address']['subdistrict']) ?> <?= esc($user['address']['district']) ?> <?= esc($user['address']['province']) ?> </p>
                    <p><strong>เบอร์โทร:</strong> <?= esc($user['telephone']) ?>
                        <button class="copy-button" onclick="copyText('<?= esc($user['telephone']) ?>')">คัดลอก</button>
                    </p>
                    <p><strong>สถานะการออกจากงาน:</strong> <?= esc($employ['job_status']) ?> <strong>เหตุผลที่โดนเลิกจ้าง:</strong> <?= !empty($employ['termination_reason']) ? esc($employ['termination_reason']) : '-' ?>
                    </p>
                    <p><strong>ชื่อสถานประกอบการ:</strong> <?= esc($employ['company_name']) ?> <strong>ประเภทกิจการ:</strong> <?= esc($employ['company_type']) ?>
                        <button class="copy-button" onclick="copyText('<?= esc($employ['company_name']) ?> <?= esc($employ['company_type']) ?>')">คัดลอก</button>
                    </p>
                    <p><strong>วันที่ออกจากงาน:</strong> <?= thai_date($employ['date_out']) ?> <!-- แปลงวันที่ --> </p>
                    <p><strong>ตำแหน่งที่ออกจากงาน:</strong> <?= esc($employ['job_position']) ?>
                        <button class="copy-button" onclick="copyText('<?= esc($employ['job_position']) ?>')">คัดลอก</button>
                    </p>
                    <p><strong>ที่อยู่สถานประกอบการ:</strong></p>
                    <p><?= esc($employ['company_subdistrict']) ?> <?= esc($employ['company_district']) ?> <?= esc($employ['company_province']) ?>
                    </p>
                    <p><strong>อัตราเงินเดือน:</strong> <?= esc($employ['salary']) ?>
                        <button class="copy-button" onclick="copyText('<?= esc($employ['salary']) ?>')">คัดลอก</button>
                    </p>
                    <p><strong>บัญชีธนาคาร:</strong> <?= esc($employ['bank_name']) ?> <strong>เลขที่บัญชี:</strong> <?= esc($employ['bank_no']) ?>
                        <button class="copy-button" onclick="copyText('<?= esc($employ['bank_no']) ?>')">คัดลอก</button>
                    </p>
                </div>
            </div>
            <!-- แสดงรูปโปรไฟล์ -->
            <?php if (!empty($employ['bank_pic'])): ?>
                <div class="mt-3 text-center">
                    <strong>รูปหน้าบัญชี:</strong>
                    <div class="mb-3">
                        <img src="<?= base_url('uploads/' . $employ['bank_pic']) ?>" alt="รูปหน้าบัญชี" class="img-fluid" style="max-width: 200px; max-height: 200px;">
                    </div>
                    <!-- ปุ่มดาวน์โหลด -->
                    <a href="<?= base_url('uploads/' . $employ['bank_pic']) ?>" download class="btn btn-primary">
                        ดาวน์โหลดรูปภาพ
                    </a>
                </div>
            <?php else: ?>
                <p class="text-center"><strong>รูปโปรไฟล์:</strong> ไม่มีข้อมูล</p>
            <?php endif; ?>
        </div>
        <!-- Add Card Footer for Button -->
        <div class="card-footer text-right">
            <form action="<?= base_url('home/updateStatus/' . ($user['personal_id'] ?? $user['id'])) ?>" method="post">
                <button type="submit" class="btn btn-success">ดำเนินการสำเร็จ</button>
            </form>
        </div>
    </div>
</div>

<!-- End Page Content -->

<?= $this->endSection() ?>

<?= $this->include('layout/scripts') ?>

<script>
    function copyText(text) {
        var textArea = document.createElement("textarea");
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand("copy");
        document.body.removeChild(textArea);
        alert('ข้อความถูกคัดลอกแล้ว: ' + text);
    }
</script>
