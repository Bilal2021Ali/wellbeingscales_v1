<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <h3 class="card-title"><?= __("reports-by-status-priority") ?></h3>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <select class="form-control" name="priority-month">
                        <?php foreach ($months as $key => $month) { ?>
                            <option <?= ($key + 1) == date('m') ? "selected" : "" ?>
                                value="<?= $key + 1 ?>"><?= $month ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="pt-3" id="results_priorities"></div>
    </div>
</div>