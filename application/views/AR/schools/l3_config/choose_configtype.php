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
</style>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="col-lg-6 offset-lg-1 centered pt-2">
			
                <div class="row">
				
                    <div class="col-md-6 col-xl-6">
					<h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">إدارة الموارد</h4>
                        <div class="card manage_about_us">
                            <img class="card-img-top img-fluid" src="<?= base_url("assets/images/articles.jpg"); ?>" alt="Card image cap">
                            <div class="card-body">
                                <h4 class="card-title mt-0 text-center mb-2">إدارة الموارد</h4>
                                <hr>
                                <button class="btn btn-success waves-effect waves-light w-100 select" data-link="manage_about_us">
									<i class="uil uil-check-circle ms-2"></i>تحديد </button> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid text-center">
                    <a href="" class="btn btn-light btn-rounded waves-effect p-3 nextPage">الانتقال إلى الخطوة التالية</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // bg-success
    $('.select').click(function() {
        var link = $(this).attr('data-link');
        $('.card').removeClass('bg-success');
        $('.' + link).addClass('bg-success');
        // showing next page buttons
        $('.nextPage').css("transform", 'scale(1)');
        $('.nextPage').attr('href', '<?= base_url("AR/schools/") ?>' + link + '/' + "<?= $usertype ?>");
    });
</script>