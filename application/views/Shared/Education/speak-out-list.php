<style>
    .readmore {
        color: var(--blue);
        cursor: pointer;
    }

    .showmedia {
        cursor: pointer;
        font-size: 30px;
        color: #4caf50;
    }

    .comments {
        font-size: 30px;
    }

    .badge {
        padding: 10px;
        font-size: 13px;
        text-align: center;
        width: 100%;
    }

    .badge.bg-dark {
        background-color: #a8a8a8 !important;
        color: #fff !important;
    }

    .badge.bg-success {
        background-color: #7cd992 !important;
        color: #fff !important;
    }

    .badge.bg-warning {
        background-color: #f7e463 !important;
        color: #fff !important;
    }

    .badge.bg-danger {
        background-color: #eb6161 !important;
        color: #fff !important;
    }
</style>
<?php $closed = array(); ?>
<div class="modal fade showmedialist" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= __('attachments') ?> :</h5>
                <button type="button" class="btn btn-light btn-rounded waves-effect" data-dismiss="modal"
                        aria-label="Close">x
                </button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
<h4 class="card-title"
    style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
    CH 100: <?= __('list-of-students') ?></h4>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"><?= __('open-concerns') ?></h3>
                <div class="col-12 overflow-auto">
                    <hr>
                    <table class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                        <th>#</th>
                        <th><?= __("img") ?></th>
                        <th><?= __("name") ?></th>
                        <th><?= __("date") ?></th>
                        <th><?= __("report-group") ?></th>
                        <th><?= __("report-type") ?></th>
                        <th><?= __("complaint") ?></th>
                        <th><?= __("attachments") ?></th>
                        <?php if (!$isMinistry) { ?>
                            <th><?= __("actions") ?></th>
                        <?php } ?>
                        <!-- <th>--><?php //= __("status") ?><!--</th>-->
                        <th><?= __("priority") ?></th>
                        <?php if (!$isMinistry) { ?>
                            <th><?= __("closed") ?></th>
                        <?php } ?>
                        </thead>
                        <tbody>
                        <?php foreach ($reports as $sn => $report) { ?>
                            <?php if (!$report['closed']) { ?>
                                <tr>
                                    <td><?= $sn + 1 ?></td>
                                    <td class="text-center">
                                        <img
                                                src="<?= base_url("uploads/avatars/") . (empty($report['useravatar']) || $report['show_user_name'] == 0 ? "default_avatar.jpg" : $report['useravatar']) ?>"
                                                class="img-thumbnail rounded-circle avatar-sm" alt="">
                                    </td>
                                    <td><?= intval($report['show_user_name']) == 1 ? $report['username'] : __("anonymous") ?></td>
                                    <td><?= $report['reportDateAndTime'] ?></td>
                                    <td><?= $report['groupName'] ?></td>
                                    <td><?= $report['reportType'] ?></td>
                                    <td>
                                        <?= character_limiter($report['description'], 50, '<span class="readmore" data-report-id="' . $report['id'] . '" data-lang="en" data-toggle="modal" data-target=".showthedesc" > <b>' . __("read-more") . '</b></span>'); ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($report['Media'] > 0) { ?>
                                            <i class="uil uil-cloud-database-tree showmedia" data-toggle="modal"
                                               data-target=".showmedialist"
                                               data-original-title="show attachments" data-placement="top"
                                               data-toggle="tooltip" data-report-id="<?= $report['id'] ?>"></i>
                                        <?php } else { ?>
                                            <?= __("no-files") ?>
                                        <?php } ?>
                                    </td>
                                    <?php if (!$isMinistry) { ?>
                                        <td class="text-center"><a
                                                    href="<?= base_url("EN/schools/speak_out_comments/" . $report['id']) ?>"><i
                                                        class="uil uil-comment-alt-notes comments"></i></a></td>
                                    <?php } ?>
                                    <?php
                                    /**
                                     * <td class="">
                                     * <span class="badge rounded-pill status-box-<?= $report['id'] ?>"
                                     * style="background-color: <?= status($report['status'])['bg'] ?>;color: #fff">
                                     * <?= __(status($report['status'])['text']) ?>
                                     * </span>
                                     * </td>
                                     */
                                    ?>
                                    <td class="">
                                        <span class="badge rounded-pill"
                                              style="background-color: <?= priority($report['priority'])['bg'] ?>;color: #fff">
                                            <?= __(strtolower(priority($report['priority'])['text'])) ?>
                                        </span>
                                    </td>
                                    <?php if (!$isMinistry) { ?>
                                        <td>
                                            <button <?= $report['closed'] ? "disabled" : "" ?> type="button"
                                                                                               class="btn btn-warning btn-rounded waves-effect waves-light closereport"
                                                                                               data-id="<?= $report['id'] ?>">
                                                <i class="uil uil-check font-size-15"></i>
                                            </button>
                                        </td>
                                    <?php } ?>
                                </tr>
                                <?php
                            } else {
                                $closed[] = $report;
                            }
                            ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"><?= __("closed-concerns") ?></h3>
                <div class="col-12 overflow-auto">
                    <hr>
                    <table class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                        <th>#</th>
                        <th><?= __("img") ?></th>
                        <th><?= __("name") ?></th>
                        <th><?= __("date") ?></th>
                        <th><?= __("report-group") ?></th>
                        <th><?= __("report-type") ?></th>
                        <th><?= __("complaint") ?></th>
                        <th><?= __("attachments") ?></th>
                        <?php if (!$isMinistry) { ?>
                            <th><?= __("actions") ?></th>
                        <?php } ?>
                        <th><?= __("status") ?></th>
                        <th><?= __("priority") ?></th>
                        </thead>
                        <tbody>
                        <?php foreach ($closed as $sn => $report) { ?>
                            <tr>
                                <td><?= $sn + 1 ?></td>
                                <td class="text-center">
                                    <img
                                            src="<?= base_url("uploads/avatars/") . (empty($report['userAvatar']) || $report['show_user_name'] == 0 ? "default_avatar.jpg" : $report['userAvatar']) ?>"
                                            class="img-thumbnail rounded-circle avatar-sm" alt="">
                                </td>
                                <td><?= intval($report['show_user_name']) == 1 ? $report['username'] : __("anonymous") ?></td>
                                <td><?= $report['reportDateAndTime'] ?></td>
                                <td><?= $report['groupName'] ?></td>
                                <td><?= $report['reportType'] ?></td>
                                <td><?= character_limiter($report['description'], 50, '<span class="readmore" data-report-id="' . $report['id'] . '" data-lang="en" data-toggle="modal" data-target=".showthedesc" > <b>' . __("read-more") . '</b></span>'); ?></td>
                                <td class="text-center">
                                    <?php if ($report['Media'] > 0) { ?>
                                        <i class="uil uil-cloud-database-tree showmedia" data-toggle="modal"
                                           data-target=".showmedialist" data-original-title="show attachments"
                                           data-placement="top" data-toggle="tooltip"
                                           data-report-id="<?= $report['id'] ?>"></i>
                                    <?php } else { ?>
                                        <?= __("no-files") ?>
                                    <?php } ?>
                                </td>
                                <?php if (!$isMinistry) { ?>
                                    <td class="text-center">
                                        <a href="<?= base_url("EN/schools/speak-out-comments/" . $report['id']) ?>">
                                            <i class="uil uil-comment-alt-notes comments"></i>
                                        </a>
                                    </td>
                                <?php } ?>
                                <td class="">
                                    <span class="badge rounded-pill status-box-<?= $report['id'] ?>"
                                          style="background-color: #604174;color: #fff">
                                        <?= __("closed") ?>
                                    </span>
                                </td>
                                <td class="">
                                    <span class="badge rounded-pill"
                                          style="background-color: <?= priority($report['priority'])['bg'] ?>;color: #fff">
                                        <?= __(strtolower(priority($report['priority'])['text'])) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(".table").on('click', ".showmedia", function () {
        var id = $(this).attr('data-report-id');
        $.ajax({
            type: "POST",
            url: "<?= current_url(); ?>",
            data: {
                id: id,
                for: "media",
            },
            success: function (response) {
                if (response.status == "ok") {
                    var new_html = "";
                    var i = 0;
                    response.data.forEach(media => {
                        i++;
                        new_html += '<a class="btn btn-primary waves-effect waves-light w-100 mb-1" target="_blank" href="<?= base_url("./uploads/Mylifereportsmedia/") ?>' + media.file + '">' + i + '. <?= __("click-to-open") ?> </a>';
                    });
                    $('.showmedialist .modal-body').html(new_html);
                }
            }
        });
    });
</script>
