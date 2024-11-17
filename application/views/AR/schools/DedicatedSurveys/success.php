<style>
    body {
        font-family: 'Varela Round', sans-serif;
    }

    .modal-confirm {
        color: #636363;
        width: 325px;
        font-size: 14px;
    }

    .modal-confirm .modal-content {
        padding: 20px;
        border-radius: 5px;
        border: none;
    }

    .modal-confirm .modal-header {
        border-bottom: none;
        position: relative;
    }

    .modal-confirm h4 {
        text-align: center;
        font-size: 26px;
        margin: 30px 0 -15px;
    }

    .modal-confirm .form-control,
    .modal-confirm .btn {
        min-height: 40px;
        border-radius: 3px;
    }

    .modal-confirm .close {
        position: absolute;
        top: -5px;
        right: -5px;
    }

    .modal-confirm .modal-footer {
        border: none;
        text-align: center;
        border-radius: 5px;
        font-size: 13px;
    }

    .modal-confirm .icon-box {
        color: #fff;
        position: absolute;
        margin: 0 auto;
        left: 0;
        right: 0;
        top: -70px;
        width: 95px;
        height: 95px;
        border-radius: 50%;
        z-index: 9;
        background: #82ce34;
        padding: 15px;
        text-align: center;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
    }

    .modal-confirm .icon-box i {
        font-size: 58px;
        position: relative;
        top: -10px;
    }

    .modal-confirm.modal-dialog {
        margin-top: 80px;
    }

    .modal-confirm .btn {
        color: #fff;
        border-radius: 4px;
        background: #82ce34;
        text-decoration: none;
        transition: all 0.4s;
        line-height: normal;
        border: none;
    }

    .modal-confirm .btn:hover,
    .modal-confirm .btn:focus {
        background: #6fb32b;
        outline: none;
    }

    .trigger-btn {
        display: inline-block;
        margin: 100px auto;
    }

    .modal {
        top: 90px;
    }
</style>
<div class="modal-backdrop fade show"></div>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="col-lg-8 offset-lg-1">
                <div id="myModal" class="modal fade show"  aria-modal="true" role="dialog" style="display: block;">
                    <div class="modal-dialog modal-confirm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="icon-box">
                                    <i class="material-icons uil uil-check"></i>
                                </div>
                                <h4 class="modal-title w-100">ممتاز!</h4>
                            </div>
                            <div class="modal-body">
                                <p class="text-center">تم نشر الاستطلاع الخاص بك.</p>
                            </div>
                            <div class="modal-footer">
                                <a href="<?= base_url("AR/schools/DedicatedSurveys"); ?>" class="btn btn-success btn-block" data-dismiss="modal">نعم</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>