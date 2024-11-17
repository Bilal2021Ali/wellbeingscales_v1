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
        color: #0f1b02 !important;
    }

    .badge.bg-success {
        background-color: #7cd992 !important;
        color: #0f1b02 !important;
    }

    .badge.bg-warning {
        background-color: #f7e463 !important;
        color: #0f1b02 !important;
    }

    .badge.bg-danger {
        background-color: #eb6161 !important;
        color: #0f1b02 !important;
    }
</style>
<?php $closed = array(); ?>
<div class="main-content">
    <div class="page-content">
        <div class="modal fade showmedialist" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">المرفقات:</h5>
                        <button type="button" class="btn btn-light btn-rounded waves-effect" data-dismiss="modal" aria-label="Close">x</button>
                    </div>
                    <div class="modal-body"></div>
                </div>
            </div>
        </div>
        <div class="modal fade showthedesc" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">شكوى الطالب:</h5>
                        <button type="button" class="btn btn-light btn-rounded waves-effect" data-dismiss="modal" aria-label="Close">x</button>
                    </div>
                    <div class="modal-body"></div>
                </div>
            </div>
        </div>
        <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CH 100: قائمة شكاوى الطلاب</h4>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">الشكاوى المفتوحة</h3>
                        <div class="col-12">
                            <hr>
                            <table class="table table-hover table-responsive">
                                <thead>
                                    <th>#</th>
                                    <th>الصورة</th>
                                    <th>اسم الطالب</th>
                                    <th>التاريخ &amp; التوقيت</th>
                                    <th>مجموعة الشكوى</th>
                                    <th>نوع الشكوى</th>
                                    <th>الشكوى - بالعربي</th>
                                    <th>المرفقات</th>
                                    <th>الإجراءات</th>
                                    <th>الحالة</th>
                                    <th>الأولوية</th>
                                    <th>إغلاق الشكوى</th>
                                </thead>
                                <tbody>
                                    <?php foreach ($reports as $sn => $report) { ?>
                                        <?php if (!$report['closed']) { ?>
                                            <tr>
                                                <td><?= $sn + 1  ?></td>
                                                <td class="text-center"><img src="<?= base_url("uploads/avatars/") . (empty($report['useravatar']) || $report['show_user_name'] == 0 ? "default_avatar.jpg" : $report['useravatar']) ?>" class="img-thumbnail rounded-circle avatar-sm" alt=""></td>
                                                <td><?= $report['show_user_name'] == 0 ? $report['username'] : "مجهول" ?></td>
                                                <td><?= $report['reportdateandtime'] ?></td>
                                                <td><?= $report['groupname'] ?></td>
                                                <td><?= $report['reptype'] ?></td>
                                                <td><?= character_limiter($report['description_ar'], 50, '<span class="readmore" data-report-id="' . $report['id'] . '" data-lang="ar" data-toggle="modal" data-target=".showthedesc" > <b> المزيد</b></span>'); ?></td>
                                                <td class="text-center"><?php if ($report['Media'] > 0) { ?>
                                                        <i class="uil uil-cloud-database-tree showmedia" data-toggle="modal" data-target=".showmedialist" data-original-title="show attachments" data-placement="top" data-toggle="tooltip" data-report-id="<?= $report['id'] ?>"></i>
                                                    <?php } else { ?>
                                                        بدون مرفقات
                                                    <?php } ?>
                                                </td>
                                                <td class="text-center"><a href="<?= base_url("AR/schools/speak_out_comments/" . $report['id']) ?>"><i class="uil uil-comment-alt-notes comments"></i></a></td>
                                                <td class=""><span class="badge rounded-pill status-box-<?= $report['id'] ?>" style="background-color: <?= status($report['status'])['bg'] ?>;color: #fff">
                                                        <?= status($report['status'])['text'] ?>
                                                    </span></td>
                                                <td class=""><span class="badge rounded-pill" style="background-color: <?= priority($report['priority'])['bg'] ?>;color: #fff">
                                                        <?= priority($report['priority'])['text'] ?>
                                                    </span></td>
                                                <td><button <?= $report['closed'] ? "disabled" : "" ?> type="button" class="btn btn-warning btn-rounded waves-effect waves-light closereport" data-id="<?= $report['id'] ?>"><i class="uil uil-check font-size-15"></i></button></td>
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
                        <h3 class="card-title">الشكاوى المغلقة</h3>
                        <div class="col-12">
                            <hr>
                            <table class="table table-hover table-responsive">
                                <thead>
                                    <th>#</th>
                                    <th>الصورة</th>
                                    <th>اسم الطالب</th>
                                    <th>التاريخ &amp; التوقيت</th>
                                    <th>مجموعة الشكوى</th>
                                    <th>نوع الشكوى</th>
                                    <th>الشكوى - بالعربي</th>
                                    <th>المرفقات</th>
                                    <th>الإجراءات</th>
                                    <th>الحالة</th>
                                    <th>الأولوية</th>

                                </thead>
                                <tbody>
                                    <?php foreach ($closed as $sn => $report) { ?>
                                        <tr>
                                            <td><?= $sn + 1  ?></td>
                                            <td class="text-center"><img src="<?= base_url("uploads/avatars/") . (empty($report['useravatar']) || $report['show_user_name'] == 0 ? "default_avatar.jpg" : $report['useravatar']) ?>" class="img-thumbnail rounded-circle avatar-sm" alt=""></td>
                                            <td><?= $report['show_user_name'] == 0 ? $report['username'] : "مجهول" ?></td>
                                            <td><?= $report['reportdateandtime'] ?></td>
                                            <td><?= $report['groupname'] ?></td>
                                            <td><?= $report['reptype'] ?></td>
                                            <td><?= character_limiter($report['description_ar'], 50, '<span class="readmore" data-report-id="' . $report['id'] . '" data-lang="ar" data-toggle="modal" data-target=".showthedesc" > <b> المزيد</b></span>'); ?></td>
                                            <td class="text-center"><?php if ($report['Media'] > 0) { ?>
                                                    <i class="uil uil-cloud-database-tree showmedia" data-toggle="modal" data-target=".showmedialist" data-original-title="show attachments" data-placement="top" data-toggle="tooltip" data-report-id="<?= $report['id'] ?>"></i>
                                                <?php } else { ?>
                                                    بدون مرفقات
                                                <?php } ?>
                                            </td>
                                            <td class="text-center"><a href="<?= base_url("AR/schools/speak_out_comments/" . $report['id']) ?>"><i class="uil uil-comment-alt-notes comments"></i></a></td>
                                            <td class=""><span class="badge rounded-pill status-box-<?= $report['id'] ?>" style="background-color: #604174;color: #fff">
                                                    مغلقة
                                                </span></td>
                                            <td class=""><span class="badge rounded-pill" style="background-color: <?= priority($report['priority'])['bg'] ?>;color: #fff">
                                                    <?= priority($report['priority'])['text'] ?>
                                                </span></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php

function status($status)
{
    $response = array('text' => 0, 'bg' => 0);
    if ($status == 0) {
        $response['text'] = "معلقة";
        $response['bg'] = "#ffc003";
    } elseif ($status == 1) {
        $response['text'] = "تم مشاهدتها";
        $response['bg'] = "#8ea9dd";
    } elseif ($status == 2) {
        $response['text'] = "تم حلها";
        $response['bg'] = "#528235";
    } else {
        $response['text'] = "تم معالجتها";
        $response['bg'] = "#93d04e";
    }
    return $response;
}

function priority($status)
{
    $response = array('text' => 0, 'bg' => 0);
    if ($status == 0) {
        $response['text'] = "متوسط";
        $response['bg'] = "#01aff3";
    } elseif ($status == 1) {
        $response['text'] = "طاريء";
        $response['bg'] = "#c00000";
    } elseif ($status == 2) {
        $response['text'] = "هام";
        $response['bg'] = "#ff4f4f";
    } else {
        $response['text'] = "هام جدا";
        $response['bg'] = "#fe0000";
    }
    return $response;
}
?>
<script>
    $('.table').DataTable();
    $(".table").on('click', ".showmedia", function() {
        var id = $(this).attr('data-report-id');
        $.ajax({
            type: "POST",
            url: "<?= current_url(); ?>",
            data: {
                id: id,
                for: "media",
            },
            success: function(response) {
                if (response.status == "ok") {
                    var new_html = "";
                    var i = 0;
                    response.data.forEach(media => {
                        i++;
                        new_html += '<a class="btn btn-primary waves-effect waves-light w-100 mb-1"  href="<?= base_url("./uploads/Mylifereportsmedia/") ?>' + media.file + '">' + i + '. اضغط هنا لفتح المرفق </a>';
                    });
                    $('.showmedialist .modal-body').html(new_html);
                }
            }
        });
    });

    $(".table").on('click', ".readmore", function() {
        var id = $(this).attr('data-report-id');
        var language = $(this).attr('data-lang');
        $.ajax({
            type: "POST",
            url: "<?= current_url(); ?>",
            data: {
                id: id,
                for: "description",
                lang: language
            },
            success: function(response) {
                if (response.status == "ok") {
                    $('.showthedesc .modal-body').html('<p>' + response.description + '</p>');
                }
            }
        });
    });


    $(".table").on('click', ".closereport", function() {
        var id = $(this).attr('data-id');
        var $this = $(this);
        Swal.fire({
            title: 'هل أنت متأكد أنك تريد إغلاق الشكوى؟',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: `نعم`,
            cancelButtonText: `لا`,
            icon: 'warning',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?= current_url(); ?>",
                    data: {
                        id: id,
                        for: "close",
                    },
                    success: function(response) {
                        if (response.status == "ok") {
                            $($this).attr('disabled', "");
                            $('.status-box-' + id).html("Approved");
                            $('.status-box-' + id).addClass("bg-success");
                            Swal.fire({
                                title: 'تمت',
                                text: 'تم إغلاق الشكوى',
                                icon: 'success'
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 500);
                        } else {
                            Swal.fire({
                                title: 'sorry!',
                                text: 'we have unexpected errors',
                                icon: 'error'
                            });
                        }
                    }
                });
            }
        });
    });
</script>