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
</style>

<div class="container mt-5 mb-3">
    <div class="card">
        <div class="card-header text-center">
            <h2>รายละเอียดข้อมูลนักเรียน/นักศึกษาต้องการหางานทำช่วงปิดภาคเรียน</h2>
        </div>
        <div class="card-body profile-detail">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>คำนำหน้า:</strong> <?= esc($user['title']) ?></p>
                    <p><strong>ชื่อ:</strong> <?= esc($user['first_name']) ?> <?= esc($user['last_name']) ?></p>
                    <p><strong>เพศ:</strong> <?= esc($user['gender']) ?></p>
                    <p><strong>หมายเลขบัตรประชาชน:</strong> <?= esc($user['national_id']) ?></p>
                    <p><strong>เลขหลังบัตร:</strong> <?= esc($user['back_id']) ?></p>
                    <p><strong>วันเดือนปีเกิด:</strong> <?= thai_date($user['birth']) ?></p> <!-- แปลงวันที่ -->
                    <p><strong>ระดับการศึกษา:</strong> <?= esc($user['education']['education_level']) ?> <strong>สถาบันที่กำลังศึกษาอยู่:</strong> <?= esc($user['education']['school']) ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>ที่อยู่:</strong></p>
                    <p><?= esc($user['address']['address']) ?> <?= esc($user['address']['subdistrict']) ?> <?= esc($user['address']['district']) ?> <?= esc($user['address']['province']) ?></p>
                    <p><strong>เบอร์โทร:</strong> <?= esc($user['telephone']) ?></p>
                    <p><strong>ตำแหน่งงานที่ต้องการ:</strong> <?= esc($job['position']) ?></p>
                    <p><strong>อัตราค่าจ้างที่ต้องการ:</strong> <?= esc($job['salary']) ?></p>
                </div>
            </div>
        </div>
        <!-- Add Card Footer for Button -->
        <div class="card-footer text-right">
            <button type="button" class="btn btn-success" onclick="window.history.back();">ย้อนกลับ</button>
        </div>
    </div>
</div>

<!-- End Page Content -->

<?= $this->endSection() ?>

<?= $this->include('layout/scripts') ?>