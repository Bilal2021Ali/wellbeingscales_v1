<div class="col-12">
    <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CH 009: الجدول اليومي للحضور </h4>
    <div class="row">

        <?php $absenttypes = [
            [
                "name" => "staff",
                "display" => "الموظفين"
            ],
            [
                "name" => "teachers",
                "display" => "المدرسين"
            ],
            [
                "name" => "students",
                "display" => "الطلاب"
            ]
        ]; ?>
        <?php foreach ($absenttypes as $absenttype) { ?>
            <div class="col-xl-4 col-sm-12">
                <div class="card">
                    <div class="card-body">

                        <h3 class="card-title" style="background: #33A2FF; padding: 10px;color: #FFFFFF;border-radius: 4px;"> غياب <?= ucfirst($absenttype["display"]) ?> </h3>
                        <table>

                            <thead>
                                <th> الصورة</th>
                                <th> الإسم والوقت </th>
                            </thead>
                            <tbody>
                                <?php foreach ($absent[$absenttype["name"]] as $absentstaff) { ?>
                                    <tr>
                                        <td>
                                            <?php if (empty($absentstaff["avatar"])) {  ?>
                                                <img src="<?= base_url("uploads/avatars/default_avatar.jpg"); ?>" class="avatar-xs rounded-circle " alt="...">
                                            <?php } else { ?>
                                                <img src="<?= base_url("uploads/avatars/" . $absentstaff['avatar']); ?>" class="avatar-xs rounded-circle " alt="...">
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <h6 class="mb-1 font-weight-normal" style="font-size: 15px;"><?= $absentstaff['name']; ?></h6>
                                            <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i><?= $absentstaff['recorded_at']; ?></p>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>