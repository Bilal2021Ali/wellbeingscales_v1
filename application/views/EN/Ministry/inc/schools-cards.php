<?php
$id = $sessiondata['admin_id'];
$all = $this->db->query("SELECT * FROM `l1_school` WHERE  `Added_by` = $id ")->num_rows();
$allEn = $this->db->query("SELECT * FROM `l1_school`  WHERE  `Added_by` = $id AND `status` = '1'  ")->num_rows();
$allDe = $this->db->query("SELECT * FROM `l1_school`  WHERE  `Added_by` = $id  AND `status` = '0' ")->num_rows();
?>
<div class="row">
    <div class="col-md-4 col-xl-4 InfosCards">
        <div class="card">
            <div class="card-body" style="background-color: #144882;">
                <div class="float-right mt-2">
                    <img src="<?= base_url(); ?>assets/images/icons/counterschools.png"
                         alt="schools" width="50px"></i>
                </div>
                <div>
                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?= $all ?></span></h4>
                    <p class="mb-0"><?= __("schools") ?></p>
                </div>
            </div>
        </div>
    </div> <!-- end col-->
    <div class="col-md-4 col-xl-4 InfosCards">
        <div class="card">
            <div class="card-body" style="background-color: #0164a8;">
                <div class="float-right mt-2">
                    <img src="<?= base_url(); ?>assets/images/icons/counterschools.png"
                         alt="schools" width="50px"></i>
                </div>
                <div>
                    <h4 class="mb-1 mt-1">
                        <span data-plugin="counterup"><?= $allEn ?></span>
                    </h4>
                    <p class="mb-0"><?= __("enabled_schools") ?></p>
                </div>
            </div>
        </div>
    </div> <!-- end col-->
    <div class="col-md-4 col-xl-4 InfosCards">
        <div class="card">
            <div class="card-body" style="background-color: #6f42c1;">
                <div class="float-right mt-2">
                    <img src="<?= base_url(); ?>assets/images/icons/counterschools.png"
                         alt="schools" width="50px"></i>
                </div>
                <div>
                    <h4 class="mb-1 mt-1">
                        <span data-plugin="counterup"><?= $allDe ?></span>
                    </h4>
                    <p class="mb-0"><?= __("disabled_schools") ?></p>
                </div>
            </div>
        </div>
    </div> <!-- end col-->
</div> <!-- end row-->
