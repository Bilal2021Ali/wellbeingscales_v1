<?php
/**
 * @var array $students
 */
?>

<?php foreach ($students as $student) { ?>
    <div class="d-flex mb-2 align-items-center">
        <img src="<?= avatar($student['avatar']) ?>" class="rounded avatar-lg mr-2" alt="<?= $student['name'] ?>">
        <div>
            <p class="mb-0"><b><?= __('name') ?></b> : <?= $student['name'] ?></p>
            <p class="mb-0"><b><?= __('class') ?></b> : <?= $student['class'] ?></p>
            <p class="mb-0"><b><?= __('DOP') ?></b> : <?= $student['dop'] ?></p>
            <p class="mb-0"><b><?= __('email') ?></b> : <?= $student['email'] ?></p>
        </div>
    </div>
<?php } ?>
