<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid mt-4">
    <h1 class="h3 mb-4 text-gray-800">แก้ไขโปรไฟล์</h1>

    <?php if (session()->getFlashdata('msg')): ?>
        <div class="alert alert-<?= session()->getFlashdata('alert') ?>">
            <?= session()->getFlashdata('msg') ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-4">
            <!-- Profile Picture Section -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">รูปโปรไฟล์</h6>
                </div>
                <div class="card-body text-center">
                    <img class="img-profile rounded-circle mb-3" src="<?= base_url('uploads/' . session()->get('em_pic')) ?>" alt="Profile Picture" width="160" height="160">
                    <form action="<?= base_url('/employeecontroller/updateProfile') ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="file" class="form-control-file" id="em_pic" name="em_pic" accept="image/*">
                            <small class="form-text text-muted">ไฟล์ JPG หรือ PNG ขนาดไม่เกิน 5 MB</small>
                        </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <!-- Account Details Section -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">รายละเอียดบัญชี</h6>
                </div>
                <div class="card-body">
                <form action="<?= base_url('/employeecontroller/updateProfile') ?>" method="post">
                    <div class="form-group">
                        <label for="username">ชื่อผู้ใช้</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?= session()->get('username') ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="em_fullname">ชื่อเต็ม</label>
                        <input type="text" class="form-control" id="em_fullname" name="em_fullname" value="<?= session()->get('em_fullname') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="position">ตำแหน่ง</label>
                        <input type="text" class="form-control" id="position" name="position" value="<?= session()->get('position') ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</button>
                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#updatePasswordModal">อัปเดตรหัสผ่าน</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->include('layout/scripts') ?>
<!-- Modal -->
<div class="modal fade" id="updatePasswordModal" tabindex="-1" role="dialog" aria-labelledby="updatePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updatePasswordModalLabel">อัปเดตรหัสผ่าน</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('/employeecontroller/updatePassword') ?>" method="post">
                    <div class="form-group">
                        <label for="new_password">รหัสผ่านใหม่</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">ยืนยันรหัสผ่านใหม่</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </form>
            </div>
        </div>
    </div>
</div>