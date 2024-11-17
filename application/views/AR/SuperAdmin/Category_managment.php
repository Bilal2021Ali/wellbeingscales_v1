<link rel="stylesheet" type="text/css" href="<?= base_url("assets/libs/toastr/build/toastr.min.css") ?>">
<style>
    * {
        list-style: none;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .title {
        background: #f3f4f8;
        padding: 15px;
        font-size: 18px;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 3px;
    }

    .file_upload_list li .file_item {
        display: flex;
        border-bottom: 1px solid #f3f4f8;
        padding: 15px 20px;
    }

    .file_item .format {
        background: #8178d3;
        border-radius: 10px;
        width: 45px;
        height: 40px;
        line-height: 40px;
        color: #fff;
        text-align: center;
        font-size: 12px;
        margin-right: 15px;
    }

    .file_item .file_progress {
        width: calc(100% - 60px);
        font-size: 14px;
    }

    .file_item .file_info,
    .file_item .file_size_wrap {
        display: flex;
        align-items: center;
    }

    .file_item .file_info {
        justify-content: space-between;
    }

    .file_item .file_progress .progress {
        width: 100%;
        height: 4px;
        background: #efefef;
        overflow: hidden;
        border-radius: 5px;
        margin-top: 8px;
        position: relative;
    }

    .file_item .file_progress .progress .inner_progress {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #58e380;
    }

    .file_item .file_size_wrap .file_size {
        margin-right: 15px;
    }

    .file_item .file_size_wrap .file_close {
        border: 1px solid #8178d3;
        color: #8178d3;
        width: 20px;
        height: 20px;
        line-height: 18px;
        text-align: center;
        border-radius: 50%;
        font-size: 10px;
        font-weight: bold;
        cursor: pointer;
    }

    .file_item .file_size_wrap .file_close:hover {
        background: #8178d3;
        color: #fff;
    }

    .choose_file label {
        display: block;
        border: 2px dashed #8178d3;
        padding: 15px;
        width: calc(100% - 20px);
        margin: 10px;
        text-align: center;
        cursor: pointer;
    }

    .choose_file #choose_file {
        outline: none;
        opacity: 0;
        width: 0;
    }

    .choose_file span {
        font-size: 14px;
        color: #8178d3;
    }

    .choose_file label:hover span {
        text-decoration: underline;
    }

    .delete {
        font-size: 20px;
        color: #ff0000;
        cursor: pointer;
    }

    .floating_action_btn {
        position: fixed !important;
        bottom: 70px;
        right: 10px;
        border: 0px;
        width: 50px;
        height: 50px;
        background: #fff;
        border-radius: 100%;
        z-index: 1000;
        -webkit-box-shadow: 0 2px 4px rgba(15, 34, 58, 0.12);
        box-shadow: 0 2px 4px rgba(15, 34, 58, 0.12);
    }

    .upload,
    .media_upload {
        font-size: 20px;
        color: #2196f3;
        cursor: pointer;
    }

    .uil-download-alt,
    .uil-arrow-up-right {
        font-size: 20px;
        color: #c7c7c7;
        cursor: pointer;
    }

    .able_to_download,
    .able_to_open {
        color: #34c38f;
        font-size: 20px;
        cursor: pointer;
    }

    .alert p {
        margin-bottom: 0px;
        text-align: center;
    }

    .swal2-footer {
        display: block !important;

    }

    .swal2-footer p {
        margin: 0px !important;
    }

    .delete {
        width: 40px;
        height: 40px;
        background: #fff;
        border-radius: 100%;
        padding-top: 4px;
        padding-left: 10px;
        position: absolute;
        top: 10px;
        left: 10px;
        color: #b30000;
        cursor: pointer;
        border: 1px solid #eeee;
    }

    /* .medialinkslist .card {
        padding: 0px;
    } */

    #media_link .d-grid .btn-danger.inner {
        height: 100%;
        font-size: 20px;
    }

    .hiddeninput {
        width: 100%;
        border: 0px;
        outline: none;
        resize: none;
    }
