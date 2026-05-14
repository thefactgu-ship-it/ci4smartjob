<style>
    .bg-primary {
        background-color: #16C47F !important;
        /* ใช้ !important หากต้องการให้บังคับเปลี่ยน */
    }
</style>
<!-- Topbar -->
<nav class="navbar navbar-expand navbar-dark bg-primary topbar mb-4 static-top shadow">

    <div class="container-fluid">
        <!-- Logo หรือ ชื่อเว็บไซต์ -->
        <a class="navbar-brand" href="#">
            <img src="<?= base_url('img/doe.png') ?>" alt="Logo" style="width: 40px; height: 100%; margin-right: 10px;">
            Krabi Department of Employment
        </a>

        <!-- เมนูที่เพิ่มเข้าไป -->
        <ul class="navbar-nav ml-auto">
            <!-- ตัวอย่างเมนูแรก -->
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('user') ?>">
                    <i class="fas fa-home fa-sm fa-fw mr-2"></i>
                    Home
                </a>
            </li>

        </ul>
    </div>

</nav>
<!-- End of Topbar -->