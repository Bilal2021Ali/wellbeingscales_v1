<style>
    .choice {
        margin-top: 10px;
        min-height: 10px;
        color: #fff;
    }

    .start-b-r {
        border-top-left-radius: 20px;
        border-bottom-left-radius: 20px;
    }

    .end-b-r {
        border-top-right-radius: 20px;
        border-bottom-right-radius: 20px;
    }

    .card {
        box-shadow: 0 0px 0px rgb(15 34 58 / 12%);
    }

    .rowOfChoices .choice:first-child {
        border-top-left-radius: 20px;
        border-bottom-left-radius: 20px;
    }

    .rowOfChoices .choice:last-child {
        border-top-right-radius: 20px;
        border-bottom-right-radius: 20px;
    }

    .default-choices-colors .choice:last-child {
        border-top-right-radius: 20px;
        border-bottom-right-radius: 20px;
    }

    .img-icon {
        width: 55px;
        margin-right: 10px;
    }

    .bs-popover-top > .arrow::after,
    .bs-popover-auto[x-placement^="top"] > .arrow::after {
        border-top-color: #0eacd8 !important;
    }

    .popover-body {
        background: #0eacd8 !important;
        color: #fff;
    }

    .popover-header {
        color: #fff;
        background-color: #98d077;
    }

    .choice {
        cursor: pointer;
    }

    .choice-element {
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
    }

    .position-relative {
        position: relative;
    }

    .position-relative .card-body {
        padding-bottom: 60px;
    }

    .bottom-actions {
        position: absolute;
        right: 10px;
        bottom: 10px;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <?php if ($showFilters) $this->load->view("EN/schools/climate/inc/filters" , ['disabled' => ['category']]) ?>
        <div class="card position-relative">
            <div class="card-body">
                <div class="col-lg-12 px-5 default-choices-colors" style="display: grid;align-items: center;">
                    <div class="row">
                        <?php foreach ($choices as $sn => $choice) { ?>
                            <div class="text-center col choice-element">
                                <img width="50px" alt=""
                                     src="<?= base_url('uploads/climate_choices_icons/' . $choice['icon_en']); ?>">
                                <span><?= $choice['title_' . strtolower($language)] ?></span>
                                <span><?= $choice['selects'] ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="row">
                        <?php foreach ($choices as $sn => $used_choice) { ?>
                            <div class="choice col p-2 <?= $sn == 0 ? 'start-b-r' : '' ?>"
                                 style="background-color: <?= $colors[$sn]; ?>"></div>
                        <?php } ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 col-xl-4 mt-3 offset-4">
                        <div class="text-center" dir="ltr">
                            <h5 class="font-size-14 mb-3"><?= $survey->{"set_name_" . strtolower($language)} ?></h5>
                            <input class="knob" data-width="180" data-height="180" data-linecap=round
                                   data-fgColor="#0eacd8"
                                   value="<?= round($value, 1) ?>" data-skin="tron" data-angleOffset="120"
                                   data-readOnly=true data-thickness=".3"/>
                        </div>
                    </div>
                </div>

                <div class="bottom-actions">
                    <a class="btn btn-primary" href="<?= current_url() . "?withFilters" ?>">
                        <i class="uil uil-filter"></i>
                        <?= $this->lang->line('by-filters') ?>
                    </a>
                    <a class="btn btn-info"
                       href="<?= base_url($language . "/schools/climate-users-results/" . $id) ?>">
                        <i class="uil uil-user"></i>
                        <?= $this->lang->line('users-list') ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url("assets/libs/jquery-knob/jquery.knob.min.js") ?>"></script>
<script>
    $(function () {
        $(".knob").knob();
        $('.knob').each(function () {
            $(this).val($(this).val() + "%");
        });
    });
</script>