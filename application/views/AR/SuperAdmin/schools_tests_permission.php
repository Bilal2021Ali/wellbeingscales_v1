<div class="main-content">
    <div class="page-content">
        <div class="container">
            <div class="row">
                <?php foreach ($campanys as $campany) {  ?>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="clearfix"></div>
                                <div class="mb-4">
                                    <img src="<?= base_url() ?>uploads/avatars/<?= empty($campany['pic']) ? "default_avatar.jpg" : $campany['pic'];  ?>" alt="" class="avatar-lg rounded-circle img-thumbnail">
                                </div>
                                <h5 class="font-size-16 mb-1"><a href="#" class="text-dark"><?= $campany['Dept_Name_EN']  ?></a></h5>
                                <p class="text-muted mb-2"><a href="mailto:<?= $campany['Email']  ?>"><?= $campany['Email']  ?></a></p>
                            </div>
                            <div class="btn-group" role="group">
                                <a href="<?= base_url() ?>EN/Dashboard/schools_tests_permission/<?= $campany['Id']  ?>" class="btn btn-outline-light text-truncate">
                                    Manage Connects
                                </a>
                            </div>
                        </div>
                    </div>
                <?php  }  ?>
            </div>
        </div>
    </div>
</div>