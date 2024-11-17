<?php
/**
 * @var string $icon
 * @var string $title
 * @var string $value
 */
?>
<div class="card tab-component">
    <div class="card-body d-flex">
        <div class="icon-container">
            <i class="<?= (str_contains($icon, " ") ? "" : "fa fa-").  $icon ?>"></i>
        </div>
        <div>
            <h3><?= $title ?></h3>
            <p><?= $value ?></p>
        </div>
    </div>
</div>