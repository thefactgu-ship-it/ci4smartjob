<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<style>
    .centered-form {
        max-width: 700px;
        /* กำหนดขนาดสูงสุดของฟอร์ม */
        margin: 0 auto;
        /* ทำให้ฟอร์มอยู่ตรงกลางหน้าจอ */
        padding: 20px;
        /* เพิ่มพื้นที่ระหว่างฟอร์มและขอบของการ์ด */
    }
</style>
<!-- Begin Page Content -->
<div class="container-fluid">
    <h2 class="mt-4 mb-4">เพิ่มพนักงานใหม่</h2>
    <?php if (session()->getFlashdata('msg')): ?>
        <div class="alert alert-<?= session()->getFlashdata('alert') ?>">
            <?= session()->getFlashdata('msg') ?>
        </div>
    <?php endif; ?>
    <div class="card shadow mb-4 centered-form">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">ข้อมูลพนักงาน</h6>
        </div>
        <div class="card-body">
            <form action="/employeecontroller/save" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="fullname">ชื่อ - นามสกุล</label>
                    <input type="fullname" class="form-control" id="fullname" name="fullname" required>
                </div>
                <div class="form-group">
                    <label for="position">Position</label>
                    <input type="text" class="form-control" id="position" name="position" required>
                </div>
                <div class="form-group">
                    <label for="em_pic">รูปโปรไฟล์</label>
                    <input type="file" class="form-control-file" id="em_pic" name="em_pic" accept="image/*" required>
                    <small class="form-text text-muted">ไฟล์ JPG หรือ PNG ขนาดไม่เกิน 5 MB</small>
                </div>
                <button type="submit" class="btn btn-primary btn-block">เพิ่มพนักงาน</button>
            </form>
        </div>
    </div>
</div>
<!-- End Page Content -->
<?= $this->endSection() ?>

<?= $this->include('layout/scripts') ?>