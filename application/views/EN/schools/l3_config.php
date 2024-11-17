<style>
    .centered {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .card .btn {
        font-size: 20px;
    }

    .card {
        border-width: 10px;
        border-color: transparent;
    }

    .card .img-fluid {
        border-radius: 5px;
    }

    .card.bg-success {
        border-color: #34c38f;
    }

    .card.bg-success h4 {
        color: #fff;
    }

    .card.bg-success .btn-primary {
        background-color: #34c38f;
        border-color: #fff;
        color: #fff;
    }

    .nextPage {
        transition: 0.2s all;
        transform: scale(0);
        max-width: 400px;
        width: 100%;
    }

    .bg-info {
        background-color: #8ee6ff !important;
    }
</style>
<div class="main-content">
    <div class="page-content"> <br>
        <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CH P017: Circulars</h4><br>
			<div class="row">
            <div class="col-12"><br>
                <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">Select the user then press next.​</h4>
                <div class="row">
                    <div class="col-md-3">
                        <div class="card staffs">
                            <img class="card-img-top img-fluid" src="<?= base_url("assets/images/staff101.png"); ?>" style="height: 50%; width: 100%; margin: 0; " alt="Card image cap">
                            <div class="card-body">
                                <?php /*?>                                <h4 class="card-title mt-0 text-center mb-2">STAFF</h4>
                                <hr><?php */ ?>
                                <button class="btn btn-info waves-effect waves-light w-100 select" data-type="Staff"><i class="uil uil-check-circle ms-2"></i> Select </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card parents">
                            <img class="card-img-top img-fluid" src="<?= base_url("assets/images/Parents101.png"); ?>" style="height: 50%; width: 100%; margin: 0; " alt="Card image cap">
                            <div class="card-body">
                                <?php /*?>                                <h4 class="card-title mt-0 text-center mb-2">PARENTS</h4>
                                <hr><?php */ ?>
                                <button class="btn btn-info waves-effect waves-light w-100 select" data-type="Parent"><i class="uil uil-check-circle ms-2"></i> Select </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card students">
                            <img class="" src="<?= base_url("assets/images/students101.png"); ?>" style="height: 50%; width: 100%; margin: 0; " alt="Card image cap">
                            <div class="card-body">
                                <?php /*?>                                <h4 class="card-title mt-0 text-center mb-2">STUDENTS</h4>
                                <hr><?php */ ?>
                                <button class="btn btn-info waves-effect waves-light w-100 select" data-type="Student"><i class="uil uil-check-circle ms-2"></i> Select </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card teachers">
                            <img class="card-img-top img-fluid" src="<?= base_url("assets/images/teachers101.png"); ?>" style="height: 50%; width: 100%; margin: 0; " alt="Card image cap">
                            <div class="card-body">
                                <?php /*?>                                <h4 class="card-title mt-0 text-center mb-2">TEACHERS</h4>
                                <hr><?php */ ?>
                                <button class="btn btn-info waves-effect waves-light w-100 select" data-type="Teacher"><i class="uil uil-check-circle ms-2"></i> Select </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid text-center">
                    <a href="" class="btn bg-info btn-rounded waves-effect p-3 nextPage">Go To Next Step</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // bg-success
    $('.select').click(function() {
        var type = $(this).attr('data-type');
        $('.card').removeClass('bg-info');
        $('.' + type).addClass('bg-info');
        // showing next page buttons
        $('.nextPage').css("transform", 'scale(1)');
        //l3_config
        $('.nextPage').attr('href', '<?= base_url("EN/schools/manage-about-us/") ?>' + type);
    });
</script>