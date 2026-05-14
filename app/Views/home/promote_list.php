<?= $this->extend('layout/main') ?>

<!-- โหลดฟังก์ชั่นสำหรับแปลงวันที่และคำนวณอายุ -->
<?php helper('date'); ?>

<?= $this->section('content') ?>
<!-- Begin Page Content -->


<!-- Card -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">ข้อมูลผู้ต้องการรับคำปรึกษาด้านอาชีพ</h6>
        </div>
        <div class="card-body">
            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ชื่อ-นามสกุล</th>
                        <th>ต้องการการรับคำปรึกษาด้านอาชีพในด้านใด</th>
                        <th>ดำเนินการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($personalInformation)) : ?>
                        <tr>
                            <td colspan="4" class="text-center">ไม่มีข้อมูล</td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach ($personalInformation as $info): ?>
                        <tr>
                            <td><?= esc($info['personal_id']) ?></td>
                            <td><?= esc($info['first_name']) ?> <?= esc($info['last_name']) ?></td>
                            <td><?= isset($info['jobHistory']['promote_occupation']) && $info['jobHistory']['promote_occupation'] !== '' ? esc($info['jobHistory']['promote_occupation']) : '-' ?></td>
                            <td>
                                <!-- ปุ่มดำเนินการ -->
                                <a href="<?= base_url('promote_details/' . $info['personal_id']); ?>" class="btn btn-success btn-sm">
                                    <i class="fas fa-search"></i> แสดงรายละเอียด
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- End Card -->
</div>
<!-- End Page Content -->

<?= $this->endSection() ?>

<?= $this->include('layout/scripts') ?>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/th.json" // ใช้ภาษาไทย
            },
            responsive: true,
            columnDefs: [{
                    orderable: false,
                    targets: 3
                } // ปิดการจัดเรียงในคอลัมน์ 'ดำเนินการ'
            ]
        });
    });
    // การแสดงผลข้อความสำเร็จหรือล้มเหลวหลังการลบ
    <?php if (session()->getFlashdata('success')): ?>
        Swal.fire({
            icon: 'success',
            title: 'สำเร็จ',
            text: '<?= session()->getFlashdata('success') ?>',
        });
    <?php elseif (session()->getFlashdata('error')): ?>
        Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาด',
            text: '<?= session()->getFlashdata('error') ?>',
        });
    <?php endif; ?>
    $(document).ready(function() {
        // Handle delete button click
        $('.delete-button').on('click', function(e) {
            e.preventDefault();

            let deleteUrl = $(this).data('url'); // URL สำหรับลบ
            let rowId = $(this).data('id'); // ID ของข้อมูลที่ต้องการลบ

            Swal.fire({
                title: 'คุณแน่ใจหรือไม่?',
                text: "การกระทำนี้จะลบข้อมูล ID: " + rowId,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, ลบเลย!',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect ไปยัง URL สำหรับลบ
                    window.location.href = deleteUrl;
                }
            });
        });
    });
</script>