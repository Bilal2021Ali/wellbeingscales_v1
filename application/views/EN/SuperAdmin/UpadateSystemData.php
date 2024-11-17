<!doctype html>
<html lang="en">
<link rel="stylesheet" href="<?= base_url() ?>assets/css/jquery.slidinput.min.css">

<body class="light menu_light logo-white theme-white">
<div class="outer"></div>
<style>
                .Ver,
                .Not {
                    font-size: 14px;
                    border-radius: 5px;
                    width: 50%;
                    display: block;
                    text-align: center;
                    color: #fff;
                    height: 50%;
                    line-height: 5px;
                    font-style: normal;
                    font-weight: bold;
                    margin-top: 5px;
                }

                .Ver {
                    background: green;
                }

                .Not {
                    background: red;
                }
            </style>
</style>
<link href="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" />
<style>
                .InfosCards h4,
                .InfosCards p {
                    color: #fff;
                }

                .InfosCards .card-body {
                    border-radius: 5px;
                }
            </style>
<div class="main-content">
  <div class="page-content">
    <h4 class="card-title" style="background: #0eacd8; padding: 10px;color: #ffffff;border-radius: 4px;"> 0001: Update Organization </h4>
    <div class="row">
      <div class="col-xl-6">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title" style="background: #add138;padding: 10px;color: #000;border-radius: 4px;">Update Organization</h4>
            <div class="alert alert-border alert-border-secondary alert-dismissible fade show" role="alert"> <span id="Toast">Update Organizations</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </button>
            </div>
            <form class="needs-validation InputForm" novalidate="" style="margin-bottom: 27px;" id="UpSysteme">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <h4 class="card-title" style="background: #add138; padding: 10px;color: #0c637b;border-radius: 4px;">English Name</h4>
                    <input type="text" class="form-control" placeholder="Organization Name EN" value="<?= $olddata->EN_Title ?>" name="English_Title" required="">
                    <div class="valid-feedback"> Looks good! </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <h4 class="card-title" style="background: #add138; padding: 10px;color: #0c637b;border-radius: 4px;">Arabic Name</h4>
                    <input type="text" class="form-control" placeholder="Organization Name AR" value="<?= $olddata->AR_Title ?>" name="Arabic_Title" required="">
                    <div class="valid-feedback"> Looks good! </div>
                  </div>
                </div>
              </div>
              <input type="hidden" value="1" id="VX" name="VX">
              <div class="row">
                <?php
                $contriesarray = $this->db->query( 'SELECT * FROM `r_countries` ORDER BY `r_countries`.`name` ASC' )->result_array();
                $defaultcountry = $this->db->query( 'SELECT `region` FROM `region` ORDER BY `id` ASC LIMIT 1' )->result_array();
                $reg = $defaultcountry[ 0 ][ 'region' ];
                $truid = substr( $reg, 8, 11 ); // 11
                $countryname = $this->db->query( "SELECT `name` FROM `r_countries` WHERE `id` = '" . $truid . "' ORDER BY `id` ASC LIMIT 1" )->result_array();
                ?>
                <div class="col-md-6" style="margin-bottom: 10px"> <br>
                  <h4 class="card-title" style="background: #add138; padding: 10px;color: #0c637b;border-radius: 4px;">Country</h4>
                  <select class="custom-select" name="cousntrie">
                    <option value="<?= $truid; ?>">
                    <?= $countryname[0]['name'] ?>
                    </option>
                    <?php foreach ($contriesarray as $contries) { ?>
                    <option <?= $olddata->CountryID == $contries['id'] ? "selected" : "" ?> value="<?= $contries['id']; ?>" class="option">
                    <?= $contries['name']; ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
                <?php $styles = $this->db->query("SELECT * FROM `r_style` ")->result_array();  ?>
                <div class="col-md-6" style="margin-bottom: 10px"> <br>
                  <h4 class="card-title" style="background: #add138; padding: 10px;color: #0c637b;border-radius: 4px;">Type</h4>
                  <select class="custom-select" name="style_id">
                    <?php foreach ($styles as $style) { ?>
                    <option <?= $olddata->Style_type_id == $style['Id'] ? "selected" : "" ?> value="<?= $style['Id']; ?>">
                    <?= $style['style_name'] ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <h4 class="card-title" style="background: #add138; padding: 10px;color: #0c637b;border-radius: 4px;">Email</h4>
                    <input value="<?= $olddata->Email ?>" type="email" class="form-control" placeholder="Email" name="Email" required="">
                    <div class="valid-feedback"> Looks good! </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <h4 class="card-title" style="background: #add138; padding: 10px;color: #0c637b;border-radius: 4px;">User Name</h4>
                    <input type="text" readonly value="<?= $olddata->Username ?>" class="form-control" placeholder="User Name" name="Username" required="">
                    <div class="valid-feedback"> Looks good! </div>
                  </div>
                </div>
              </div>
              <br>
              <input type="hidden" value="<?= $olddata->Id ?>" name="id">
              <button class="btn btn-primary" type="Submit" id="sendingbutton">Save</button>
              <button type="button" class="btn btn-light" id="back">Cancel</button>
            </form>
            <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">Modal Heading</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                  </div>
                  <div class="modal-body">
                    <form id="sendToemail">
                      <div id="statusbox" class="alert alert-primary" role="alert"> Please Write Email To Send Infos </div>
                      <input type="hidden" class="staticinput" id="getedusername" name="getedusername">
                      <input type="hidden" class="staticinput" id="getedpassword" name="getedpassword">
                      <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" placeholder="Email" name="sendToEmail" required="">
                        <div class="valid-feedback"> Looks good! </div>
                      </div>
                      <button type="Submit" style="width: 100%;" class="btn btn-primary w-lg waves-effect waves-light" id="sendingbutton">SEND THE EMAIL</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-6">
        <div class="card">
          <div class="card-body" style="height: 600px;">
            <h4 class="card-title" style="background: #add138;padding: 10px;color: #000;border-radius: 4px;">List of Registered Organizations</h4>
            <div class="alert alert-border alert-border-secondary alert-dismissible fade show" role="alert"> <span id="Toast">List Organizations</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </button>
            </div>
            <table class="table mb-0">
              <thead style="border-top: 2px solid #74788d;border-top-left-radius: 43px;">
                <tr>
                  <th class="card-title" style="background: #add138; padding: 10px;color: #0c637b;border-radius: 4px;" > #</th>
                  <th class="card-title" style="background: #add138; padding: 10px;color: #0c637b;border-radius: 4px;" > User Name</th>
                  <th class="card-title" style="background: #add138; padding: 10px;color: #0c637b;border-radius: 4px;" > Type</th>
                  <th class="card-title" style="background: #add138; padding: 10px;color: #0c637b;border-radius: 4px;" > Country </th>
                  <th class="card-title" style="background: #add138; padding: 10px;color: #0c637b;border-radius: 4px;" > Status </th>
                </tr>
              </thead>
              <tbody>
                <?php
                $listofadmins = $this->db->query( 'SELECT * FROM l0_organization ORDER BY `Created` DESC LIMIT 9' )->result_array();
                ?>
                <?php foreach ($listofadmins as $adminData) { ?>
                <tr>
                  <th scope="row"><?= $adminData['Id'] ?></th>
                  <td><?= $adminData['Username'] ?></td>
                  <td><?= $adminData['Type'] ?></td>
                  <td><?php
                  $contriesarray = $this->db->query( "SELECT * FROM `r_countries` 
                                                            WHERE id = '" . $adminData[ 'CountryID' ] . "' ORDER BY `name` ASC" )->result_array();
                  foreach ( $contriesarray as $contrie ) {
                      echo $contrie[ 'name' ];
                  }
                  ?></td>
                  <?php
                  if ( $adminData[ 'verify' ] == 1 ) {
                      $classname = 'Ver';
                  } else {
                      $classname = 'Not';
                  }
                  ?>
                  <td class="<?= $classname; ?>"><?php if (!empty($adminData['Manager']) && !empty($adminData['Tel'])) { ?>
                    <i class="uil-check" style="font-size: 20px;font-style: normal;"></i>
                    <?php } else { ?>
                    <i class="" style="font-size: 14px;font-style: normal;">X</i>
                    <?php } ?></td>
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
<script>
                $("#UpSysteme").on('submit', function(e) {
                    e.preventDefault();
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url(); ?>EN/Dashboard/startUpdatingSystem',
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(data) {
                            $('#Toast').css('display', 'block');
                            $('#Toast').html(data);

                        },
                        ajaxError: function() {
                            $('.alert.alert-info').css('background-color', '#DB0404');
                            $('.alert.alert-info').html("Ooops! Error was found.");
                        }
                    });
                });

                $("#sendToemail").on('submit', function(e) {
                    e.preventDefault();
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url(); ?>EN/Dashboard/SendUpdatedInfosEmail',
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function() {
                            $('#statusbox').css('display', 'block');
                            $('#statusbox').html('<p style="width: 100%;margin: 0px;"> please wait !!</p>')
                            $('#sendingbutton').attr('disabled', 'disabled');
                            $('#sendingbutton').addClass('mat-button-disabled');
                            $('#sendingbutton').html('please wait !!');
                        },
                        success: function(data) {
                            $('#statusbox').css('display', 'block');
                            $('#statusbox').html(data);

                        },
                        ajaxError: function() {
                            $('#statusbox').css('background-color', '#DB0404');
                            $('#statusbox').html("Ooops! Error was found.");
                        }
                    });
                });

                $('#back').click(function() {
                    location.href = "<?= base_url() . "EN/Dashboard/"; ?>";
                });

                function back() {
                    location.href = "<?= base_url() . "EN/Dashboard/UpdateSystem/"; ?>";
                }
            </script>
</body>
</html>