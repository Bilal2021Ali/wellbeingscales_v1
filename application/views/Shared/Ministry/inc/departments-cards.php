<?php
$idd = $sessiondata['admin_id'];
$get_style = $this->db->query(" SELECT `r_style`.*
FROM `l0_organization` JOIN `r_style` ON `l0_organization`.`Style_type_id`  = `r_style`.`Id` 
WHERE  `l0_organization`.`Id` = '" . $sessiondata['admin_id'] . "' LIMIT 1")->result_array();
//print_r($listofadmins);
?>
<div class="row">
    <div class="col-md-6 col-xl-3 InfosCards">
        <div class="card">
            <div class="card-body" style="background-color: #344267;">
                <div class="float-right mt-2">
                    <img src="<?= base_url(); ?>assets/images/icons/png_icons/counterdepartments.png" alt="schools">
                </div>
                <div>
                    <?php
                    $id = $sessiondata['admin_id'];
                    $all_ministry = $this->db->query("SELECT * FROM `l1_department`
                                             WHERE Added_By = $idd ")->num_rows();
                    $lastminED = $this->db->query("SELECT * FROM `l1_department` WHERE Added_By = $idd ORDER BY Id DESC LIMIT 1 ")->result_array();

                    ?>
                    <h4 class="mb-1 mt-1">
                        <span data-plugin="counterup"><?= $all_ministry ?></span>
                    </h4>
                    <?php foreach ($get_style as $style) { ?>
                        <p class="mb-0"> <?= $style[strtolower($activeLanguage) . '_co_type']; ?> <?= __("counter") ?></p>
                    <?php } ?>
                </div>
                <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                                <?php if (!empty($lastminED)) { ?>
                                                <?php foreach ($lastminED

                                                as $last) { ?>
                                                <?= $last['Created'] ?></span><br>
                    <?php foreach ($get_style

                    as $style) { ?>
                <p class="text-muted"> <?= __("last_registered") ?> <?= strtolower($style[strtolower($activeLanguage) . '_co_type_sub']); ?> </p>
                <?php } ?>
                <?php } ?>
                <?php } else { ?>
                    <?= "--/--/--" ?><br>
                    <?php foreach ($get_style as $style) { ?>
                        <?= __("last_registered") ?> <?= strtolower($style[strtolower($activeLanguage) . '_co_type_sub']); ?>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div> <!-- end col -->
    <div class="col-md-6 col-xl-3 InfosCards">
        <div class="card">
            <div class="card-body" style="background-color: #605091;">
                <div class="float-right mt-2">
                    <img src="<?= base_url(); ?>assets/images/icons/png_icons/staff.png" alt="Test" width="50px">
                </div>
                <div>
                    <?php
                    $ours = $this->db->query(" SELECT * FROM `l1_department`
											 WHERE `Added_By` = '" . $idd . "' ")->result_array();
                    $studentscounter = 0;
                    $lastaddeds = array();
                    foreach ($ours as $dept) {
                        $patient = $this->db->query(" SELECT Created FROM 
												 `l2_co_patient` WHERE `Added_By` = '" . $dept['Id'] . "' ORDER BY `Id` DESC ")->result_array();
                        if (!empty($patient)) {
                            $studentscounter += sizeof($patient);
                            $lastaddeds[] = $patient[0]['Created'];
                        }
                    }
                    ?>
                    <h4 class="mb-1 mt-1">
                        <span data-plugin="counterup"><?= $studentscounter; ?></span>
                    </h4>
                    <p class="mb-0"> <?= __("user_counter") ?></p>
                </div>
                <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                                <?php
                                                //print_r($test);
                                                if (!empty($lastaddeds)) {
                                                $last = sizeof($lastaddeds);
                                                ?>
                                                <?= $lastaddeds[$last - 1]; ?></span><br>
                    <?= __("last_registered_user") ?>
                    <?php } else { ?>
                        <?= "--/--/--"; ?></span><br>
                        <?= __("last_registered_user") ?>
                    <?php } ?>
                </p>
            </div>
        </div>
    </div> <!-- end col -->
    <div class="col-md-6 col-xl-3 InfosCards">
        <div class="card">
            <div class="card-body" style="background-color: #344267;">
                <div class="float-right mt-2">
                    <img src="<?= base_url(); ?>assets/images/icons/png_icons/device.png" alt="schools">
                </div>
                <div>
                    <?php
                    $allDev = 0;
                    $ListOfThis = array();
                    $All_added_schools = $this->db->query("SELECT * FROM `l1_department`
               WHERE `Added_By` = $idd ")->result_array();
                    foreach ($All_added_schools as $school) {
                        $devicesforThis = $this->db->query("SELECT * FROM `l2_co_devices`
                    WHERE Added_by = '" . $school['Id'] . "' ORDER BY Created DESC ")->result_array();
                        foreach ($devicesforThis as $dvices) {
                            $allDev++;
                            $ListOfThis[] = $dvices["Created"];
                        }
                        //$Last_Created = end($ListOfThis[]);
                    }
                    $lasts = $this->db->query("SELECT * FROM `l1_school`  WHERE `Added_By` = $idd  
					ORDER BY Id DESC LIMIT 1 ")->result_array();
                    ?>
                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?= $allDev ?></span></h4>
                    <p class="mb-0"><?= __("device_counter") ?></p>
                </div>
                <?php if (!empty($ListOfThis)) { ?>
                    <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                                    <?= $ListOfThis[0]; ?></span><br>
                        <?= __("last_registered_device") ?>
                    </p>
                <?php } else { ?>
                    <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                                    <?= "--/--/--" ?></span><br>
                        <?= __("last_registered_device") ?>
                    </p>
                <?php } ?>
            </div>
        </div>
    </div> <!-- end col -->
    <div class="col-md-6 col-xl-3 InfosCards">
        <div class="card">
            <div class="card-body" style="background-color: #694811;">
                <div class="float-right mt-2">
                    <img src="<?= base_url(); ?>assets/images/icons/png_icons/countersites.png" alt="Test" width="50px">
                </div>
                <div>
                    <?php
                    $allSites = 0;
                    $ListOfSitesforThis = array();
                    /*$All_added_schools = $this->db->query("SELECT * FROM `l1_school`
WHERE `Added_By` = $idd ")->result_array();*/
                    foreach ($All_added_schools as $school) {
                        $SitesforThis = $this->db->query("SELECT * FROM `l2_co_site`
                    WHERE Added_by = '" . $school['Id'] . "' ORDER BY Created DESC ")->result_array();
                        foreach ($SitesforThis as $Sites) {
                            $allSites++;
                            $ListOfSitesforThis[] = $Sites["Created"];
                        }
                        //$Last_Created = end($ListOfThis[]);
                    }
                    ?>
                    <h4 class="mb-1 mt-1">
                        <span data-plugin="counterup"><?= $allSites ?></span>
                    </h4>
                    <p class="mb-0"> <?= __("site_counter") ?> </p>
                </div>
                <?php if (!empty($ListOfSitesforThis)) { ?>
                    <p class="mt-3 mb-0">
                                                <span class="mr-1" style="color: #e1da6a;">
                                                    <?= $ListOfSitesforThis[0] ?>
                                                </span><br>
                        <?= __("last_registered_site") ?>
                    </p>
                <?php } else { ?>
                    <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                                    <?= "--/--/--" ?></span><br>
                        <?= __("last_registered_site") ?>
                    </p>
                <?php } ?>
            </div>
        </div>
    </div> <!-- end col-->
</div> <!-- end row-->