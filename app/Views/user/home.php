<?= $this->extend('user/base') ?>

<?= $this->section('content') ?>


<style>
       .card-link {
        color: #FF6600;
        text-decoration: none;
    }

    .card-link:hover {
        color: #FFD65A;
        text-decoration: underline;
    }

    .card {
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: scale(1.05);
    }
</style>

<!-- XXL Avatar -->
<div class="avatar text-center">
    <img class="avatar-img img-fluid" src="<?= base_url('img/doe.png') ?>" style="width: auto; height: 200px">
</div>
<h1 class="text-center mt-3">ระบบบริการประชาชน สำนักงานจัดหางานจังหวัดกระบี่</h1>
<div class="row mt-3">
    <div class="col-md-4">
        <a href="<?= site_url('user/form_test'); ?>" class="card-link">
            <!-- Card Image Cap (Top) Example -->
            <div class="card">
                <img class="card-img-top img-fluid" src="<?= base_url('img/workoff.png') ?>" alt="...">
                <div class="card-body">
                    <h5 class="card-title">ขึ้นทะเบียนผู้ประกันตนกรณีว่างงาน</h5>
                    <p class="card-text">ขึ้นทะเบียนผู้ประกันตนกรณีว่างงานเพื่อรับเงินชดเชย</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="<?= site_url('user/form_history'); ?>" class="card-link">
            <!-- Card Image Cap (Top) Example -->
            <div class="card">
                <img class="card-img-top img-fluid" src="<?= base_url('img/history.png') ?>" alt="...">
                <div class="card-body">
                    <h5 class="card-title">ฝากประวัติ</h5>
                    <p class="card-text">ฝากประวัติสำหรับผู้สนใจหางาน</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="<?= site_url('user/form_part_time'); ?>" class="card-link">
            <!-- Card Image Cap (Top) Example -->
            <div class="card">
                <img class="card-img-top img-fluid" src="<?= base_url('img/schooljob.png') ?>" alt="...">
                <div class="card-body">
                    <h5 class="card-title">แบบฟอร์มสมัครงาน</h5>
                    <p class="card-text">สำหรับนักเรียน/นักศึกษาที่ประสงค์หางานทำช่วงปิดภาคเรียนหรือช่วงว่างจากการเรียน</p>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="row mt-3 mb-3">
    <div class="col-md-4">
        <a href="http://ci4company.local/" class="card-link">
            <!-- Card Image Cap (Top) Example -->
            <div class="card">
                <img class="card-img-top img-fluid" src="<?= base_url('img/companyfind.png') ?>" alt="...">
                <div class="card-body">
                    <h5 class="card-title">นายจ้าง/สถานประกอบการ</h5>
                    <p class="card-text">คัดลอกประวัติคนหางาน/รับสมัครพนักงาน</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="<?=base_url('/login') ?>" class="card-link">
            <!-- Card Image Cap (Top) Example -->
            <div class="card">
                <img class="card-img-top img-fluid" src="<?= base_url('img/officer.png') ?>" alt="...">
                <div class="card-body">
                    <h5 class="card-title">เข้าสู่ระบบสำหรับ</h5>
                    <p class="card-text">เจ้าหน้าที่สำนักงานจัดหางานจังหวัดกระบี่</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-mb-4"></div>
</div>
<?= $this->endSection() ?>