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
    <h2 class="mt-4 mb-4">เพิ่มข้อมูลนายจ้าง/สถานประกอบการใหม่</h2>
    <?php if (session()->getFlashdata('msg')): ?>
        <div class="alert alert-<?= session()->getFlashdata('alert') ?>">
            <?= session()->getFlashdata('msg') ?>
        </div>
    <?php endif; ?>
    <div class="card shadow mb-4 centered-form">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">ข้อมูลนายจ้าง/สถานประกอบการ</h6>
        </div>
        <div class="card-body">
            <form action="/company/saveAdd_company" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="company_number">เลขนิติบุคคล/หมายเลขบัตรประชาชน</label>
                    <input type="text" class="form-control" id="company_number" name="company_number" maxlength="13" required>
                </div>
                <div class="form-group">
                    <label for="company_name">ชื่อสถานประกอบการ</label>
                    <input type="text" class="form-control" id="company_name" name="company_name" required>
                </div>
                <div class="form-group">
                    <label for="company_nationid">หมายเลขบัตรประชาชนผู้คัดประวัติ</label>
                    <input type="text" class="form-control" id="company_nationid" name="company_nationid" required>
                </div>
                <div class="form-group">
                    <label for="company_emfullname">ชื่อ - นามสกุล ผู้คัดประวัติ</label>
                    <input type="text" class="form-control" id="company_emfullname" name="company_emfullname" required>
                </div>
                <div class="form-group">
                    <label for="company_add">ที่อยู่สถานประกอบการ</label>
                    <input type="text" class="form-control" id="company_add" name="company_add" required>
                </div>
                <div class="form-group">
                    <label for="company_telephone">เบอร์โทร</label>
                    <input type="text" class="form-control" id="company_telephone" name="company_telephone" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">เพิ่มนายจ้าง/สถานประกอบการ</button>
            </form>
        </div>
    </div>
</div>
<!-- End Page Content -->
<?= $this->endSection() ?>

<?= $this->include('layout/scripts') ?>