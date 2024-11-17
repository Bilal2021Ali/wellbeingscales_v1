<style>
    .centered {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .card .btn{ 
        font-size: 20px;
    }

    .card {
        border-width: 10px;
        border-color : transparent;
    }

    .card .img-fluid{
        border-radius: 5px;
    }

    .card.bg-success {
        border-color : #34c38f;
    }

    .card.bg-success h4 {
        color: #fff;
    }

    .card.bg-success .btn-primary  {
        background-color: #34c38f ;
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
            <div class="col-lg-8 offset-lg-1 centered pt-2">
                <h2 class="text-center">This Survey for:</h2>
                <hr>
                <div class="row">
                    <div class="col-md-6 col-xl-6">
                        <div class="card parents">
                            <img class="card-img-top img-fluid" src="<?= base_url("assets/images/Parents-Day.jpg"); ?>" alt="Card image cap" style="height:287px">
                            <div class="card-body">
                                <h4 class="card-title mt-0 text-center mb-2">For Parent</h4>
                                <hr>
                                <button class="btn btn-success waves-effect waves-light w-100 select" data-type="parents"><i class="uil uil-check-circle ms-2"></i> select </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-6">
                        <div class="card teachers">
                            <img class="card-img-top img-fluid" src="<?= base_url("assets/images/if_teachers-vaccin_01.png"); ?>" style="height:287px" alt="Card image cap">
                            <div class="card-body">
                                <h4 class="card-title mt-0 text-center mb-2">For Teacher</h4>
                                <hr>
                                <button class="btn btn-success waves-effect waves-light w-100 select" data-type="teachers"><i class="uil uil-check-circle ms-2"></i> select </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid text-center">
                <a href="" class="btn btn-light btn-rounded waves-effect p-3 nextPage">Go To next step</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // bg-success
    $('.select').click(function(){
        var type = $(this).attr('data-type');
        $('.card').removeClass('bg-success');
        $('.' + type).addClass('bg-success');
        // showing next page buttons
        $('.nextPage').css("transform" , 'scale(1)');
        $('.nextPage').attr( 'href','<?= base_url("EN/schools/DedicatedSurveys/") ?>' + type);
    });
</script>