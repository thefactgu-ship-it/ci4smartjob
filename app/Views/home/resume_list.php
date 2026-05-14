<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid mb-4">
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">กรองข้อมูล</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <select id="filterEducationLevel" class="form-control">
                        <option value="">กรองตามระดับการศึกษา</option>
                        <?php
                        // ดึงข้อมูลระดับการศึกษาจากตาราง educations
                        $educationLevels = array_unique(array_column(array_column($personalInformation, 'education'), 'education_level'));
                        foreach ($educationLevels as $level): ?>
                            <option value="<?= esc($level) ?>"><?= esc($level) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <select id="filterPosition" class="form-control">
                        <option value="">กรองตามตำแหน่งงานที่สนใจ</option>
                        <?php
                        // ดึงข้อมูลตำแหน่งงานจากตาราง job_history
                        $positions = array_unique(array_column($personalInformation, 'promote_occupation'));
                        foreach ($positions as $position): ?>
                            <option value="<?= esc($position) ?>"><?= esc($position) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <select id="filterGender" class="form-control">
                        <option value="">กรองตามเพศ</option>
                        <option value="ชาย">ชาย</option>
                        <option value="หญิง">หญิง</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <button id="filterButton" class="btn btn-primary">กรองข้อมูล</button>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">ข้อมูลผู้ฝากประวัติงาน</h6>
        </div>
        <div class="card-body">
            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ชื่อ-นามสกุล</th>
                        <th>วุฒิการศึกษา</th>
                        <th>เพศ</th>
                        <th>ตำแหน่งงานที่สนใจ</th>
                        <th>เบอร์โทร</th>
                        <th>ดำเนินการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($personalInformation as $info): ?>
                        <tr>
                            <td><?= esc($info['personal_id']) ?></td>
                            <td><?= esc($info['first_name']) ?> <?= esc($info['last_name']) ?></td>
                            <td><?= esc($info['education']['education_level']) ?>, <?= esc($info['education']['school']) ?></td>
                            <td><?= esc($info['gender']) ?></td>
                            <td><?= esc($info['position']) ?></td>
                            <td><?= esc($info['telephone']) ?></td>
                            <td>
                                <a href="<?= base_url('resume_details/' . $info['personal_id']); ?>" class="btn btn-success btn-sm">
                                    <i class="fas fa-search"></i> แสดงรายละเอียด
                                </a>
                                <a href="<?= base_url('generate-resume/' . $info['personal_id']); ?>" class="btn btn-danger btn-sm">
                                    <i class="fas fa-file-pdf"></i> Download PDF
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
<?= $this->endSection() ?>

<?= $this->include('layout/scripts') ?>
<script src="//cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.7.1/js/buttons.flash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/th.json" // ใช้ภาษาไทย
            },
            responsive: true,
            columnDefs: [{
                orderable: false,
                targets: 5
            }], // ปิดการจัดเรียงในคอลัมน์ 'ดำเนินการ'
            dom: 'Bfrtip', // กำหนดตำแหน่งของปุ่ม
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print' // ปุ่มการส่งออกข้อมูล
            ]
        });

        // ฟังก์ชันกรองข้อมูลตามระดับการศึกษา
        $('#filterEducationLevel').on('change', function() {
            table.column(2) // สมมติว่า `education_level` อยู่ในคอลัมน์ที่ 2
                .search(this.value)
                .draw();
        });

        // ฟังก์ชันกรองข้อมูลตามตำแหน่ง
        $('#filterGender').on('change', function() {
            table.column(3) // สมมติว่า `position` อยู่ในคอลัมน์ที่ 3
                .search(this.value)
                .draw();
        });

        // ฟังก์ชันกรองข้อมูลตามตำแหน่ง
        $('#filterPosition').on('change', function() {
            table.column(4) // สมมติว่า `position` อยู่ในคอลัมน์ที่ 3
                .search(this.value)
                .draw();
        });

        // เพิ่มฟังก์ชันการกรองข้อมูลด้วยปุ่ม
        $('#filterButton').on('click', function() {
            var educationValue = $('#filterEducationLevel').val();
            var positionValue = $('#filterPosition').val();

            // ฟิลเตอร์ตามการศึกษา
            table.column(2).search(educationValue).draw();
            // ฟิลเตอร์ตามตำแหน่ง
            table.column(3).search(positionValue).draw();
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