</style>
<style>
    .switch {
        position: absolute;
        display: inline-block;
        width: 50px;
        height: 24px;
        top: 16px;
        right: 8px;
    }

    /* Hide default HTML checkbox */
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    /* The slider */
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #CB0002;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #75b030;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>
<?php
$this->db->select_max('Id');
$max_id = $this->db->get('sv_st_category')->result_array()[0]['Id'] ?? 1;
$code = str_pad(($max_id + 1), 4, '0', STR_PAD_LEFT);
$code = "CAT" . $code;
?>
<link href="<?= base_url('assets/libs/dropzone/min/dropzone.min.css'); ?>" rel="stylesheet" type="text/css" />
<div class="main-content">
    <div class="page-content">
        <h4 class="card-title" style="background: #7D0552; padding: 10px;color: #ffffff;border-radius: 4px;">SU 008: Categorys Management</h4>
        <button type="button" class="floating_action_btn waves-effect waves-light" data-toggle="modal" data-target="#myModal"><i class="uil uil-plus"></i></button>
        <div id="UploadIcon" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="UploadIconLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="UploadIconLabel">Icon Upload</h5>
                        <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="Close">x</button>
                    </div>
                    <div class="modal-body text-center">
                        <i class="uil uil-upload mb-2" style="font-size: 25px;"></i><br>
                        (recommended dimensions : 40px * 40px)
                        <label class="btn btn-primary w-100 waves-effect mt-1">
                            Select icon to upload
                            <input hidden type="file" name="icon">
                        </label>
                        <input type="hidden" name="activeCategory">
                        <input type="hidden" name="activeLanguage">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
        <div id="ShowIcon" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ShowIconLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="ShowIconLabel">Show Icon</h5>
                        <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="Close">x</button>
                    </div>
                    <div class="modal-body text-center">
                        <h3>No Icons Found</h3>
                        <img src="" width="60" height="60">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabel"> Add Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card" style="border: 0px;box-shadow: 0px 0px 0px;">
                            <div class="card-body">
                                <div class="alert alert-success alert-dismissible fade show code" role="alert" style="display: none;">
                                    <i class="uil uil-check mr-2"></i>
                                    After Adding This The code will be: <strong><?= $code ?></strong>
                                </div>
                                <div id="StatusBox"></div>
                                <form id="add_category" data-for="Creat" class="needs-validation custom-validation" novalidate>
                                    <div class="row">
                                        <div class="col-lg-12 ">
                                            <div class="form-group">
                                                <label for="Title_EN">Category Title EN: </label>
                                                <input type="text" class="form-control" required data-parsley-minlength="3" data-parsley-maxlength="200" placeholder="Category Title EN" id="Title_EN" name="Title_EN">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 ">
                                            <div class="form-group">
                                                <label for="Action_EN">Action Plan Title EN: </label>
                                                <input type="text" class="form-control" required data-parsley-minlength="3" data-parsley-maxlength="200" placeholder="Action Plan Title EN " id="Action_EN" name="Action_EN">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 ">
                                            <div class="form-group">
                                                <label for="Report_EN">Report Title EN: </label>
                                                <input type="text" class="form-control" required data-parsley-minlength="3" data-parsley-maxlength="200" placeholder="Report Title EN" id="Report_EN" name="Report_EN">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 ">
                                            <div class="form-group">
                                                <label for="Media_EN">Video Title EN: </label>
                                                <input type="text" class="form-control" required data-parsley-minlength="3" data-parsley-maxlength="200" placeholder="Video Title EN" id="Media_EN" name="Media_EN">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 ">
                                            <div class="form-group">
                                                <label for="Title_AR">Category Title AR: </label>
                                                <input type="text" class="form-control" required data-parsley-minlength="3" data-parsley-maxlength="200" placeholder="Category Title AR" id="Title_AR" name="Title_AR">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 ">
                                            <div class="form-group">
                                                <label for="Action_AR">Action Plan Title AR: </label>
                                                <input type="text" class="form-control" required data-parsley-minlength="3" data-parsley-maxlength="200" placeholder="Action Plan Title AR " id="Action_AR" name="Action_AR">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 ">
                                            <div class="form-group">
                                                <label for="Report_AR">Report Title AR: </label>
                                                <input type="text" class="form-control" required data-parsley-minlength="3" data-parsley-maxlength="200" placeholder="Report Title AR" id="Report_AR" name="Report_AR">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 ">
                                            <div class="form-group">
                                                <label for="Media_AR">Video Title AR: </label>
                                                <input type="text" class="form-control" required data-parsley-minlength="3" data-parsley-maxlength="200" placeholder="Video Title AR" id="Media_AR" name="Media_AR">
                                            </div>
                                        </div>
                                        <!-- when update -->
                                        <input type="hidden" name="cat_id">
                                    </div>
                                    <input type="hidden" name="code" value="<?= $code ?>">
                                    <div class="mt-1">
                                        <button class="btn btn-primary" id="Teachersub" type="Submit">Submit form</button>
                                        <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>

        <div id="uploadresorces" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="uploadresorcesLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="uploadresorcesLabel"> Upload Resources: </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card" style="border: 0px;box-shadow: 0px 0px 0px;">
                            <div class="card-body">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert"></button>
                                </div>
                                <form action="<?= base_url('EN/Dashboard/Upload_Category_resources') ?>" class="dropzone" id="fileupload">
                                    <input type="hidden" id="ca_t_id" name="ca_t_id" value="">
                                    <input type="hidden" id="file_type" name="file_type" value="">
                                    <input type="hidden" id="language" name="language" value="">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="showuploadedfiles" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="showuploadedfilesLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="showuploadedfilesLabel"> Uploaded Resources: </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body listofFiles row">
                        <!-- content -->
                    </div>
                </div>
            </div>
        </div>

        <div id="media_links" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="media_linksLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="media_linksLabel"> Media links: </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body medialinkslist row">
                        <!-- showing list -->
                    </div>
                </div>
            </div>
        </div>

        <div id="add_media_link" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="add_media_linkLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="add_media_linkLabel"> Upload Resources: </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card" style="border: 0px;box-shadow: 0px 0px 0px;">
                            <div class="card-body">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert"></button> </div>
                                <form id="media_link" class="needs-validation custom-validation repeater" novalidate>
                                    <input type="hidden" name="category_id" value="">
                                    <input type="hidden" name="language" value="">
                                    <div class="inner-repeater mb-4">
                                        <div data-repeater-list="media_link" class="inner form-group">
                                            <label class="form-label">Links :</label>
                                            <div data-repeater-item class="inner mb-3 row">
                                                <div class="col-md-10 col-8">
                                                    <input type="text" name="link_title" autocomplete="off" class="inner form-control" placeholder="Link title" />
                                                    <input type="url" parsley-type="url" name="media_link" type="url" autocomplete="off" required="" class="mt-1 inner form-control linkinput" placeholder="https://www.youtube.com/url" />
                                                    <span class="error error-text"></span>
                                                </div>
                                                <div class="col-md-2 col-4 d-grid">
                                                    <button data-repeater-delete type="button" class="btn btn-danger btn-block inner"><i class="uil uil-trash"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <input data-repeater-create type="button" class="btn btn-success inner" value="Add another link " />
                                        <button class="btn btn-primary" id="Teachersub" type="Submit">Submit form</button>
                                        <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table class="table">
                                <thead>
                                    <th>#</th>
                                    <th>Category EN</th>
                                    <th>Category AR</th>
                                    <th>Action EN</th>
                                    <th>Action AR</th>
                                    <th>Report EN</th>
                                    <th>Report AR</th>
                                    <th>Media EN</th>
                                    <th>Media AR</th>
                                    <th>Edit Labels</th>
                                    <th>Icon EN</th>
                                    <th>Icon AR</th>
                                </thead>
                                <tbody>
                                    <?php foreach ($Categorys as $key => $Category) { ?>
                                        <tr>
                                            <td><?= $key + 1 ?></td>
                                            <td><?= $Category['Cat_en'] ?></td>
                                            <td><?= $Category['Cat_ar'] ?></td>
                                            <td class="text-center">
                                                <span class="upload" data-toggle="modal" data-target="#uploadresorces">
                                                    <i class="uil uil-file upload" data-toggle="tooltip" data-placement="top" title="" data-original-title="Upload resorces" data-cat-id="<?= $Category['Id'] ?>" data-file-type="1" data-language="EN"></i>
                                                </span>
                                                <span data-toggle="modal" data-target="#showuploadedfiles">
                                                    <i class="uil uil-servers able_to_download" data-toggle="tooltip" data-placement="top" data-original-title="show files"></i>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="upload" data-toggle="modal" data-target="#uploadresorces">
                                                    <i class="uil uil-file upload" data-toggle="tooltip" data-placement="top" title="" data-original-title="Upload AR resorces" data-cat-id="<?= $Category['Id'] ?>" data-file-type="1" data-language="AR"></i>
                                                </span>
                                                <span data-toggle="modal" data-target="#showuploadedfiles">
                                                    <i class="uil uil-servers able_to_download" data-toggle="tooltip" data-placement="top" data-original-title="show files"></i>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="upload" data-toggle="modal" data-target="#uploadresorces">
                                                    <i class="uil uil-file upload" data-toggle="tooltip" data-placement="top" title="" data-original-title="Upload Report" data-cat-id="<?= $Category['Id'] ?>" data-file-type="2" data-language="EN"></i>
                                                </span>
                                                <span data-toggle="modal" data-target="#showuploadedfiles">
                                                    <i class="uil uil-servers able_to_download" data-toggle="tooltip" data-placement="top" data-original-title="show files"></i>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="upload" data-toggle="modal" data-target="#uploadresorces">
                                                    <i class="uil uil-file upload" data-toggle="tooltip" data-placement="top" title="" data-original-title="Upload  AR Report" data-cat-id="<?= $Category['Id'] ?>" data-file-type="2" data-language="AR"></i>
                                                </span>
                                                <span data-toggle="modal" data-target="#showuploadedfiles">
                                                    <i class="uil uil-servers able_to_download" data-toggle="tooltip" data-placement="top" data-original-title="show files"></i>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="media_upload" data-toggle="modal" data-target="#add_media_link">
                                                    <i class="uil uil-image-check media_upload" data-toggle="tooltip" data-placement="top" title="" data-original-title="Media EN" data-cat-id="<?= $Category['Id'] ?>" data-language="EN"></i>
                                                </span>
                                                <span class="media_upload" data-toggle="modal" data-target="#media_links" data-cat-id="<?= $Category['Id'] ?>" data-language="EN">
                                                    <i class="uil uil-list-ul able_to_open" data-toggle="tooltip" data-placement="top" title="" data-original-title="show links"></i>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="media_upload" data-toggle="modal" data-target="#add_media_link">
                                                    <i class="uil uil-image-check media_upload" data-toggle="tooltip" data-placement="top" title="" data-original-title="Media AR" data-cat-id="<?= $Category['Id'] ?>" data-language="AR"></i>
                                                </span>
                                                <span class="media_upload" data-toggle="modal" data-target="#media_links" data-cat-id="<?= $Category['Id'] ?>" data-language="AR">
                                                    <i class="uil uil-list-ul able_to_open" data-toggle="tooltip" data-placement="top" title="" data-original-title="show links"></i>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="edite_cat px-3 text-primary btn" data-toggle="modal" data-target="#myModal">
                                                    <i class="uil uil-pen font-size-18" data-toggle="tooltip" data-placement="top" data-original-title="Edit" data-cat-id="<?= $Category['Id'] ?>"></i>
                                                </span>
                                            </td>
                                            <td>
                                                <i data-lang="en" data-id="<?= $Category['Id'] ?>" class="uil uil-upload font-size-18 btn btn-success btn-rounded waves-effect waves-light icon-upload"></i>
                                                <i data-icon-link="<?= $Category['icon_en'] ?>" class="uil uil-link font-size-18 btn btn-success btn-rounded waves-effect waves-light show-media"></i>
                                            </td>
                                            <td>
                                                <i data-lang="ar" data-id="<?= $Category['Id'] ?>" class="uil uil-upload font-size-18 btn btn-success btn-rounded waves-effect waves-light icon-upload"></i>
                                                <i data-icon-link="<?= $Category['icon_ar'] ?>" class="uil uil-link font-size-18 btn btn-success btn-rounded waves-effect waves-light show-media"></i>
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
    </div>
</div>
<script src="<?= base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/libs/select2/js/select2.min.js'); ?>"></script>
<script src="<?= base_url() ?>assets/libs/toastr/build/toastr.min.js"></script>
<script src="<?= base_url() ?>assets/libs/datatables.net-autoFill/js/dataTables.autoFill.min.js"></script>
<script src="<?= base_url() ?>assets/libs/datatables.net-autoFill-bs4/js/autoFill.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="<?= base_url("assets/libs/dropzone/min/dropzone.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/jquery.repeater/jquery.repeater.min.js"); ?>"></script>
<script src="<?= base_url("assets/js/pages/form-repeater.int.js") ?>"></script>
<script src="<?= base_url("assets/libs/toastr/build/toastr.min.js") ?>"></script>

<script>
    $('.alert').slideUp();
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": 300,
        "hideDuration": 1000,
        "timeOut": 5000,
        "extendedTimeOut": 1000,
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    $('#myModal input').each(function() {
        $(this).on('keypress keydown keyup', function() {
            if ($('input[name="en_title"]').val().length > 0 && $('input[name="ar_title"]').val().length) {
                $('.code').slideDown();
            } else {
                $('.code').slideUp();
            }
        });
    });
    $('.table').DataTable();
    $(".table").on('click', ".upload", function(e) {
        $('#ca_t_id').attr('value', $(this).attr('data-cat-id'));
        $('#file_type').attr('value', $(this).attr('data-file-type'));
        $('#language').attr('value', $(this).attr('data-language'));
        Dropzone.forElement('#fileupload').removeAllFiles(); // remove old files from the upload form
    });
    $(".table").on('click', ".media_upload", function(e) {
        // category_id
        // language
        $('#add_media_link input[name="category_id"]').attr('value', $(this).attr('data-cat-id'));
        $('#add_media_link input[name="language"]').attr('value', $(this).attr('data-language'));
        $('#add_media_link .alert').slideUp();
        $('.linkinput').val('');
        // removing the old inputs
        var count = 0;
        if ($('.linkinput').length > 0) {
            $('.linkinput').each(function() {
                count++;
                if (count !== 1) {
                    $(this).parents('.inner').first().remove('');
                }
            });
        } else {
            console.log($('.linkinput').length);
        }
    });
    $(".table").on('click', ".edite_cat", function(e) {
        $('#myModal input[name="cat_id"]').attr('value', $(this).attr('data-cat-id'));
        $('#myModal input[name="cat_id"]').attr('value', $(this).children('i').attr('data-cat-id'));
        $('#myModal').attr('data-for', "Update");
        $('#add_category').attr('data-for', "Update");
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/Dashboard/Category',
            data: {
                for_get: true,
                cat_id: $(this).children('i').attr('data-cat-id'),
            },
            success: function(data) {
                console.log(data.status);
                $('#myModalLabel').html('Update Category');
                if (data.status == "ok") {
                    if (data.category_data.length > 0) {
                        setOldDataInInputs(data.category_data[0]); // this function set each input with the correct data
                    } else {
                        location.reload();
                    }
                } else {
                    Swal.fire({
                        title: 'Sorry !',
                        text: 'We have unexpexted error in getting the data ',
                        icon: 'error'
                    });
                }
            },
            ajaxError: function() {
                Swal.fire({
                    title: 'Sorry !',
                    text: 'We have unexpexted error in getting the data ',
                    icon: 'error'
                });
            }
        });
    });
    $('.floating_action_btn').click(function() {
        $('#myModal').attr('data-for', "Creat");
        $('#myModalLabel').html('Add a Category');
        setOldDataInInputs();
    });
    $(".table").on('click', ".delete", function(e) {
        var cat_id = $(this).attr('data-cat-id');
        Swal.fire({
            title: 'هل أنت متأكد',
            text: "لن تتمكن من التراجع عن هذا!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'نعم,أحذفها!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success mt-2',
            cancelButtonClass: 'btn btn-danger ms-2 mt-2 ml-1',
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: 'DELETE',
                    url: '<?= base_url(); ?>EN/Dashboard/Category',
                    data: {
                        category_id: cat_id,
                    },
                    beforeSend: function() {
                        $('#statusbox').css('display', 'block');
                        $('#statusbox').html('<p style="width: 100%;margin: 0px;"> please wait !!</p>');
                    },
                    success: function(data) {
                        if (data == "ok") {
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'The Category has been deleted.',
                                icon: 'success'
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            Swal.fire({
                                title: 'Sorry !',
                                text: 'We have an error in processing this request',
                                icon: 'error'
                            });
                        }
                    },
                    ajaxError: function() {
                        Swal.fire({
                            title: 'Sorry !',
                            text: 'We have an error in processing this request',
                            icon: 'error',
                            footer: "Please try again later"
                        });
                    }
                });
            }
        });
    });

    $("#add_category").on('submit', function(e) {
        var action = $(this).attr('data-for');
        e.preventDefault();
        var data = new FormData(this);
        if ($('#add_category').attr('data-for') == "Update") {
            data.append('RequestFor', 'Update');
            var action = "Updated";
        } else {
            data.append('RequestFor', 'Add');
            var action = "Added";
        }
        console.log(data);
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/Dashboard/Category',
            data: data,
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data.status == "ok") {
                    Swal.fire({
                        title: action,
                        text: 'The Category has been ' + action + ' .',
                        icon: 'success'
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    Swal.fire({
                        title: 'Sorry !',
                        text: 'We have an error in processing this request',
                        icon: 'error',
                        footer: "more detailes :" + data.message,
                    });
                }
            },
            ajaxError: function() {
                Swal.fire({
                    title: 'Sorry !',
                    text: 'We have an error in processing this request',
                    icon: 'error',
                    footer: "Please try again later"
                });
            }
        });
    });

    $("#update_resources").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/Dashboard/Upload_Category_resources',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                console.log(data.status);
                if (data.status == "ok") {
                    Swal.fire({
                        title: 'Added !',
                        text: 'The resource has been Added .',
                        icon: 'success'
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    $('#uploadresorces .alert').html(data.messages.error);
                    $('#uploadresorces .alert').slideDown();
                }
            },
            ajaxError: function() {
                $('#StatusBox').css('background-color', '#B40000');
                $('#StatusBox').html("Ooops! Error was found.");
            }
        });
    });

    function isUrlValid(url) {
        return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
    }

    $("#media_link").on('submit', function(e) {
        e.preventDefault();
        $('.inner .error').html(''); // reset errors messages
        var $this = $(this);
        var errors = 0;
        var data = new FormData(this);
        var oldLinks = [];
        $('.linkinput').each(function() {
            var val = $(this).val();
            if (!isUrlValid(val)) {
                errors++;
                $(this).parents('.inner').first().children().find(".error").html("Please enter valid url");
                // $(this).parents('.inner').first().children('.error').html();
                console.log("error");
            }
            if (oldLinks.includes(val)) {
                errors++;
                $('#add_media_link .alert').slideDown();
                $('#add_media_link .alert').html("Please don't enter duplicated values");
            } else {
                oldLinks.push(val)
            }
        });
        if (errors == 0) {
            $($this).children().find('button[type="Submit"]').attr('disabled', '');
            $($this).children().find('button[type="Submit"]').html('Please wait...');
            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>EN/Dashboard/Upload_media_link',
                data: data,
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $($this).children().find('button[type="Submit"]').removeAttr('disabled');
                    $($this).children().find('button[type="Submit"]').html('save');
                    console.log(data.status);
                    if (data.status == "ok") {
                        Swal.fire({
                            title: 'Added !',
                            text: 'The resource has been Added .',
                            icon: 'success'
                        });
                        setTimeout(() => {
                            $('#add_media_link').modal('hide');
                        }, 1000);
                    } else {
                        $('#add_media_link .alert').html(data.messages.error);
                        $('#add_media_link .alert').slideDown();
                    }
                },
                ajaxError: function() {
                    $('#StatusBox').css('background-color', '#B40000');
                    $('#StatusBox').html("Ooops! Error was found.");
                }
            });
        }
    });


    function setOldDataInInputs(data = []) {
        if (Object.keys(data).length > 0) { // when there is new data
            // en edition
            $('#myModal input[name="Title_EN"]').attr('value', data.Cat_en);
            $('#myModal input[name="Action_EN"]').attr('value', data.action_name_en);
            $('#myModal input[name="Report_EN"]').attr('value', data.report_name_en);
            $('#myModal input[name="Media_EN"]').attr('value', data.media_name_en);
            $('#myModal input[name="Media_EN"]').attr('value', data.media_name_en);
            // Ar edition
            $('#myModal input[name="Title_AR"]').attr('value', data.Cat_ar);
            $('#myModal input[name="Action_AR"]').attr('value', data.action_name_ar);
            $('#myModal input[name="Report_AR"]').attr('value', data.report_name_ar);
            $('#myModal input[name="Media_AR"]').attr('value', data.media_name_ar);
            $('#myModal input[name="Media_AR"]').attr('value', data.media_name_ar);
        } else {
            // en edition
            $('#myModal input[name="Title_EN"]').attr('value', "");
            $('#myModal input[name="Action_EN"]').attr('value', "");
            $('#myModal input[name="Report_EN"]').attr('value', "");
            $('#myModal input[name="Media_EN"]').attr('value', "");
            $('#myModal input[name="Media_EN"]').attr('value', "");
            // Ar edition
            $('#myModal input[name="Title_AR"]').attr('value', "");
            $('#myModal input[name="Action_AR"]').attr('value', "");
            $('#myModal input[name="Report_AR"]').attr('value', "");
            $('#myModal input[name="Media_AR"]').attr('value', "");
            $('#myModal input[name="Media_AR"]').attr('value', "");
        }
    }

    // Add restrictions
    Dropzone.options.fileupload = {
        acceptedFiles: 'image/*,application/pdf,.psd',
        maxFilesize: 50, // MB ,
    };
    $(".table").on('click', ".able_to_download", function(e) {
        $('.listofFiles').html('Please wait ....');
        const category_id = $(this).parents("td").children().first(".upload").children().attr("data-cat-id");
        const language = $(this).parents("td").children().first(".upload").children().attr("data-language");
        const file_type = $(this).parents("td").children().first(".upload").children().attr("data-file-type");
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/Dashboard/Upload_Category_resources',
            data: {
                category_id: category_id,
                language: language,
                file_type: file_type,
            },
            success: function(data) {
                $('.listofFiles').html('');
                console.log(data.status);
                if (data.status == "ok") {
                    if (data.list.length > 0) {
                        data.list.forEach(file => {
                            var new_html = "";
                            new_html += '<div class="col-md-6 col-xl-4">';
                            new_html += '<div class="card">';
                            new_html += '<i class="uil uil-trash delete" data-file-id="' + file.Id + '" ></i>';
                            new_html += '<label class="switch">';
                            new_html += '<input type="checkbox" class="FileStatus"  ' + (file.status == "1" ? 'checked' : '') + ' data-file-id="' + file.Id + '">';
                            new_html += '<span class="slider round"></span>';
                            new_html += '</label>';
                            new_html += '<div class="avatar-lg mx-auto mb-4 mt-5"> <div class="avatar-title bg-soft-primary rounded-circle text-primary"><i class="mdi mdi-file-chart display-4 m-0 text-primary"></i> </div></div>';
                            if (file.file_type == "1") {
                                new_html += '<h6 class="text-center"><a href="<?= base_url('uploads/Category_resources/') ?>' + file.file_language + '/' + file.file_url + '">File link</a></h6>';
                            } else {
                                new_html += '<h6 class="text-center"><a href="<?= base_url('uploads/Reports_resources/') ?>' + file.file_language + '/' + file.file_url + '">File link</a></h6>';
                            }
                            new_html += '<div class="card-body">';
                            if (file.file_language == "EN") {
                                new_html += '<input type="text" name="title" data-file-id="' + file.Id + '" value="' + file.file_name_en + '" class="form-control mb-1 titleinput">';
                            } else {
                                new_html += '<input type="text" name="title" data-file-id="' + file.Id + '" value="' + file.file_name_ar + '" class="form-control mb-1 titleinput">';
                            }
                            new_html += '<span class="error text-error"></span>'
                            new_html += '<button type="button" class="btn btn-success waves-effect waves-light w-100 mt-1 hidden" data-file-id="' + file.Id + '" data-file-lang="' + file.file_language + '" >update</button>';
                            new_html += '</div></div></div>';
                            $('.listofFiles').append(new_html);
                        });
                    } else {
                        $('.listofFiles').html('<h3>No data Found</h3>')
                    }
                } else {
                    Swal.fire({
                        title: 'sorry !',
                        text: 'We have an error in processing this request',
                        icon: 'error'
                    });
                }
            },
            ajaxError: function() {
                $('#StatusBox').css('background-color', '#B40000');
                $('#StatusBox').html("Ooops! Error was found.");
            }
        });
    });

    var new_val = "";
    var id = '';
    var title_language = '';
    $('.listofFiles').on('keyup', '.titleinput', function() {
        new_val = $(this).val();
        id = $(this).attr('data-file-id');
        title_language = $(this).attr('data-title-language');
        if (new_val.length > 3) {
            $(this).removeClass('parsley-error');
            $(this).parents().children('.error').html("");
            $(this).parents().children('.btn-success').removeClass("hidden");
            $(".titleinput btn-success").addClass("hidden");
        } else {
            $(this).addClass('parsley-error');
            $(this).parents().children('.error').html("this title is very short, please write 3 characters at least");
            $(this).parents().children('.btn-success').addClass("hidden");
            $(".titleinput btn-success").removeClass("hidden");
        }
    });

    $('.listofFiles').on('click', '.btn-success', function() {
        var $this = $(this);
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/Dashboard/update_Category_resource_title',
            data: {
                file_id: $(this).attr('data-file-id'),
                new_title: new_val,
                language: $(this).attr("data-file-lang"),
            },
            success: function(data) {
                if (data.status == "ok") {
                    $($this).html('updeted successfully <i class="uil uil-check"></i>');
                    setTimeout(function() {
                        $($this).addClass('hidden');
                    }, 800);
                } else {
                    Swal.fire({
                        title: 'sorry !',
                        text: 'We have an error in processing this request',
                        icon: 'error'
                    });
                }
            },
            ajaxError: function() {
                $('#StatusBox').css('background-color', '#B40000');
                $('#StatusBox').html("Ooops! Error was found.");
            }
        });
    });

    $('.listofFiles').on('click', '.delete', function() {
        var file_id = $(this).attr('data-file-id');
        var $this = $(this);
        Swal.fire({
            title: 'هل أنت متأكد',
            text: "لن تتمكن من التراجع عن هذا!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'نعم,أحذفها!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success mt-2',
            cancelButtonClass: 'btn btn-danger ms-2 mt-2',
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: 'DELETE',
                    url: '<?= base_url(); ?>EN/Dashboard/update_Category_resource_title',
                    data: {
                        file_id: file_id,
                    },
                    success: function(data) {
                        if (data.status == "ok") {
                            $($this).parents('.col-md-6.col-xl-4').slideUp();
                            setTimeout(() => {
                                $($this).remove();
                            }, 800);
                        } else {
                            Swal.fire({
                                title: 'sorry !',
                                text: 'We have an error in processing this request',
                                icon: 'error'
                            });
                        }
                    },
                    ajaxError: function() {
                        $('#StatusBox').css('background-color', '#B40000');
                        $('#StatusBox').html("Ooops! Error was found.");
                    }
                });
            }
        });
    });

    $('.table').on('click', '.able_to_open', function() {
        const linkId = $(this).parents("td").children().first(".media_upload").children().attr("data-cat-id");
        const language = $(this).parents("td").children().first(".media_upload").children().attr("data-language");
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/Dashboard/medialinks',
            data: {
                category: linkId,
                language: language,
            },
            success: function(data) {
                $('.medialinkslist').html('');
                console.log(data.status);
                if (data.status == "ok") {
                    console.log(data.list);
                    if (data.list.length > 0) {
                        data.list.forEach(media => {
                            var youtube_video_id = media.link.match(/youtube\.com.*(\?v=|\/embed\/)(.{11})/).pop();
                            var new_html = '';
                            new_html += '<div class="col-md-6 col-xl-4">';
                            new_html += '<div class="card">';
                            new_html += '<i class="uil uil-trash delete" data-link-id="' + media.Id + '"></i>';
                            new_html += '<label class="switch">';
                            new_html += '<input type="checkbox" class="MediaStatus"  ' + (media.status == "1" ? 'checked' : '') + ' data-file-id="' + media.Id + '">';
                            new_html += '<span class="slider round"></span>';
                            new_html += '</label>';
                            new_html += '<img class="card-img-top img-fluid" src="https://img.youtube.com/vi/' + youtube_video_id + '/0.jpg">';
                            new_html += '<div class="card-body">';
                            new_html += '<p data-link-id="' + media.Id + '">' + media.title + '</p>';
                            new_html += '<a href="' + media.link + '" target="_blank" class="btn btn-primary waves-effect waves-light w-100 mt-1">open</a>';
                            new_html += '</div></div></div>';
                            $('.medialinkslist').append(new_html);
                        });
                    } else {
                        $('.medialinkslist').html('<h3> No Links Found </h3>')
                    }
                } else {
                    Swal.fire({
                        title: 'sorry !',
                        text: 'We have an error in processing this request',
                        icon: 'error'
                    });
                }
            },
            ajaxError: function() {
                $('#StatusBox').css('background-color', '#B40000');
                $('#StatusBox').html("Ooops! Error was found.");
            }
        });
    });

    $('.medialinkslist').on('click', '.delete', function() {
        var LinkId = $(this).attr('data-link-id');
        var $this = $(this);
        Swal.fire({
            title: 'هل أنت متأكد',
            text: "لن تتمكن من التراجع عن هذا!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'نعم,أحذفها!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success mt-2',
            cancelButtonClass: 'btn btn-danger ms-2 mt-2',
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: 'DELETE',
                    url: '<?= base_url(); ?>EN/Dashboard/medialinks',
                    data: {
                        linkId: LinkId,
                    },
                    success: function(data) {
                        if (data.status == "ok") {
                            $($this).parents('.col-md-6.col-xl-4').slideUp();
                            setTimeout(() => {
                                $($this).remove();
                            }, 800);
                        } else {
                            Swal.fire({
                                title: 'sorry !',
                                text: 'We have an error in processing this request',
                                icon: 'error'
                            });
                        }
                    },
                    ajaxError: function() {
                        $('#StatusBox').css('background-color', '#B40000');
                        $('#StatusBox').html("Ooops! Error was found.");
                    }
                });
            } 
        });
    });


    $('.listofFiles').on('change', '.FileStatus', function() {
        var fileId = $(this).attr('data-file-id');
        $.ajax({
            type: "PUT",
            url: "<?= base_url("EN/Dashboard/Upload_Category_resources"); ?>",
            data: {
                id: fileId
            },
            success: function(response) {
                if (response == "error") {
                    alert('Sorry we have an error , please try again later');
                }
            }
        });
    });
    /**                */
    $('.listofFiles').on('change', '.MediaStatus', function() {
        var fileId = $(this).attr('data-file-id');
        $.ajax({
            type: "PUT",
            url: "<?= base_url("EN/Dashboard/medialinks"); ?>",
            data: {
                id: fileId
            },
            success: function(response) {
                if (response == "error") {
                    alert('Sorry we have an error , please try again later');
                }
            }
        });
    });

    $('.icon-upload').click(function() {
        var id = $(this).attr('data-id');
        $('#UploadIcon').modal('show');
        $('#UploadIcon input[name="activeCategory"]').val(id);
        $('#UploadIcon input[name="activeLanguage"]').val($(this).attr('data-lang'));
    });

    $('.show-media').click(function() {
        var url = $(this).attr('data-icon-link');
        $('#ShowIcon').modal('show');
        if(url.length > 0){
            $('#ShowIcon h3').hide();
            $('#ShowIcon img').show();            
            $('#ShowIcon img').attr("src" , '<?= base_url('uploads/category_choices_icons/') ?>' + url);
        }else{
            $('#ShowIcon img').hide();
            $('#ShowIcon h3').show();
        }
    });

    $("#UploadIcon form").submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "<?= current_url(); ?>",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                if (response.status == "ok") {
                    Command: toastr["success"]("The Icon has been successfully updated ");
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                }
                else {
                    Command: toastr["error"](response.message);
                }
            }
        });
    });
</script>