<?= $this->extend('user/base') ?>

<?= $this->section('content') ?>

<style>
    .card-link {
        color: #0f766e;
        text-decoration: none;
    }

    .card-link:hover {
        color: #0ea5e9;
        text-decoration: underline;
    }

    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(15, 23, 42, 0.12);
    }

    .portal-logo {
        height: 160px;
        width: auto;
    }
</style>

<div class="avatar text-center">
    <img class="avatar-img img-fluid portal-logo" src="<?= base_url('img/brand-mark.svg') ?>" alt="SmartJob Demo">
</div>

<h1 class="text-center mt-3">SmartJob Demo - Employment Management Portal</h1>
<p class="text-center text-muted mb-4">Portfolio demo for job seeker registration, applicant tracking, company matching, and staff review workflows.</p>

<div class="row mt-3">
    <div class="col-md-4">
        <a href="<?= site_url('user/form_test'); ?>" class="card-link">
            <div class="card">
                <img class="card-img-top img-fluid" src="<?= base_url('img/workoff.png') ?>" alt="Unemployment registration">
                <div class="card-body">
                    <h5 class="card-title">Unemployment Registration</h5>
                    <p class="card-text">Register job seekers and store applicant profile information for review.</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="<?= site_url('user/form_history'); ?>" class="card-link">
            <div class="card">
                <img class="card-img-top img-fluid" src="<?= base_url('img/history.png') ?>" alt="Resume submission">
                <div class="card-body">
                    <h5 class="card-title">Resume Submission</h5>
                    <p class="card-text">Collect resume and work history data from applicants looking for opportunities.</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="<?= site_url('user/form_part_time'); ?>" class="card-link">
            <div class="card">
                <img class="card-img-top img-fluid" src="<?= base_url('img/schooljob.png') ?>" alt="Student job application">
                <div class="card-body">
                    <h5 class="card-title">Student Job Application</h5>
                    <p class="card-text">Support student applicants who want part-time or seasonal work.</p>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="row mt-3 mb-3">
    <div class="col-md-4">
        <a href="<?= site_url('company/addCompany') ?>" class="card-link">
            <div class="card">
                <img class="card-img-top img-fluid" src="<?= base_url('img/companyfind.png') ?>" alt="Company management">
                <div class="card-body">
                    <h5 class="card-title">Company Management</h5>
                    <p class="card-text">Add company records and match selected applicants with employers.</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="<?= base_url('/login') ?>" class="card-link">
            <div class="card">
                <img class="card-img-top img-fluid" src="<?= base_url('img/officer.png') ?>" alt="Staff login">
                <div class="card-body">
                    <h5 class="card-title">Staff Login</h5>
                    <p class="card-text">Access the staff dashboard to review applicants, queues, companies, and reports.</p>
                </div>
            </div>
        </a>
    </div>
</div>

<?= $this->endSection() ?>
