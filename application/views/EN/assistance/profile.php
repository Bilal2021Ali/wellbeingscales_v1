<link rel="stylesheet" type="text/css" href="<?= base_url("assets/libs/toastr/build/toastr.min.css") ?>">
<script src="<?= base_url("assets/libs/toastr/build/toastr.min.js") ?>"></script>

<style>
    .separator {
        margin: 15px 2px;
        display: flex;
        align-items: center;
        text-align: center;
    }

    .separator::before,
    .separator::after {
        content: '';
        flex: 1;
        border-bottom: 1px solid #919191;
    }

    .separator:not(:empty)::before {
        margin-right: .25em;
    }

    .separator:not(:empty)::after {
        margin-left: .25em;
    }
</style>

<body class="authentication-bg">
<?php $user = $this->db
    ->join("v_login", "v_login.Id = v_sub_accounts.loginKey")
    ->where("v_sub_accounts.id", $sessiondata['assistanceAccountId'])
    ->limit(1)
    ->get("v_sub_accounts")->row() ?>
<div class="account-pages my-5  pt-sm-5">
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-8 col-lg-6 col-xl-5">
                <?php if (!empty($user)) { ?>
                    <div class="card">
                        <div class="card-body p-4">
                            <form id="profileChanges">
                                <div class="form-group">
                                    <label>Name :</label>
                                    <input type="text" class="form-control" name="name" value="<?= $user->name ?>">

                                    <label>username :</label>
                                    <input type="text" class="form-control" name="username"
                                           value="<?= $user->Username ?>">
                                    <div class="col-12">
                                        <span class="float-right text-primary btn change-pwd">Change Password</span>
                                    </div>
                                    <input type="checkbox" hidden name="editingPassword">
                                    <div class="password-edit" style="display: none">
                                        <label>Old Password :</label>
                                        <input type="text" class="form-control" name="old-password" value="">

                                        <label>New Password :</label>
                                        <input type="text" class="form-control" name="new-password" value="">

                                        <label>Confirm The New Password :</label>
                                        <input type="text" class="form-control" name="password-confirm" value="">
                                    </div>
                                    <button class="btn btn-primary w-sm waves-effect waves-light btn-block mt-2"
                                            type="Submit"
                                            name="Submit" id="sub">Save Change.
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(".change-pwd").click(function () {
        const editingPassword = $("input[name='editingPassword']");
        editingPassword.attr("checked", !editingPassword.attr("checked"));
        $(".password-edit").slideToggle();
    });

    $("#profileChanges").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= base_url("EN/Users/assistance-account-update"); ?>',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $('#sub').removeAttr('disabled');
                $('#sub').html('Submit !');
                if (data.status === 'ok') {
                    command: toastr['success']("Changes Has Been Successfully.");
                } else {
                    command: toastr['error'](data.message);
                }
            },
            beforeSend: function () {
                $('#sub').attr('disabled', '');
                $('#sub').html('Please wait.');
            }
        });
    });
</script>
</body>