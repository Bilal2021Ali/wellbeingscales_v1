<style>
    p {
        margin: 0;
    }

    .card-logo {
        width: 15rem;
        margin: auto;
    }

    .bar-code div:first-of-type {
        margin: auto;
    }
</style>
<div class="col-lg-4 col-sm-12">
    <div class="card">
        <div class="card-body">
            <div class="w-100 text-center">
                <img alt="" class="card-logo"
                     src="<?= base_url("assets/images/settings/logos/" . $settings['logo_url'] ?? "") ?>">
            </div>
            <hr>
            <p>
                <b><?= $this->lang->line("name-of-patient") ?> :</b> <?= $user['Name_' . $language] ?? $user['F_name_' . $language] . " " . $user['L_name_' . $language] ?>
            </p>
            <p><b><?= $this->lang->line("nid") ?> :</b> <?= $user['National_Id'] ?></p>
            <p><b><?= $this->lang->line("hc-code-no") ?> :</b> <?= $user['hc_card_no'] ?></p>

            <p><b><?= $this->lang->line("mobile") ?> :</b> <?= $user['Phone'] ?></p>
            <p><b><?= $this->lang->line("address") ?> :</b> <?= $user['address'] ?></p>
            <div class="text-center w-100 mt-2 bar-code">
                <?= $barCode ?>
            </div>
        </div>
    </div>
</div>