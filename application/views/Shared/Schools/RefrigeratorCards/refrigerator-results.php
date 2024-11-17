<?php
/**
 * @var array<\App\DTOs\RefrigeratorResultDTO> $results
 */
?>
<style>
    .device-status {
        display: inline-block;
        padding: 5px;
        border-width: 1px;
        border-style: solid;
    }

    .device-status span {
        color: white;
    }
</style>

<?php if (blank($results)) { ?>
    <p>No data available.</p>
<?php } ?>


<div class="row">
    <?php foreach ($results as $result) { ?>
        <div class="col-md-2 mb-4">
            <?php $this->load->view("Shared/Schools/RefrigeratorCards/inc/result", ['result' => $result]) ?>
        </div>
    <?php } ?>
</div>
