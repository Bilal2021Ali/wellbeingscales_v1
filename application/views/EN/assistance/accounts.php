<style>
    * {
        transition: 0.3s all;
    }

    /* modal animation */
    .modal.fade .modal-dialog {
        -webkit-transform: translate(0, 0);
        transform: translate(0, 0);
    }

    .zoom-in {
        transform-origin: top;
        transform: scale(0) !important;
        opacity: 0;
        -webkit-transition: 0.5s all 0s;
        -moz-transition: 0.5s all 0s;
        -ms-transition: 0.5s all 0s;
        -o-transition: 0.5s all 0s;
        transition: 0.5s all 0s;
        display: block !important;
    }

    .zoom-in.show {
        opacity: 1;
        transform: scale(1) !important;
        transform: none;
    }

    .lds-ring {
        display: inline-block;
        position: relative;
        width: 80px;
        height: 80px;
        margin: auto;
    }

    .lds-ring div {
        box-sizing: border-box;
        display: block;
        position: absolute;
        width: 64px;
        height: 64px;
        margin: 8px;
        border: 8px solid #0eabd7;
        border-radius: 50%;
        animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        border-color: #14add8 transparent transparent transparent;
    }

    .lds-ring div:nth-child(1) {
        animation-delay: -0.45s;
    }

    .lds-ring div:nth-child(2) {
        animation-delay: -0.3s;
    }

    .lds-ring div:nth-child(3) {
        animation-delay: -0.15s;
    }

    @keyframes lds-ring {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .loading_data.active {
        display: grid;
    }

    .loading_data {
        display: none;
        width: 100%;
        height: 100%;
        align-items: center;
        align-content: center;
        text-align: center;
        position: absolute;
        left: 0;
        right: 0;
        background: #ffffffd9;
    }

    .dropdown.float-end {
        width: 10px;
    }

    .dropdown-item {
        cursor: pointer;
    }
</style>

<link rel="stylesheet" type="text/css" href="<?= base_url("assets/libs/toastr/build/toastr.min.css") ?>">
<script src="<?= base_url("assets/libs/toastr/build/toastr.min.js") ?>"></script>

<div class="main-content">
    <br>

    <div class="page-content">
        <h4 class="card-title"
            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
            CH 100: Sub Accounts</h4>
        <div class="row">

            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <?php $this->load->view('EN/assistance/inc/create') ?>
                </div>
            </div>
        </div>
        <div class="row">
            <?php foreach ($accounts as $i => $account) { ?>
                <div class="col-xl-3 col-sm-6 account-card" data-key="<?= $account['id'] ?>">
                    <div class="card text-center">
                        <div class="card-body">
                            <div class="dropdown float-end">
                                <a class="text-body dropdown-toggle font-size-16" href="#" role="button"
                                   data-toggle="dropdown" aria-haspopup="true">
                                    <i class="uil uil-ellipsis-h"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end">
    
                                    <span class="dropdown-item text-danger delete-account"
                                          data-key="<?= $account['id'] ?>">
                                        <i class="uil uil-trash"></i> | Delete
                                    </span>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="mb-4">
                                <img src="<?= !empty($account['avatar']) ? $account['avatar'] : ("https://ui-avatars.com/api/?size=128&background=random&name=" . $account['name']) ?>"
                                     alt=""
                                     class="avatar-lg rounded-circle img-thumbnail">
                            </div>
                            <h5 class="font-size-16 mb-1">
                                <span href="#" class="text-dark">
                                    <?= $account['name'] ?>
                                </span>
                            </h5>
                            <p class="text-muted mb-2"><?= $account['username'] ?></p>
                        </div>

                        <div class="btn-group" role="group">
                            <a href="<?= base_url('EN/schools/assistance-account/' . $account['id'] . "/permissions") ?>"
                               type="button" class="btn btn-outline-light text-truncate">
                                <i class="uil uil-user me-1"></i>
                                Permissions
                            </a>
                            <button type="button" data-key="<?= $account['id'] ?>"
                                    class="btn account-status btn-outline-light text-truncate <?= intval($account['status']) === 1 ? "text-success bg-soft-success" : "text-danger bg-soft-danger" ?>">
                                <?php if (intval($account['status']) === 1) { ?>
                                    <i class="uil uil-check me-1"></i> Active
                                <?php } else { ?>
                                    <i class="uil uil-times me-1"></i> Deactivated
                                <?php } ?>
                            </button>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<script>
    $(".edit-profile").click(function () {
        const id = $(this).data("key");
        $(".loading_data").addClass('active');
        $('#subAccountForm .default-password-hint').slideUp();
        $.get("<?= base_url('EN/schools/assistance-account/') ?>" + id + "/profile", function (response) {
            if (response.status === "error") {
                command: toastr['error'](response.message);
                $("#subAccountForm").modal('hide');
                return;
            }
            $('#subAccountForm input[name="name"]').val(response.data.name);
            $('#subAccountForm input[name="username"]').val(response.data.username);
            $('#subAccountForm textarea[name="role"]').val(response.data.role);
            $('#subAccountForm input[name="_activeAccount"]').val(id);
            $(".loading_data").removeClass('active');
        });
        $("#subAccountForm").modal('show');
    });

    $(".delete-account").click(function () {
        const id = $(this).data("key");
        Swal.fire({
            title: "Are You Sure?",
            html: "This Action can't be undone ! consider disabling the account instead.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#f46a6a",
            cancelButtonColor: "#34c38f",
            confirmButtonText: "Delete"
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    url: "<?= current_url() ?>" + "/" + id,
                    type: 'DELETE',
                    success: function (response) {
                        if (response.status === 'ok') {
                            $('.account-card[data-key="' + id + '"]').slideUp().remove();
                            command: toastr['success']("Account Deleted Successfully.");
                        } else {
                            command: toastr['error'](response.message);
                        }
                    },
                });
            }
        });
    });

    $(".account-status").click(function () {
        const id = $(this).data("key");
        $('.account-card[data-key="' + id + '"] .account-status').html('updating...');
        $.ajax({
            url: "<?= current_url() ?>" + "/" + id,
            type: 'POST',
            success: function (response) {
                if (response.status === 'ok') {
                    $('.account-card[data-key="' + id + '"] .account-status').removeClass("text-success bg-soft-success text-danger bg-soft-danger");
                    if (response.to === 1) {
                        $('.account-card[data-key="' + id + '"] .account-status').addClass("text-success bg-soft-success").html('<i class="uil uil-check me-1"></i> Active');
                    } else {
                        $('.account-card[data-key="' + id + '"] .account-status').addClass("text-danger bg-soft-danger").html('<i class="uil uil-times me-1"></i> Deactivated');
                    }
                } else {
                    command: toastr['error'](response.message);
                }
            },
        });

    });
</script>