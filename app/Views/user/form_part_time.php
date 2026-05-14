<?= $this->extend('user/base') ?>

<?= $this->section('content') ?>
<style>
    .step-navigation {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .step-navigation .step-item {
        position: relative;
        flex: 1;
        text-align: center;
    }

    .step-navigation .step-item:not(:last-child)::after {
        content: '';
        position: absolute;
        top: 50%;
        right: 0;
        width: 100%;
        height: 2px;
        background: #ddd;
        transform: translateY(-50%);
        z-index: -1;
    }

    .step-navigation .step-item-link {
        display: inline-block;
        width: 40px;
        height: 40px;
        line-height: 40px;
        border-radius: 50%;
        background: #ddd;
        color: #666;
        font-weight: bold;
        text-decoration: none;
        transition: all 0.3s ease-in-out;
    }

    .step-navigation .step-item.active .step-item-link {
        background: #007bff;
        color: #fff;
        border: 2px solid #0056b3;
    }

    .step-navigation .step-item.disabled .step-item-link {
        background: #f5f5f5;
        color: #ccc;
        pointer-events: none;
    }

    .step {
        display: none;
    }

    .step.active {
        display: block;
    }

    .form-container {
        max-width: 45%;
        margin: 0 auto;
        padding: 20px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .form-container h3 {
        margin-bottom: 20px;
        text-align: center;
    }
</style>
<!-- เพิ่ม script ที่จำเป็น -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        // Show the first step
        $('#step1').addClass('active');
        $('#nav-step1').addClass('active');

        // Next button click
        $('.next-step').click(function() {
            var currentStep = $(this).data('next');
            var prevStep = $(this).closest('.step');
            var inputs = prevStep.find(':input[required]'); // หาข้อมูลที่ required

            // ตรวจสอบว่ามีช่องที่ required กรอกครบหรือไม่
            var isValid = true;
            inputs.each(function() {
                if (!this.checkValidity()) {
                    isValid = false;
                    $(this).addClass('is-invalid'); // เพิ่ม class is-invalid ถ้าไม่ผ่านการตรวจสอบ
                } else {
                    $(this).removeClass('is-invalid'); // ลบ class is-invalid ถ้าผ่านการตรวจสอบ
                }
            });

            if (isValid) {
                // Activate the next step ถ้าข้อมูลครบ
                prevStep.removeClass('active');
                $('#' + currentStep).addClass('active');

                // Update navigation
                $('.step-navigation .step-item').removeClass('active');
                $('#nav-' + currentStep).addClass('active');
            }
        });

        // Previous button click
        $('.prev-step').click(function() {
            var currentStep = $(this).data('prev');
            var nextStep = $(this).closest('.step');

            // Activate the previous step
            nextStep.removeClass('active');
            $('#' + currentStep).addClass('active');

            // Update navigation
            $('.step-navigation .step-item').removeClass('active');
            $('#nav-' + currentStep).addClass('active');
        });
    });

    $(document).ready(function() {
        const jsonFilePath = '/thailand.json'; // เส้นทางไปยังไฟล์ JSON ของคุณ

        let data = [];

        // ดึงข้อมูล JSON
        $.getJSON(jsonFilePath, function(response) {
            data = response;

            // สร้างรายการจังหวัด
            const provinces = [...new Set(data.map(item => item.provinceNameTh))];
            provinces.forEach(province => {
                $('#province').append(new Option(province, province));
            });
        });

        // เมื่อเลือกจังหวัด
        $('#province').on('change', function() {
            const selectedProvince = $(this).val();

            // ล้าง Dropdown อำเภอและตำบล
            $('#district').empty().append(new Option('เลือกอำเภอ', '')).prop('disabled', !selectedProvince);
            $('#subdistrict').empty().append(new Option('เลือกตำบล', '')).prop('disabled', true);

            // สร้างรายการอำเภอตามจังหวัดที่เลือก
            const districts = [
                ...new Set(
                    data
                    .filter(item => item.provinceNameTh === selectedProvince)
                    .map(item => item.districtNameTh)
                )
            ];
            districts.forEach(district => {
                $('#district').append(new Option(district, district));
            });
        });

        // เมื่อเลือกอำเภอ
        $('#district').on('change', function() {
            const selectedProvince = $('#province').val();
            const selectedDistrict = $(this).val();

            // ล้าง Dropdown ตำบล
            $('#subdistrict').empty().append(new Option('เลือกตำบล', '')).prop('disabled', !selectedDistrict);

            // สร้างรายการตำบลตามอำเภอที่เลือก
            const subdistricts = data
                .filter(item => item.provinceNameTh === selectedProvince && item.districtNameTh === selectedDistrict)
                .map(item => item.subdistrictNameTh);

            subdistricts.forEach(subdistrict => {
                $('#subdistrict').append(new Option(subdistrict, subdistrict));
            });
        });
    });

    $(document).ready(function() {
        const jsonFilePath = '/thailand.json'; // เส้นทางไปยังไฟล์ JSON ของคุณ

        let data = [];

        // ดึงข้อมูล JSON
        $.getJSON(jsonFilePath, function(response) {
            data = response;

            // สร้างรายการจังหวัด
            const provinces = [...new Set(data.map(item => item.provinceNameTh))];
            provinces.forEach(province => {
                $('#province1').append(new Option(province, province));
            });
        });

        // เมื่อเลือกจังหวัด
        $('#province1').on('change', function() {
            const selectedProvince = $(this).val();

            // ล้าง Dropdown อำเภอและตำบล
            $('#district1').empty().append(new Option('เลือกอำเภอ', '')).prop('disabled', !selectedProvince);
            $('#subdistrict1').empty().append(new Option('เลือกตำบล', '')).prop('disabled', true);

            // สร้างรายการอำเภอตามจังหวัดที่เลือก
            const districts = [
                ...new Set(
                    data
                    .filter(item => item.provinceNameTh === selectedProvince)
                    .map(item => item.districtNameTh)
                )
            ];
            districts.forEach(district => {
                $('#district1').append(new Option(district, district));
            });
        });

        // เมื่อเลือกอำเภอ
        $('#district1').on('change', function() {
            const selectedProvince = $('#province1').val();
            const selectedDistrict = $(this).val();

            // ล้าง Dropdown ตำบล
            $('#subdistrict1').empty().append(new Option('เลือกตำบล', '')).prop('disabled', !selectedDistrict);

            // สร้างรายการตำบลตามอำเภอที่เลือก
            const subdistricts = data
                .filter(item => item.provinceNameTh === selectedProvince && item.districtNameTh === selectedDistrict)
                .map(item => item.subdistrictNameTh);

            subdistricts.forEach(subdistrict => {
                $('#subdistrict1').append(new Option(subdistrict, subdistrict));
            });
        });
    });
