<div class="header">
    <h1><?= $name ?></h1>
    <p><?= $job_title ?></p>
</div>
<div class="content">
    <div>
        <p><strong>Contact</strong><br>
        Email: <?= $contact['email'] ?><br>
        Phone: <?= $contact['phone'] ?><br>
        Location: <?= $contact['location'] ?></p>
    </div>
    <div>
        <p class="section-title">Skills</p>
        <ul>
            <?php foreach ($skills as $skill): ?>
                <li><?= $skill ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div>
        <p class="section-title">Languages</p>
        <ul>
            <?php foreach ($languages as $lang => $level): ?>
                <li><?= $lang ?>: <?= $level ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div>
        <p class="section-title">Education</p>
        <table>
            <?php foreach ($education as $edu): ?>
                <tr>
                    <td><strong><?= $edu['degree'] ?></strong></td>
                    <td><?= $edu['year'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>