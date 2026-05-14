<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('home/default') ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-file-contract"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Job Vista</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('home/default') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        ประชาชนทั่วไป
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item <?= (current_url() == site_url('home') || current_url() == site_url('home/emtyjob') || current_url() == site_url('home/submitResume') || current_url() == site_url('home/promote') || current_url() == site_url('home/report')) ? 'active' : '' ?>">
        <a class="nav-link <?= (current_url() == site_url('home') || current_url() == site_url('home/emtyjob') || current_url() == site_url('home/submitResume') || current_url() == site_url('home/promote') || current_url() == site_url('home/report')) ? '' : 'collapsed' ?>" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="<?= (current_url() == site_url('home') || current_url() == site_url('home/emtyjob') || current_url() == site_url('home/submitResume') || current_url() == site_url('home/promote') || current_url() == site_url('home/report')) ? 'true' : 'false' ?>" aria-controls="collapseTwo">
            <i class="fas fa-users"></i>
            <span>ขึ้นทะเบียน/ฝากประวัติ</span>
        </a>
        <div id="collapseTwo" class="collapse <?= (current_url() == site_url('home') || current_url() == site_url('home/emtyjob') || current_url() == site_url('home/submitResume') || current_url() == site_url('home/promote') || current_url() == site_url('home/report')) ? 'show' : '' ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">ขึ้นทะเบียน/ฝากประวัติ:</h6>
                <a class="collapse-item <?= (current_url() == site_url('home/emtyjob')) ? 'active' : '' ?>" href="<?= site_url('home/emtyjob') ?>">ขึ้นทะเบียนว่างงาน</a>
                <a class="collapse-item <?= (current_url() == site_url('home/submitResume')) ? 'active' : '' ?>" href="<?= site_url('home/submitResume') ?>">ฝากประวัติ</a>
                <a class="collapse-item <?= (current_url() == site_url('home/promote')) ? 'active' : '' ?>" href="<?= site_url('home/promote') ?>">ปรึกษาด้านอาชีพ</a>
                <a class="collapse-item <?= (current_url() == site_url('home/report')) ? 'active' : '' ?>" href="<?= site_url('home/report') ?>">รายงาน</a>
            </div>
        </div>
    </li>



    <!-- Heading -->
    <div class="sidebar-heading">
        นักเรียนนักศึกษา
    </div>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item <?= (strpos(current_url(), 'student') !== false) ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-user-graduate"></i>
            <span>สมัครงาน/ฝากประวัติ</span>
        </a>
        <div id="collapseUtilities" class="collapse <?= (strpos(current_url(), 'student') !== false) ? 'show' : '' ?>" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">สมัครงาน/ฝากประวัติ:</h6>
                <a class="collapse-item <?= (strpos(current_url(), 'student/list') !== false) ? 'active' : '' ?>" href="<?= site_url('student/list') ?>">ฝากประวัติ</a>
            </div>
        </div>
    </li>

    <!-- Heading -->
    <div class="sidebar-heading">
        นายจ้าง/สถานประกอบการ
    </div>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item ">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCompany"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-building"></i>
            <span>คัดลอกประวัติผู้สมัครงาน</span>
        </a>
        <div id="collapseCompany" class="collapse"  aria-labelledby="headingCompany"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">สมัครงาน/ฝากประวัติ:</h6>
                <a class="collapse-item " href="<?=site_url('company/addCompany') ?>">เพิ่มข้อมูลนายจ้าง</a>
                <a class="collapse-item " href="<?=site_url('company/company_list') ?>">คัดลอกประวัติ</a>
                <a class="collapse-item " href="">ประกาศตำแหน่งงานว่าง</a>
            </div>
        </div>
    </li>


    <?php $session = session(); ?>
    <?php if ($session->get('username') == 'admin'): ?>
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Addons
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item <?= (current_url() == site_url('employeecontroller/create') || current_url() == site_url('employeecontroller/employee-list')) ? 'active' : '' ?>">
            <a class="nav-link <?= (current_url() == site_url('employeecontroller/create') || current_url() == site_url('employeecontroller/employee-list')) ? '' : 'collapsed' ?>" href="#" data-toggle="collapse" data-target="#collapsePages"
                aria-expanded="<?= (current_url() == site_url('employeecontroller/create') || current_url() == site_url('employeecontroller/employee-list')) ? 'true' : 'false' ?>" aria-controls="collapsePages">
                <i class="fas fa-users-cog"></i>
                <span>จัดการผู้ใช้งาน</span>
            </a>
            <div id="collapsePages" class="collapse <?= (current_url() == site_url('employeecontroller/create') || current_url() == site_url('employeecontroller/employee-list')) ? 'show' : '' ?>" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">จัดการผู้ใช้งาน:</h6>
                    <a class="collapse-item <?= (current_url() == site_url('employeecontroller/create')) ? 'active' : '' ?>" href="<?= site_url('employeecontroller/create') ?>">เพิ่มผู้ใช้งาน</a>
                    <a class="collapse-item <?= (current_url() == site_url('employeecontroller/employee-list')) ? 'active' : '' ?>" href="<?= site_url('employeecontroller/employee-list') ?>">รายการผู้ใช้งาน</a>
                </div>
            </div>
        </li>
    <?php endif; ?>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>