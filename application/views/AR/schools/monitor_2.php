<style>
    td {
        font-weight: bold;
    }

    .flex {
        display: flex;
        align-items: center;
    }

    .flex * {
        margin: 5px;
    }

    .table strong {
        font-size: 22px;
    }

    .table p {
        font-size: 11px;
        color: #a9a9a9;
    }

    .badge-soft-blue {
        color: #00d3f5 !important;
        background-color: rgb(91 215 232 / 18%) !important;
    }

    .badge-soft-orange {
        color: #ff5722;
        background-color: rgb(255 87 34 / 18%);
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <div class="p-3 bg-light mb-4">
                    <h5 class="font-size-16 mb-0"> Stay Home & Quarantine Results Monitor <span class="float-right ml-2"> <a href="<?= base_url(); ?>AR/schools/ListofDevices"> </a> </span> </h5>
                </div>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home1" role="tab" aria-selected="true"> <span class="d-block d-sm-none"><i class="fas fa-home"></i></span> <span class="d-none d-sm-block">Staff</span> </a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile1" role="tab" aria-selected="false"> <span class="d-block d-sm-none"><i class="far fa-user"></i></span> <span class="d-none d-sm-block">Teachers</span> </a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#messages1" role="tab" aria-selected="false"> <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span> <span class="d-none d-sm-block">Students</span> </a> </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content p-3 text-muted">
                    <div class="tab-pane active" id="home1" role="tabpanel">
                        <?php GenerateTable($results['staff']); ?>
                    </div>
                    <div class="tab-pane" id="profile1" role="tabpanel">
                        <?php GenerateTable($results['teachers']); ?>
                    </div>
                    <div class="tab-pane" id="messages1" role="tabpanel">
                        <?php GenerateTable($results['students']); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
function GenerateTable($data)
{ ?>
    <table class="table table-striped table-bordered table-responsive">
        <thead>
            <th>#</th>
            <th>Name</th>
            <th>Blood Pressure</th>
            <th>Pulse</th>
            <th>Blood Oxygen</th>
            <th>Temperature</th>
            <th>Blood Glucose</th>
            <th>Weight</th>
            <th>Sleep</th>
            <th>Actions</th>
        </thead>
        <tbody>
            <?php foreach ($data as $sn => $user) { ?>
                <tr>
                    <td><?= $sn + 1  ?></td>
                    <td class="flex">
                        <img src="<?= base_url("uploads/avatars/" . ($user['useravatar'] ?? "default_avatar.jpg")); ?>
						"class="avatar-sm" alt="" srcset="">
                        <h5><?= $user['username']  ?></h5>
                    </td>
                    <td class="badge-soft-danger"><strong><?= $user['Blood_pressure_min'] ?>/<?= $user['Blood_pressure_max'] ?></strong> bpm</small><br>
                        <p><?= $user['Blood_pressure_Time'] ?></p>
                    </td>
                    <td class="badge-soft-primary">--</td>
                    <td class="badge-soft-success badge-soft-blue"><strong><?= $user['Blood_oxygen'] ?></strong>%</small><br>
                        <p><?= $user['Blood_oxygen_Time'] ?></p>
                    </td>
                    <td class="badge-soft-success"><strong><?= $user['Result'] ?></strong> c°</small><br>
                        <p><?= $user['Result_Time'] ?></p>
                    </td>
                    <td class="badge-soft-success badge-soft-orange"><strong><?= $user['Glucose'] ?></strong>mmoI/L</small><br>
                        <p><?= $user['Glucose_Time'] ?></p>
                    </td>
                    <td class="badge-soft-danger badge-soft-blue"><strong><?= $user['weight'] ?></strong>Kg</small><br>
                        <p><?= $user['weight_Time'] ?></p>
                    </td>
                    <td class="badge-soft-primary"></strong>00h00m</small><br>
                            <p>--:--:--</p>
                    </td>
                    <td><i class="uil uil-message"></i></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } ?>