<style>
    .bg-primary {
        background-color: #0f766e !important;
    }

    .navbar-brand img {
        vertical-align: middle;
    }
</style>

<nav class="navbar navbar-expand navbar-dark bg-primary topbar mb-4 static-top shadow">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= site_url('user') ?>">
            <img src="<?= base_url('img/brand-mark.svg') ?>" alt="SmartJob Demo logo" style="width: 40px; height: 40px; margin-right: 10px;">
            SmartJob Demo
        </a>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('user') ?>">
                    <i class="fas fa-home fa-sm fa-fw mr-2"></i>
                    Home
                </a>
            </li>
        </ul>
    </div>
</nav>
