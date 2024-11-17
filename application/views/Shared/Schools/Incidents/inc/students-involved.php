<?php

/**
 * @var array $students
 */
?>

<div class="align-items-center d-flex">
    <?php foreach ($students as $student) { ?>
        <img src="<?= avatar($student['avatar']) ?>" alt="<?= $student['name'] ?>"
             class="avatar-xs rounded-circle" style="margin-left: -5px;border: 1px solid #fff"/>
    <?php } ?>
</div>
