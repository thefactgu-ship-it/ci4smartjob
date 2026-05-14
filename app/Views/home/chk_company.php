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
    <h2 class="mt-4 mb-4"></h2>
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
            <form action="/company/chk_company" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="company_number">เลขนิติบุคคล/หมายเลขบัตรประชาชน</label>
                    <input type="text" class="form-control" id="company_number" name="company_number" maxlength="13" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">กดตรวจสอบข้อมูล</button>
            </form>
        </div>
    </div>
</div>
<!-- End Page Content -->
<?= $this->endSection() ?>

<?= $this->include('layout/scripts') ?>