</script>
<div class="form-container my-3">
    <div class="step-navigation">
        <div class="step-item active" id="nav-step1">
            <a class="step-item-link" href="#!">1</a>
            <p>Step 1</p>
        </div>
        <div class="step-item" id="nav-step2">
            <a class="step-item-link" href="#!">2</a>
            <p>Step 2</p>
        </div>
    </div>

    <form id="multi-step-form" action="<?= site_url('user/save_student') ?>" method="post" enctype="multipart/form-data">
        <!-- Step 1 -->
        <div class="step active" id="step1">
            <h3>Step 1: ข้อมูลส่วนตัว</h3>
            <hr>
            <div class="form-row">
                <div class="form-group col-2">
                    <label for="title">คำนำหน้า:</label>
                    <select id="title" name="title" class="form-control" required>
                        <option value="" disabled selected>กรุณาเลือกคำนำหน้า</option>
                        <option value="นาย">นาย</option>
                        <option value="นาง">นาง</option>
                        <option value="นางสาว">นางสาว</option>
                        <!-- เพิ่มคำนำหน้าชื่ออื่น ๆ ตามต้องการ -->
                    </select>
                </div>
                <div class="form-group col-5">
                    <label for="firstName">ชื่อ:</label>
                    <input type="text" id="firstName" name="firstName" class="form-control" placeholder="กรุณากรอกชื่อ" required>
                </div>
                <div class="form-group col-5">
                    <label for="lastName">นามสกุล:</label>
                    <input type="text" id="lastName" name="lastName" class="form-control" placeholder="กรุณากรอกนามสกุล" required>
                </div>
            </div>
            <div class="form-group"> <label>เพศ:</label>
                <div class="form-check form-check-inline"> <input class="form-check-input" type="radio" id="genderMale" name="gender" value="ชาย" required>
                    <label class="form-check-label" for="genderMale">ชาย</label>
                </div>
                <div class="form-check form-check-inline"> <input class="form-check-input" type="radio" id="genderFemale" name="gender" value="หญิง" required>
                    <label class="form-check-label" for="genderFemale">หญิง</label>
                </div>
            </div>
            <div class="form-group">
                <label for="nationnalid">หมายเลขบัตรประชาชน:</label>
                <input type="text" id="nationnalid" name="nationnalid" class="form-control" maxlength="13" placeholder="กรุณากรอกหมายเลขบัตรประชาชน" required>
            </div>
            <div class="form-group">
                <label for="backid">เลขหลังบัตร:</label>
                <input type="text" id="backid" name="backid" class="form-control" style="text-transform:uppercase" maxlength="14" placeholder="กรุณากรอกเลขหลังบัตร" required>
            </div>

            <!-- จัดรูปแบบการพิมพ์เลขหลังบัตรประชาชน -->
            <script>
                document.getElementById('backid').addEventListener('input', function(e) {
                    let value = e.target.value.toUpperCase().replace(/[^A-Z0-9]/g, ''); // เอาเฉพาะตัวอักษรและตัวเลข
                    let formattedValue = '';

                    if (value.length > 3) {
                        formattedValue = value.substring(0, 3) + '-';
                        if (value.length > 10) {
                            formattedValue += value.substring(3, 10) + '-';
                            formattedValue += value.substring(10, 14);
                        } else {
                            formattedValue += value.substring(3, 10);
                        }
                    } else {
                        formattedValue = value;
                    }

                    e.target.value = formattedValue; // แสดงผลลัพธ์
                });
            </script>
            <!-- ปิด -->
            <h6>วัน/เดือน/ปีเกิด:</h6>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="day">วัน:</label>
                    <select id="day" name="day" class="form-control" required>
                        <option value="">เลือกวัน</option>
                        <?php for ($i = 1; $i <= 31; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="month">เดือน:</label>
                    <select id="month" name="month" class="form-control" required>
                        <option value="">เลือกเดือน</option>
                        <option value="1">มกราคม</option>
                        <option value="2">กุมภาพันธ์</option>
                        <option value="3">มีนาคม</option>
                        <option value="4">เมษายน</option>
                        <option value="5">พฤษภาคม</option>
                        <option value="6">มิถุนายน</option>
                        <option value="7">กรกฎาคม</option>
                        <option value="8">สิงหาคม</option>
                        <option value="9">กันยายน</option>
                        <option value="10">ตุลาคม</option>
                        <option value="11">พฤศจิกายน</option>
                        <option value="12">ธันวาคม</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="year">ปี พ.ศ.:</label>
                    <select id="year" name="year" class="form-control" required>
                        <option value="">เลือกปี</option>
                        <?php for ($i = (date('Y') + 543); $i >= 2463; $i--): // เปลี่ยนปีตามที่ต้องการ 
                        ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <input type="hidden" id="birth" name="birth">
            <div class="form-group">
                <label for="age">อายุ:</label>
                <input type="text" id="age" name="age" class="form-control" readonly>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
            <script>
                function updateBirthDate() {
                    var day = document.getElementById('day').value;
                    var month = document.getElementById('month').value;
                    var year = document.getElementById('year').value;
                    if (day && month && year) {
                        year = parseInt(year) - 543; // แปลงจาก พ.ศ. เป็น ค.ศ.
                        document.getElementById('birth').value = year + '-' + month + '-' + day;
                        calculateAge();
                    }
                }

                function calculateAge() {
                    var birthDate = new Date(document.getElementById('birth').value);
                    var today = new Date();
                    var age = today.getFullYear() - birthDate.getFullYear();
                    var month = today.getMonth() - birthDate.getMonth();

                    if (month < 0 || (month === 0 && today.getDate() < birthDate.getDate())) {
                        age--;
                    }

                    document.getElementById('age').value = age;

                    if (age >= 55) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'แจ้งเตือน',
                            text: 'อายุของคุณเท่ากับหรือเกิน 55 ปี'
                        });
                    }
                }

                document.getElementById('day').addEventListener('change', updateBirthDate);
                document.getElementById('month').addEventListener('change', updateBirthDate);
                document.getElementById('year').addEventListener('change', updateBirthDate);
            </script>

            <div class="form-row">
                <div class="form-group col">
                    <label for="educate">ระดับการศึกษาปัจจุบัน:</label>
                    <select id="educate" name="education_level" class="form-control" required>
                        <option value="" selected disabled>กรุณาเลือกระดับการศึกษา</option>
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
                <div class="form-group col">
                    <label for="school">สถาบันที่กำลังศึกษา:</label>
                    <input type="text" id="school" name="school" class="form-control"
                        placeholder="กรุณากรอกสถาบันที่จบ" required>
                </div>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control"
                    placeholder="กรุณากรอก E-mail" required>
            </div>
            <div class="form-group">
                <label for="profile_pic">แนบไฟล์รูปภาพหน้าตรง:</label>
                <input type="file" id="imageUpload2" name="profile_pic" class="form-control" accept="image/*" onchange="previewImage2(event)">
            </div>

            <!-- Container for Preview Image and Text -->
            <div class="form-group" id="previewContainer2" style="display: none;">
                <label>ตัวอย่างภาพ:</label>
                <img id="preview2" src="" alt="Image Preview" style="max-width: 300px; height: auto;">
            </div>

            <!-- JavaScript to Show/Hide Preview -->
            <script>
                function previewImage2(event) {
                    const file = event.target.files[0];
                    const previewContainer = document.getElementById('previewContainer2');
                    const imgElement = document.getElementById('preview2');

                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            imgElement.src = e.target.result; // Set image source to the selected file
                            previewContainer.style.display = 'block'; // Show the image preview
                        };
                        reader.readAsDataURL(file); // Read the image as a data URL
                    } else {
                        previewContainer.style.display = 'none'; // Hide if no file is selected
                    }
                }
            </script>

            <fieldset>
                <legend>ข้อมูลที่อยู่</legend>
                <div class="form-group">
                    <label for="address">ที่อยู่ที่สามารติดต่อได้:</label>
                    <textarea class="form-control" name="address" rows="2"></textarea>
                </div>
                <div class="form-group">
                    <label for="province">จังหวัด:</label>
                    <select id="province" name="province" class="form-control">
                        <option value="">เลือกจังหวัด</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="district">อำเภอ:</label>
                    <select id="district" name="district" class="form-control" disabled>
                        <option value="">เลือกอำเภอ</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="subdistrict">ตำบล:</label>
                    <select id="subdistrict" name="subdistrict" class="form-control" disabled>
                        <option value="">เลือกตำบล</option>
                    </select>
                </div>
            </fieldset>

            <div class="form-group">
                <label for="telephone">เบอร์โทร:</label>
                <input type="text" id="telephone" name="telephone" class="form-control" maxlength="12" placeholder="กรุณากรอกเบอร์ที่สามารถติดต่อได้" required>
            </div>

            <script>
                document.getElementById('telephone').addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, ''); // เอาเฉพาะตัวเลข
                    let formattedValue = '';

                    if (value.length > 3) {
                        formattedValue = value.substring(0, 3) + '-';
                        if (value.length > 6) {
                            formattedValue += value.substring(3, 6) + '-';
                            formattedValue += value.substring(6, 10);
                        } else {
                            formattedValue += value.substring(3, 6);
                        }
                    } else {
                        formattedValue = value;
                    }

                    e.target.value = formattedValue; // แสดงผลลัพธ์
                });
            </script>

            <button type="button" class="btn btn-primary next-step w-100" data-next="step2">ถัดไป</button>
        </div>

        <!-- Step 2 -->
        <div class="step" id="step2">
            <h3>Step 2: ข้อมูลประวัติการทำงาน</h3>
            <hr>
            <div class="form-group">
                <label for="position">ระบุตำแหน่งงานที่ต้องการ :</label>
                <input type="text" id="position" name="position" class="form-control" placeholder="ระบุตำแหน่งงานที่ต้องการ" required>
            </div>
            <div class="form-group">
                <label for="salary">ระบุค่าตอบแทนที่ต้องการ :</label>
                <input type="text" id="salary" name="salary" class="form-control" placeholder="ระบุค่าตอบแทนที่ต้องการ" required>
            </div>
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="consentCheckbox" name="consentCheckbox" required>
                    <input type="hidden" id="user_type" name="user_type" value="นักเรียนนักศึกษา">
                    <label class="form-check-label" for="consentCheckbox">
                        ยินยอมเปิดเผยข้อมูลให้กับนายจ้าง/สถานประกอบการ เพื่อนำประวัติการขึ้นทะเบียนหางานให้ทางสถานประกอบการพิจารณาคัดเลือก
                        <br>
                        <em>*ซึ่งข้อมูลของท่านจะถูกเก็บเป็นความลับ*</em>
                        โดยระบบ SmartJob Demo เพื่อใช้เป็นตัวอย่าง portfolio และจะถูกลบออกจากระบบโดยอัตโนมัติภายใน 90 วัน
                    </label>
                </div>
            </div>
            <button type="button" class="btn btn-secondary prev-step w-100 mb-2" data-prev="step1">ย้อนกลับ</button>
            <button type="submit" class="btn btn-success w-100">บันทึกข้อมูล</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
