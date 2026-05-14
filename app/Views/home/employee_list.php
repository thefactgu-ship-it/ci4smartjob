<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid mt-4">
    <h1 class="h3 mb-4 text-gray-800">รายชื่อพนักงาน</h1>

    <?php if (session()->getFlashdata('msg')): ?>
        <div class="alert alert-<?= session()->getFlashdata('alert') ?>">
            <?= session()->getFlashdata('msg') ?>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">รายชื่อพนักงาน</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="employeeTable" class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ชื่อผู้ใช้</th>
                            <th>ชื่อเต็ม</th>
                            <th>ตำแหน่ง</th>
                            <th>รูปโปรไฟล์</th>
                            <th>ดำเนินการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($employees as $employee): ?>
                            <tr>
                                <td><?= esc($employee['em_id']) ?></td>
                                <td><?= esc($employee['username']) ?></td>
                                <td><?= esc($employee['em_fullname']) ?></td>
                                <td><?= esc($employee['position']) ?></td>
                                <td><img src="<?= base_url('uploads/' . esc($employee['em_pic'])) ?>" alt="Profile Picture" width="50" height="50"></td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal" data-id="<?= esc($employee['em_id']) ?>" data-username="<?= esc($employee['username']) ?>" data-fullname="<?= esc($employee['em_fullname']) ?>" data-position="<?= esc($employee['position']) ?>">
                                        แก้ไข
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm delete-button" data-id="<?= esc($employee['em_id']) ?>">
                                        ลบ
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">แก้ไขข้อมูลพนักงาน</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm" action="<?= base_url('/employeecontroller/updateEmployee') ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="edit_em_id" name="em_id">
                    <div class="form-group">
                        <label for="edit_username">ชื่อผู้ใช้</label>
                        <input type="text" class="form-control" id="edit_username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_fullname">ชื่อเต็ม</label>
                        <input type="text" class="form-control" id="edit_fullname" name="em_fullname" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_position">ตำแหน่ง</label>
                        <input type="text" class="form-control" id="edit_position" name="position" required>
                    </div>
                    <button type="submit" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->include('layout/scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(document).ready(function() {
        $('#employeeTable').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/th.json" // ใช้ภาษาไทย
            },
            responsive: true
        });

        // เปิด modal และตั้งค่าข้อมูลการแก้ไข
        $('#editModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var em_id = button.data('id');
            var username = button.data('username');
            var fullname = button.data('fullname');
            var position = button.data('position');

            console.log("เปิด Modal - ข้อมูลที่รับมา:", {
                em_id,
                username,
                fullname,
                position
            });

            var modal = $(this);
            modal.find('#edit_em_id').val(em_id);
            modal.find('#edit_username').val(username);
            modal.find('#edit_fullname').val(fullname);
            modal.find('#edit_position').val(position);
        });

        // อัปเดตข้อมูลพนักงานผ่าน AJAX
        $('#editForm').on('submit', function(e) {
            e.preventDefault(); // ป้องกันการ reload หน้า

            var formData = $(this).serialize(); // ดึงข้อมูลจากฟอร์ม
            console.log("ส่งข้อมูลไปยัง Controller:", formData);

            $.ajax({
                url: $(this).attr('action'), // URL ที่จะส่งไป
                type: 'POST',
                data: formData,
                dataType: 'json', // รับค่ากลับเป็น JSON
                success: function(response) {
                    console.log("Response จาก Server:", response);
                    if (response.status === 'success') {
                        Swal.fire({
                            title: 'สำเร็จ!',
                            text: response.message,
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => location.reload()); // รีโหลดหน้า
                    } else {
                        Swal.fire('เกิดข้อผิดพลาด', response.message, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("เกิดข้อผิดพลาด:", xhr.responseText);
                    Swal.fire('เกิดข้อผิดพลาด', 'ไม่สามารถอัปเดตข้อมูลได้', 'error');
                }
            });
        });

        // ลบพนักงาน
        $('.delete-button').on('click', function() {
            var em_id = $(this).data('id');
            console.log("กดลบพนักงาน ID:", em_id);
            Swal.fire({
                title: 'คุณแน่ใจหรือไม่ว่าต้องการลบพนักงานคนนี้?',
                text: "การกระทำนี้ไม่สามารถย้อนกลับได้!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, ลบเลย!',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= base_url('/employeecontroller/deleteEmployee') ?>/' + em_id,
                        type: 'GET',
                        success: function(response) {
                            console.log("ลบสำเร็จ:", response);
                            Swal.fire('ลบสำเร็จ!', 'ข้อมูลพนักงานถูกลบแล้ว', 'success').then(() => location.reload());
                        },
                        error: function(xhr, status, error) {
                            console.error("เกิดข้อผิดพลาด:", xhr.responseText);
                            Swal.fire('เกิดข้อผิดพลาด', 'ไม่สามารถลบข้อมูลได้', 'error');
                        }
                    });
                }
            });
        });
    });
</script>