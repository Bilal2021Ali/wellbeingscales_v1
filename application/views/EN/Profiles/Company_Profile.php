<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <link href="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" />
</head>

<body>
    <div class="main-content">

        <div class="page-content">
		
		<h4 class="card-title" style="background: #0eacd8;padding: 10px;color: #f5f6f8;border-radius: 4px;"> CO012: Profile Update - <?= $sessiondata['f_name']; ?> </h4>

            <div class="container-fluid">
                <div class="card">
                    <a class="text-dark">
                        <div class="p-4">
                            <div class="media align-items-center">
                                <div class="mr-3">
                                    <i class="uil uil-receipt text-primary h2"></i>
                                </div>

                                <div class="media-body overflow-hidden">
                                    <h5 class="font-size-16 mb-1"><?= $sessiondata['f_name'] ?></h5>
                                    <p class="text-muted text-truncate mb-0" id="StatusBox"> Update Data </p>
                                </div>
                            </div>
                        </div>
                    </a>
                    <div class="collapse show">
                        <div class="p-4 border-top">
                            <form id="Minstry_profile">
                                <div>
                                    <div class="row">
									        <div class="col-lg-4">
                                            <div class="form-group mb-4">
                                                 <label for="billing-name"> English Name: </label>
                                                <input type="text" class="form-control" placeholder="English Name" value="<?= $data['EN_Title']; ?>" name="EN_Title">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group mb-4">
                                                <label for="billing-name">Arabic Name:</label>
                                                <input type="text" class="form-control" placeholder="Arabic Name" value="<?= $data['AR_Title']; ?>" name="AR_Title">
                                            </div>
                                        </div>


                                        <div class="col-lg-4">
                                            <div class="form-group mb-4">
                                                <label for="billing-phone"> Phone: </label>
                                                <input type="text" class="form-control" placeholder="Phone " name="Phone" value="<?= $data['Tel']; ?>">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group mb-4 mb-lg-0">
                                                <label for="billing-city"> User Name: </label>
                                                <input type="text" class="form-control" placeholder="User Name cannot be changed" value="<?= $data['Username'] ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Sorry username cannot be changed" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group mb-0">
                                                <label for="zip-code">Manager Name:</label>
                                                <input type="text" class="form-control" name="Manager Name" placeholder="manager" value="<?= $data['Manager']; ?>">
                                            </div>
                                        </div>
										<div class="col-lg-4">
                                            <div class="form-group mb-0">
                                                <label for="zip-code">Company ID:</label>
                                                <input type="text" class="form-control" name="Manager Name" placeholder="manager" value="<?= $data['Id']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="Send" value="Send">
                                    <div class="row my-4">
                                        <div class="col">
                                            <a href="<?= base_url(); ?>EN/Company" class="btn btn-link text-muted">
                                                <i class="uil uil-arrow-left mr-1"></i> Cancel </a>
                                        </div> <!-- end col -->
                                        <div class="col">
                                            <div class="text-sm-right mt-2 mt-sm-0">
                                                <a href="<?= base_url() ?>EN/Users/MyProfile"><button class="btn" name="Send" type="button">
                                                        <i class="uil uil-user mr-1"></i>More Options</button></a>
                                                <button class="btn btn-success" name="Send" type="Submit">
                                                    <i class="uil uil-save mr-1"></i> Save </button>
                                            </div>
                                        </div> <!-- end col -->
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
</body>

<script>
    $("#Minstry_profile").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/Company/UpdateMinstry_profile',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#StatusBox').html(data);

            },
            ajaxError: function() {
                $('#StatusBox').css('background-color', '#B40000');
                $('#StatusBox').html("Ooops! Error was found.");
            }
        });
    });
</script>

</html>