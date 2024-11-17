<style>
    .delete-account {
        position: absolute;
        top: 26px;
        right: 14px;
        cursor: pointer;
    }

    .disable {
        display: none;
    }

    .select2-container {
        width: 100% !important;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
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
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #00bd06;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #00bd06;
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

    .switch.targeted-status {
        float: right;
        margin-top: -16px;
    }
</style>
<button class="btn w-100 btn-success waves-effect mb-1" id="targetedaccount-switch"><i class="uil uil-plus"></i>Toggle Add/list </button>
<div id="targetedaccountslist-15552">
    <?php foreach ($TargetedAccountsList as $TargetedAccount) { ?>
        <div class="card shadow-none">
            <div class="card-body">
                <p class="mb-0"><?= $TargetedAccount['name'] ?></p>
                <span><?= $TargetedAccount['AddedAt'] ?></span>
                <label class="switch targeted-status" data-key="<?= $TargetedAccount['connectionId'] ?>">
                    <input type="checkbox" name="ischecked" <?= $TargetedAccount['status'] == 1 ? 'checked' : '' ?>>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    <?php } ?>
</div>
<form id="targetedaccountslist-form-155410" class="disable">
    <label class="mt-2">Please select an account(s) :</label>
    <select name="account[]" class="form-control select2 w-100" multiple="multiple">
        <?php foreach ($accounts as $account) { ?>
            <option value="<?= $account['Id'] ?>"><?= $account['EN_Title'] ?></option>
        <?php } ?>
    </select>
    <Button type="submit" class="w-100 btn btn-primary mt-2">Save</Button>
</form>
<script>
    $('#targetedaccount-switch').click(function() {
        $('#targetedaccountslist-15552').toggle('hidden');
        $('#targetedaccountslist-form-155410').toggle('disable');
    });
    $(".select2").select2();

    $('.switch.targeted-status').change(function() {
        const id = $(this).attr('data-key');
        const $this = $(this);
        $.ajax({
            type: "DELETE",
            url: "<?= base_url('EN/Dashboard/TargetedAccounts/' . $SurveyType . "/" . $SurveyId) ?>",
            data: {
                id: id,
            },
            success: function(response) {
                if (response.status == "ok") {
                    // $this.parent().parent().remove();
                } else {
                    Swal.fire({
                        title: 'Sorry !',
                        icon: 'error',
                        text: "Sorry, we have an error. Please try again"
                    });
                }
            }
        });
    });

    $('#targetedaccountslist-form-155410').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "<?= base_url('EN/Dashboard/TargetedAccounts/' . $SurveyType . "/" . $SurveyId) ?>",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                if (response.status == "ok") {
                    $('#targetedaccountmodal').modal('hide');
                    Swal.fire({
                        title: 'Done !',
                        icon: 'success',
                        text: "Account(s) has been added successfully"
                    });
                } else {
                    Swal.fire({
                        title: 'Sorry !',
                        icon: 'error',
                        text: "Sorry, we have an error. Please try again"
                    });
                }
            }
        });
    });
</script>