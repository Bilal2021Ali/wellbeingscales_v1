<style>
    .page-item.page-link.active * {
        color: #fff;
    }

    .answer-td {
        text-align: center;
        font-size: 20px;
        padding-top: 40px !important;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <th>Img</th>
                                <th>Name</th>
                                <?php foreach ($climate_survyes as $survey) { ?>
                                    <th><?= $survey['Cat_en']; ?></th>
                                <?php } ?>
                            </thead>
                            <tbody>
                                <?php foreach ($usersWhoAnsweredToday as $sn => $user) { ?>
                                    <tr>
                                        <td><img class="avatar-md rounded-circle m-3" src="<?= base_url('uploads/co_avatars/') . ($user['Avatar'] !== "" ? $user['Avatar'] : 'default_avatar.jpg') ?>" alt=""></td>
                                        <td><?= $user['userName'] ?><br><?= $user['UserType'] ?></td>
                                        <?php foreach ($climate_survyes as $survey) { ?>
                                            <?php
                                            $value = $this->sv_reports->Answer($survey['survey_id'], $user['Id']);
                                            $color = "#fff";
                                            foreach ($scores as $key => $score) {
                                                if ($value >= $score['accept_from'] && $value <= $score['accept_to']) {
                                                    $color = $score['color'];
                                                    break;
                                                }
                                            }
                                            ?>
                                            <td class="answer-td" style="background-color: <?= $color ?>"><span style="color: <?= $score['font_color'] ?>;"><?= $value ?></span></td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="col-12 text-center">
                            <?= $links ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>