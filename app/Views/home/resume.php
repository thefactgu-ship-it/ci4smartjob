<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<!-- Begin Page Content -->
 
<style>
    /* ตกแต่ง Resume ให้สวยงาม */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    .container {
        width: 600px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ccc;
    }

    .header {
        text-align: center;
    }

    .header h1 {
        margin: 0;
    }

    .section {
        margin-top: 20px;
    }

    .section h2 {
        margin-bottom: 10px;
    }

    .section p {
        margin: 5px 0;
    }
</style>

<div class="header">
    <h1>Resume</h1>
    <h2><?= esc($personalInfo['first_name']) . ' ' . esc($personalInfo['last_name']) ?></h2>
</div>

<div class="section">
    <h2>Personal Information</h2>
    <p><strong>National ID:</strong> <?= esc($personalInfo['national_id']) ?></p>
    <p><strong>Date of Birth:</strong> <?= esc($personalInfo['birth']) ?></p>
    <p><strong>Education Level:</strong> <?= esc($personalInfo['education_level']) ?></p>
    <p><strong>School:</strong> <?= esc($personalInfo['school']) ?></p>
</div>

<div class="section">
    <h2>Contact Information</h2>
    <p><strong>Address:</strong> <?= esc($personalInfo['address']) ?></p>
    <p><strong>Province:</strong> <?= esc($personalInfo['province']) ?></p>
    <p><strong>Telephone:</strong> <?= esc($personalInfo['telephone']) ?></p>
</div>
<!-- End Page Content -->

<?= $this->endSection() ?>

<?= $this->include('layout/scripts') ?>