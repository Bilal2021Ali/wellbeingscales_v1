<?php
/**
 * @var string $name
 * @var int $value
 * @var string $color
 */
?>


<div class="InfosCards">
    <div class="card" style="padding: 5px">
        <div class="card-body" style="background-color: <?= $color ?>;">
            <div>
                <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?= $value ?></span></h4>
                <p class="mb-0"><?= $name ?></p>
            </div>
        </div>
    </div>
</div>

