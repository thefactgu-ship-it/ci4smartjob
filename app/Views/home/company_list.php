<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<!-- Begin Page Content -->
<!-- Card สำหรับแสดงผลนายจ้าง -->
<div class="container-fluid mb-4">
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">ข้อมูลนายจ้าง</h6>
        </div>
        <div class="card-body">
            <?php if (!empty($employerData)): ?>
                <p><strong>ชื่อบริษัท : </strong> <?= esc($employerData['company_name']) ?> <strong>ที่อยู่ : </strong> <?= esc($employerData['company_add']) ?> ผู้คัดลอกประวัติ : </strong> <?= esc($employerData['company_emfullname']) ?></p>
                <!-- เพิ่มข้อมูลเพิ่มเติมตามต้องการ -->
            <?php else: ?>
                <p>ไม่พบข้อมูลนายจ้าง</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Card สำหรับตัวกรอง -->
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
                        <option value="ประถมศึกษา">ประถมศึกษา</option>
                        <option value="มัธยมศึกษาตอนต้น">มัธยมศึกษาตอนต้น</option>
                        <option value="มัธยมศึกษาตอนปลาย">มัธยมศึกษาตอนปลาย</option>
                        <option value="ประกาศนียบัตรวิชาชีพ (ปวช.)">ประกาศนียบัตรวิชาชีพ (ปวช.)</option>
                        <option value="ประกาศนียบัตรวิชาชีพชั้นสูง (ปวส.)">ประกาศนียบัตรวิชาชีพชั้นสูง (ปวส.)</option>
                        <option value="ปริญญาตรี">ปริญญาตรี</option>
                        <option value="ปริญญาโท">ปริญญาโท</option>
                        <option value="ปริญญาเอก">ปริญญาเอก</option>
                        <option value="อื่นๆ">อื่นๆ</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <select id="filterPosition" class="form-control">
                        <option value="">กรองตามตำแหน่งงานที่สนใจ</option>
                        <?php
                        // กรองข้อมูลซ้ำ
                        $positions = array_unique(array_column($personalInformation, 'position'));
                        ?>
                        <?php foreach ($positions as $position): ?>
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

<!-- Card สำหรับ DataTable -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">ข้อมูลผู้ฝากประวัติงาน</h6>
        </div>
        <div class="card-body">
            <form id="bulkActionForm" action="<?= base_url('company/bulkAction') ?>" method="post">
                <input type="hidden" name="selectedIds" id="selectedIds">
                <button type="button" id="bulkActionButton" class="btn btn-primary mb-3">ดำเนินการคัดลอกประวัติ</button>
                <table id="example" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th>ID</th>
                            <th>ชื่อ-นามสกุล</th>
                            <th>วุฒิการศึกษา</th>
                            <th>เพศ</th>
                            <th>ตำแหน่งงานที่สนใจ</th>
                            <th>ดำเนินการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($personalInformation as $info): ?>
                            <tr>
                                <td><input type="checkbox" class="selectRow" value="<?= esc($info['personal_id']) ?>"></td>
                                <td><?= esc($info['personal_id']) ?></td>
                                <td><?= esc($info['first_name']) ?> <?= esc($info['last_name']) ?></td>
                                <td><?= esc($info['education'] ? $info['education']['education_level'] : 'N/A') ?></td>
                                <td><?= esc($info['gender']) ?></td>
                                <td><?= esc($info['position']) ?></td>
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
            </form>
        </div>
    </div>
    <!-- End Card -->
</div>
<!-- End Page Content -->

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
                targets: 6 // Column index 6 (ดำเนินการ)
            }]
        });

        // Filter by Education Level (Column 3)
        $('#filterEducationLevel').on('change', function() {
            table.column(3).search(this.value).draw();
        });

        // Filter by Gender (Column 4)
        $('#filterGender').on('change', function() {
            table.column(4).search(this.value).draw();
        });

        // Filter by Position (Column 5)
        $('#filterPosition').on('change', function() {
            table.column(5).search(this.value).draw();
        });

        // filter button
        $('#filterButton').on('click', function() {
            var educationValue = $('#filterEducationLevel').val();
            var positionValue = $('#filterPosition').val();
            var genderValue = $('#filterGender').val();
            table.column(3).search(educationValue).draw();
            table.column(4).search(genderValue).draw();
            table.column(5).search(positionValue).draw();
        });

        // Multi-select functionality (Checkbox)
        $('#selectAll').click(function() {
            $('.selectRow').prop('checked', this.checked);
        });

        // Bulk Action Button
        $('#bulkActionButton').click(function(event) { // Add event parameter
            var selectedIds = [];
            $('.selectRow:checked').each(function() { // Use class selector instead of tag selector
                selectedIds.push($(this).val());
            });

            if (selectedIds.length > 0) {
                //proceed with bulk action
                Swal.fire({
                    title: 'คุณแน่ใจหรือไม่?',
                    text: "ดำเนินการกับ ID: " + selectedIds.join(', '),
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ใช่, ดำเนินการ!',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#selectedIds').val(selectedIds.join(','));
                        $('#bulkActionForm').submit();
                    }
                });
            } else {
                event.preventDefault(); // Prevent default action
                Swal.fire({
                    icon: 'warning',
                    title: 'แจ้งเตือน',
                    text: 'กรุณาเลือกผู้สมัครงานอย่างน้อย 1 คน!',
                });
            }
        });

        // SweetAlert for success/error messages
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
    });
</script>