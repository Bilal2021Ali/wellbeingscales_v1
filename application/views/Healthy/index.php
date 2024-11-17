<style>
    .bar-bg {
        background: linear-gradient(90deg, #7358a3 0%, #7dbce3 100%);
    }

    .steps .btn {
        cursor: default;
        background: #f3f3f3;
    }

    .steps .btn.clickable {
        background: #7dbbe2;
        cursor: pointer;
    }


    .bg-table-bar th {
        border: 0px;
    }

    .btn-gray, .btn-gray:hover, .btn-gray:active, .btn-gray:focus {
        background: #f3f3f3;
        color: #878787;
        width: 100%;
        margin-left: 2px;
        border: 0px !important;
        outline: none !important;
        box-shadow: 0 0 0 0.15rem rgb(255 255 255 / 25%) !important;
    }

    tr:nth-child(even) {
        background-color: #fcfafa;
    }

    tr {
        border-bottom: 2px solid #d0d0d0;
    }

    .action-btn.active {
        background: #7dbbe2;
        color: #fff;
    }

    .card.step {
        display: none;
    }

    .card.step.active {
        display: block;
    }

    a.lang-element {
        padding: 10px;
        color: #666;
        display: flex;
        justify-content: flex-start;
    }

    .lang-icon {
        height: 20px;
        width: 20px;
        text-align: center;
        margin-right: 10px;
        border-radius: 100%;
        display: flex;
        flex-direction: column-reverse;
        justify-content: center;
        align-items: center;
        color: #fff;
    }

    .on-active-warning.active {
        background-color: rgba(241, 180, 76, .25);
        border-color: rgba(241, 180, 76, .25);
        color: #f1b44c;
    }

    .on-active-success.active {
        background-color: rgba(52, 195, 143, .25);
        border-color: rgba(52, 195, 143, .25);
        color: #34c38f;
    }

    .on-active-danger.active {
        background-color: rgba(244, 106, 106, .25);
        border-color: rgba(244, 106, 106, .25);
        color: #f46a6a;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <?php $key = 0; ?>
        <?php foreach ($categories as $CID => $category) { ?>
            <?php $key++; ?>
            <div class="card step step-<?= $key ?> <?= $key == 1 ? "active" : "" ?>">
                <div class="card-body" style="overflow: auto;">
                    <p><?= $category['description'] ?></p>
                    <table style="border-collapse: collapse !important;table-layout: fixed">
                        <thead class="bar-bg text-white text-center">
                        <th><?= $key ?></th>
                        +
                        <th><?= ucfirst($category['_title'] ?? '') ?></th>
                        <th><?= $this->lang->line('current-in-place') ?></th>
                        <th><?= $this->lang->line('priority') ?></th>
                        </thead>
                        <tbody>
                        <?php foreach ($category['questions'] as $Qsn => $question) { ?>
                            <tr>
                                <td><?= $key . "." . ($Qsn + 1) ?></td>
                                <td style="word-wrap: break-word; white-space: normal;">
                                    <?= $question['QTitle'] ?>
                                </td>
                                <td>
                                    <div class="d-flex w-100 actions-container"
                                         data-category="<?= $CID ?>"
                                         data-question="<?= $question['Qid'] ?>">
                                        <?php foreach ($choices as $s => $choice) { ?>
                                            <button class="btn btn-gray choice-btn action-btn <?= $s == 0 ? "active" : "" ?> on-active-<?= $classesNames[$s] ?? '' ?>"
                                                    data-key="<?= $choice['id'] ?>"
                                                    data-value="<?= round($counters[$s] / sizeof($category['questions']), 2) ?>"><?= $choice[$activeLanguage . '_title'] ?></button>
                                        <?php } ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex w-100 actions-container"
                                         data-category="<?= $CID ?>"
                                         data-question="<?= $question['Qid'] ?>">
                                        <?php foreach ($priorities as $s => $priority) { ?>
                                            <button class="btn btn-gray priority-btn action-btn <?= $s == 0 ? "active" : "" ?> on-active-<?= $classesNames[$s] ?? '' ?>"
                                                    data-key="<?= $priority['id'] ?>"
                                                    data-value="<?= round($counters[$s] / sizeof($category['questions']), 2) ?>"><?= $priority[$activeLanguage . '_title'] ?></button>
                                        <?php } ?>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <div class="w-100 d-flex justify-content-center">
                        <div class="d-flex steps">
                            <button class="<?= ($key > 1) ? "clickable" : "" ?> btn text-blue mr-1 back"
                                    data-to="<?= $key - 1 ?>">
                                <?= $this->lang->line('back') ?>
                            </button>
                            <button class="btn text-blue mr-1 submit">
                                <?= $this->lang->line('submit') ?>
                            </button>
                            <button data-to="<?= $key + 1 ?>"
                                    class="<?= ($key < sizeof($categories)) ? "clickable" : "" ?> btn text-blue next">
                                <?= $this->lang->line('next') ?>
                            </button>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-6">
                            <div class="row">
                                <?php foreach ($languages as $code => $language) { ?>
                                    <?php $urlArr = explode('/', current_url());
                                    array_pop($urlArr) ?>
                                    <div class="col-3">
                                        <a class="lang-element"
                                           href="<?= empty($activeLanguage) ? current_url() . "/" . $code : implode('/', $urlArr) . '/' . $code; ?>">
                                            <div>
                                                <span class="bg-success lang-icon">
                                                    <i class="uil uil-angle-right"></i>
                                                </span>
                                            </div>
                                            <?= ucfirst($language['name']) ?>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>
</div>
<script>
    const generatingTheResults = '<?= $this->lang->line('generating-the-results') ?>';
    <?php $urlArr = explode('/', current_url()); array_pop($urlArr) ?>
    $(".ar_change").attr('href', '<?= implode('/', $urlArr) . '/' . ($activeLanguage == 'en' ? 'ar' : 'en'); ?>');
    const activeLanguage = "<?= $activeLanguage ?? 'en' ?>";
</script>
<script type="module" src="<?= base_url('assets/js/Healthy.js') ?>"></script>