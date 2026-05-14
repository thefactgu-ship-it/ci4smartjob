<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid mb-4">
    <div class="card shadow rounded">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">สรุปรายชื่อผู้สมัครที่เลือก</h6>
        </div>
        <div class="card-body">
            <div class="text-center mb-4">
                <h5>บริษัท: <?= esc($companyInfo['company_name']) ?></h5>
                <p>เลขที่บริษัท: <?= esc($companyInfo['company_number']) ?></p>
            </div>
            <form id="summaryForm" action="<?= base_url('company/saveSelection') ?>" method="post">
                <input type="hidden" name="selectedIds" id="selectedIds" value="<?= esc(implode(',',$selectedIds))?>">
                <div class="table-responsive">
                    <table id="summaryTable" class="table table-bordered table-hover" style="width:100%">
                        <thead>
                            <tr class="bg-light">
                                <th>ID</th>
                                <th>ชื่อ-นามสกุล</th>
                                <th>ตำแหน่ง</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($selectedApplicants)) : ?>
                                <tr>
                                    <td colspan="3" class="text-center">ไม่พบข้อมูลผู้สมัครที่เลือก</td>
                                </tr>
                            <?php else : ?>
                                <?php foreach ($selectedApplicants as $applicant) : ?>
                                    <tr data-id="<?= esc($applicant['id']) ?>">
                                        <td><?= esc($applicant['id']) ?></td>
                                        <td><?= esc($applicant['first_name']) ?> <?= esc($applicant['last_name']) ?></td>
                                        <td>
                                            <?php if (empty($applicant['jobHistory'])) : ?>
                                                ไม่มีประวัติการทำงาน
                                            <?php else : ?>
                                                <?php foreach ($applicant['jobHistory'] as $job) : ?>
                                                    <?= esc($job['position']) ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="alert alert-info mt-3" role="alert">
                    ข้อมูลที่ได้คัดลอกไปนำไปเพื่อพิจารณาเข้ารับการทำงานเท่านั้น
                </div>
                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" value="" id="agreeCheckbox">
                    <label class="form-check-label" for="agreeCheckbox">
                        ฉันยอมรับข้อตกลง
                    </label>
                </div>
                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-success rounded" id="saveButton" disabled>บันทึกการเลือก</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#summaryTable').DataTable();

        var form = document.getElementById("summaryForm");
        var agreeCheckbox = document.getElementById('agreeCheckbox');
        var saveButton = document.getElementById('saveButton');

        // Enable/disable the save button based on the agree checkbox
        agreeCheckbox.addEventListener('change', function() {
            saveButton.disabled = !this.checked;
        });
        // Handle form submission
        form.addEventListener("submit", function(event) {
            if (!agreeCheckbox.checked) {
                event.preventDefault(); // Prevent form submission
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด!',
                    text: 'กรุณายอมรับข้อตกลงก่อนบันทึก',
                    confirmButtonText: 'ตกลง'
                });
            }
        });

        <?php if (session()->getFlashdata('success')) : ?>
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!',
                text: '<?= session()->getFlashdata('success') ?>',
                confirmButtonText: 'ตกลง'
            });
        <?php elseif (session()->getFlashdata('error')) : ?>
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด!',
                text: '<?= session()->getFlashdata('error') ?>',
                confirmButtonText: 'ตกลง'
            });
        <?php endif; ?>
    });
</script>

<?= $this->endSection() ?>
