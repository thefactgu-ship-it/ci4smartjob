<?= $this->extend('layout/main') ?>

<?php helper('date'); ?>

<?= $this->section('content') ?>
<!-- Begin Page Content -->

<!-- Card -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">ข้อมูลผู้ขึ้นทะเบียนว่างงาน</h6>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="searchByDay">ค้นหาตามวันที่</label>
                    <select id="searchByDay" class="form-control">
                        <option value="">เลือกวันที่</option>
                        <?php for ($i = 1; $i <= 31; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="searchByMonth">ค้นหาตามเดือน</label>
                    <select id="searchByMonth" class="form-control">
                        <option value="">เลือกเดือน</option>
                        <?php
                        $months = [
                            1 => 'มกราคม',
                            2 => 'กุมภาพันธ์',
                            3 => 'มีนาคม',
                            4 => 'เมษายน',
                            5 => 'พฤษภาคม',
                            6 => 'มิถุนายน',
                            7 => 'กรกฎาคม',
                            8 => 'สิงหาคม',
                            9 => 'กันยายน',
                            10 => 'ตุลาคม',
                            11 => 'พฤศจิกายน',
                            12 => 'ธันวาคม'
                        ];
                        foreach ($months as $num => $name): ?>
                            <option value="<?= $num ?>"><?= $name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="searchByYear">ค้นหาตามปี พ.ศ.</label>
                    <select id="searchByYear" class="form-control">
                        <option value="">เลือกปี พ.ศ.</option>
                        <?php for ($i = (date('Y') + 543); $i >= 2543; $i--): ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ชื่อ-นามสกุล</th>
                        <th>รหัสคิว</th>
                        <th>ประเภทผู้ใช้งาน</th>
                        <th>วันที่ขึ้นทะเบียน</th>
                        <th>ดำเนินการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($personalInformation as $info): ?>
                        <tr>
                            <td><?= esc($info['personal_id']) ?></td>
                            <td><?= esc($info['first_name']) ?> <?= esc($info['last_name']) ?></td>
                            <td><?= esc($info['queue_ref']) ?></td>
                            <td><?= esc($info['user_type']) ?></td>
                            <td><?= thai_date($info['created_at']) ?></td>
                            <td>
                                <!-- ปุ่มดำเนินการ -->
                                <a href="<?= base_url('home/report_details/' . $info['personal_id']); ?>" class="btn btn-success btn-sm">
                                    <i class="fas fa-search"></i> แสดงข้อมูล
                                </a>
                                <a href="javascript:void(0)"
                                    class="btn btn-danger btn-sm delete-button"
                                    data-id="<?= esc($info['personal_id']) ?>"
                                    data-url="<?= base_url('home/delete/' . $info['personal_id']) ?>">
                                    <i class="fas fa-trash-alt"></i> ลบ
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
        var table = $('#example').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/th.json"
            },
            responsive: true,
            columnDefs: [{
                orderable: false,
                targets: 5
            }]
        });

        $('#searchByDay, #searchByMonth, #searchByYear').on('change', function() {
            var day = $('#searchByDay').val();
            var month = $('#searchByMonth').val();
            var year = $('#searchByYear').val();
            var searchValue = (day ? day + ' ' : '') + (month ? $('#searchByMonth option:selected').text() + ' ' : '') + (year ? year : '');

            table.column(4).search(searchValue).draw(); // ใช้คอลัมน์หมายเลข 4 สำหรับ 'วันที่ขึ้นทะเบียน'
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