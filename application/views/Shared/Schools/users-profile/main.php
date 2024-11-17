<link href="<?= base_url("assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css") ?>" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?= base_url("assets/libs/toastr/build/toastr.min.css") ?>">
<style>
    .avatar-section {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .card.profile .col-sm-12 {
        margin-top: 1rem;
    }

    .close-alert {
        cursor: pointer;
    }

    .alert p {
        margin: 0;
    }

    .emergency-contact-item {
        margin-bottom: 1rem;
    }

    .delete-emergency-container {
        display: flex !important;
        align-items: flex-end;
        justify-content: flex-end;
    }

    .datepicker.datepicker-dropdown {
        z-index: 1060 !important;
    }

    label:not(.btn) {
        background: linear-gradient(90deg, rgba(116, 83, 163, 1) 0%, rgba(121, 195, 236, 1) 99%);
        padding: 10px;
        color: #ffffff;
        border-radius: 4px;
        height: 40px;
        width: 100%;
        text-align: left;
    }

    .labelbilal > label:not(.btn) {
        background: linear-gradient(to bottom, #41295a, #2f0743);
        padding: 10px;
        color: #ffffff;
        border-radius: 4px;
        height: 40px;
        width: 100%;
        text-align: left;
    }

    .labelsub > label:not(.btn) {
        background: linear-gradient(to right, #457fca, #5691c8);
        padding: 10px;
        color: #ffffff;
        border-radius: 4px;
        height: 40px;
        width: 100%;
        text-align: left;
    }

    .labelgrade > label:not(.btn) {
        background: linear-gradient(to left, #485563, #29323c);
        padding: 10px;
        color: #ffffff;
        border-radius: 4px;
        height: 40px;
        width: 100%;
        text-align: left;
    }

    .labeltube > label:not(.btn) {
        background: linear-gradient(to left, #a73737, #7a2828);
        padding: 10px;
        color: #ffffff;
        border-radius: 4px;
        height: 40px;
        width: 100%;
        text-align: left;
    }
</style>
<?php if ($isRtl) { ?>
    <style>
        label {
            text-align: right !important;
        }
    </style>
<?php } ?>
<script>
    function errorsAlert(messages) {
        return `<div class="alert form-validation-issue alert-danger w-100">
            <i class="uil uil-times close-alert float-right" onclick="closeAlert(this)"></i>
            ${messages}
        </div>`;
    }
</script>
<div class="page-content">
    <div class="main-content">
        <div class="modal fade showmedialist" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form class="card-body documents">
                        <h3 class="card-title">
                            <?= $this->lang->line("documents") ?>
                        </h3>
                        <hr>
                        <div class="row">
                            <div class="col-lg-6">
                                <label>
                                    <?= $this->lang->line("file") ?>
                                    :</label>
                                <label class="btn btn-success w-100"
                                       for="file">
                                    <?= $this->lang->line("select-file") ?>
                                </label>
                                <input hidden="" id="file" type="file" placeholder="" name="file">
                            </div>
                            <div class="col-lg-6">
                                <label>
                                    <?= $this->lang->line("file-type") ?>
                                    :</label>
                                <select class="form-control" name="file_type">
                                    <?php foreach ($filesTypes as $fileType) { ?>
                                        <option value="<?= $fileType['Id'] ?>">
                                            <?= $fileType['Document'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label>
                                    <?= $this->lang->line("file-for") ?>
                                    :</label>
                                <select class="form-control" name="file_for">
                                    <option value="0">
                                        <?= $this->lang->line("me") ?>
                                    </option>
                                    <?php foreach ($emergencyContacts as $contact) { ?>
                                        <option value="<?= $contact['Id'] ?>">
                                            <?= $contact['Name_EN'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label>
                                    <?= $this->lang->line("description") ?>
                                    :</label>
                                <textarea placeholder="<?= $this->lang->line("description") ?>...." class="form-control"
                                          name="description"></textarea>
                            </div>
                            <div class="col-12">
                                <label class="mt-2"><?= $this->lang->line("expiry-date") ?> </label>
                                <input class="form-control" name="expiry-date" data-provide="datepicker"
                                       data-date-format="yyyy-mm-dd">
                                <label class="mt-2"> <?= $this->lang->line("document-number") ?> </label>
                                <input class="form-control" name="document-number">
                                <button class="btn btn-primary w-100 mt-2"
                                        type="submit">
                                    <?= $this->lang->line("submit") ?>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card profile">
            <form class="card-body profile-form">
                <div class="row">
                    <div class="col-lg-9 col-sm-12">
                        <div class="row">
                            <?php foreach ($inputs as $input) { ?>
                                <div class="col-lg-4 col-sm-12">
                                    <label>
                                        <?= $input['label'] ?>
                                    </label>
                                    <input class="form-control" placeholder="" value="<?= $profile[$input['name']] ?>"
                                           name="<?= strtolower($input['name']) ?>">
                                </div>
                            <?php } ?>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-sm-12">
                                <label>
                                    <?= $this->lang->line('dop') ?>
                                    (
                                    <?= $this->lang->line('age') ?>
                                    :<b id="calculated-age">
                                        <?= $age ?>
                                    </b>)</label>
                                <input class="form-control dop-input" data-provide="datepicker"
                                       data-date-format="yyyy-mm-dd"
                                       placeholder="" value="<?= $formatDate($profile["DOP"]) ?>"
                                       name="dop">
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <label><?= $this->lang->line('place-of-birth') ?></label>
                                <input class="form-control" placeholder="" value="<?= $profile["Place_of_Birth"] ?>"
                                       name="place-of-birth">
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <label>
                                    <?= $this->lang->line('nationality') ?>
                                </label>
                                <select class="form-control" name="nationality">
                                    <?php foreach ($countries as $country) { ?>
                                        <option <?= strtolower($country['name']) === strtolower($profile['Nationality']) ? "selected" : "" ?>
                                                value="<?= $country['name'] ?>">
                                            <?= $country['name'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-12 text-center avatar-section"><img
                                src="<?= base_url('uploads/avatars/' . ($profile['avatar'] ?? 'default-avatar.png')) ?>"
                                class="img-thumbnail"
                                style="width: 200px; height: 200px;">
                        <?= $barCode ?>
                        <label for="avatar-img" class="btn btn-success mt-1 w-100">change Avatar</label>
                        <input name="avatar" id="avatar-img" accept="image/*" type="file" hidden="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-sm-12">
                        <div class="labelsub">
                            <label style="color: white;"><?= $this->lang->line("national-id") ?></label>
                        </div>
                        <input class="form-control" type="text" value="<?= $profile["National_Id"] ?? "" ?>"
                               name="nid">
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <div class="labelsub">
                            <label><?= $this->lang->line("passport-number") ?></label>
                        </div>
                        <input class="form-control" type="text" value="<?= $profile["passport_no"] ?? "" ?>"
                               name="passport-no">
                    </div>

                    <div class="col-lg-3 col-sm-12">
                        <div class="labelsub">
                            <label><?= $this->lang->line("hc-card-number") ?></label>
                        </div>
                        <input class="form-control" type="text" value="<?= $profile["hc_card_no"] ?? "" ?>"
                               name="hc-card-no">
                    </div>

                    <div class="col-lg-3 col-sm-12">
                        <div class="labelbilal">
                            <label style="color: white;">
                                <?= $this->lang->line('email') ?>
                            </label>
                        </div>
                        <input class="form-control" placeholder="" value="<?= $profile["Email"] ?>"
                               name="email">
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <div class="labelsub">
                            <label><?= $this->lang->line("national-id-expiry-date") ?></label>
                        </div>
                        <input class="form-control" data-provide="datepicker"
                               data-date-format="yyyy-mm-dd" value="<?= $formatDate($profile["National_Id_Expire"]) ?>"
                               placeholder=""
                               name="national-id-expire">
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <div class="labelsub">
                            <label><?= $this->lang->line("passport-expiry-date") ?></label>
                        </div>
                        <input class="form-control" data-provide="datepicker"
                               data-date-format="yyyy-mm-dd" value="<?= $formatDate($profile["passport_expiry"]) ?>"
                               placeholder=""
                               name="passport-expiry">
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <div class="labelsub">
                            <label><?= $this->lang->line("hc-card-expiry-date") ?></label>
                        </div>
                        <input class="form-control" data-provide="datepicker"
                               data-date-format="yyyy-mm-dd" value="<?= $formatDate($profile["hc_card_expiry"]) ?>"
                               placeholder=""
                               name="hc-code-expiry">
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <div class="labelbilal">
                            <label style="color: white;">
                                <?= $this->lang->line('Phone') ?>
                            </label>
                        </div>
                        <input class="form-control" placeholder="" value="<?= $profile["Phone"] ?>"
                               name="phone">
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <div class="labelgrade">
                            <label><?= $this->lang->line("position") ?></label>
                        </div>
                        <input class="form-control" placeholder="" value="<?= $profile["Position"] ?>"
                               name="position">
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <div class="labelgrade">
                            <label><?= $this->lang->line("grade") ?> </label>
                        </div>
                        <select name="Classes" class="form-control" id="SelectFromClass">
                            <?php
                            $classes = $this->schoolHelper->school_classes($sessiondata['admin_id']);
                            if (!empty($classes)) {
                                ?>
                                <option value="">Please Select a Grade</option>
                                <?php foreach ($classes as $class) { ?>
                                    <option
                                            value="<?= $class['Id'] ?>" <?= $class['Id'] == $profile['Class'] ? "selected" : "" ?>>
                                        <?= $class['Class']; ?>
                                    </option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <div class="labelgrade">
                            <label>Section (
                                <?= $profile['Grades']; ?>
                                )</label>
                        </div>
                        <select name="Grades" class="form-control SelectGrade" searchable>
                            <option <?= $isSelectedGrade("Section-A-1") ?> value="Section-A-1">Section A (1)</option>
                            <option <?= $isSelectedGrade("Section-B-1") ?> value="Section-B-1">Section B (1)</option>
                            <option <?= $isSelectedGrade("Section-C-2") ?> value="Section-C-2">Section C (2)</option>
                            <option <?= $isSelectedGrade("Section-D-3") ?> value="Section-D-3">Section D (3)</option>
                            <option <?= $isSelectedGrade("Section-E-4") ?> value="Section-E-4">Section E (4)</option>
                            <option <?= $isSelectedGrade("Section-F-5") ?> value="Section-F-5">Section F (5)</option>
                            <option <?= $isSelectedGrade("Section-G-6") ?> value="Section-G-6">Section G (6)</option>
                            <option <?= $isSelectedGrade("Section-H-7") ?> value="Section-H-7">Section H (7)</option>
                            <option <?= $isSelectedGrade("Section-I-8") ?> value="Section-I-8">Section I (8)</option>
                            <option <?= $isSelectedGrade("Section-J-9") ?> value="Section-J-9">Section J (9)</option>
                            <option <?= $isSelectedGrade("Section-K-10") ?> value="Section-K-10">Section K (10)</option>
                            <option <?= $isSelectedGrade("Section-L-11") ?> value="Section-L-11">Section L (11)</option>
                            <option <?= $isSelectedGrade("Section-M-12") ?> value="Section-M-12">Section M (12)</option>
                            <option <?= $isSelectedGrade("Section-N-13") ?> value="Section-N-13">Section N (13)</option>
                            <option <?= $isSelectedGrade("Section-O-14") ?> value="Section-O-14">Section O (14)</option>
                            <option <?= $isSelectedGrade("Section-P-15") ?> value="Section-P-15">Section P (15)</option>
                            <option <?= $isSelectedGrade("Section-Q-16") ?> value="Section-Q-16">Section Q (16)</option>
                            <option <?= $isSelectedGrade("Section-R-17") ?> value="Section-R-17">Section R (17)</option>
                            <option <?= $isSelectedGrade("Section-S-18") ?> value="Section-S-18">Section S (18)</option>
                            <option <?= $isSelectedGrade("Section-T-19") ?> value="Section-T-19">Section T (19)</option>
                            <option <?= $isSelectedGrade("Section-U-20") ?> value="Section-U-20">Section U (20)</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <div class="labelbilal">
                            <label style="color: white;">
                                <?= $this->lang->line('office-phone') ?>
                            </label>
                        </div>
                        <input class="form-control" placeholder="" value="<?= $profile["office_phone"] ?>"
                               name="office-phone">
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <label>
                            <?= $this->lang->line('gender') ?>
                        </label>
                        <select name="gender" class="form-control">
                            <?php foreach ($genders as $gender) { ?>
                                <option <?= $gender['id'] === $profile['Gender'] ? "selected" : "" ?>
                                        value="<?= $gender['id'] ?>">
                                    <?= $gender['Gender_Type'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <label>
                            <?= $this->lang->line('martial-status') ?>
                        </label>
                        <select name="martial-status" class="form-control">
                            <?php foreach ($martialStatuses as $martialStatus) { ?>
                                <option <?= $martialStatus['Id'] === $profile['martial_status'] ? "selected" : "" ?>
                                        value="<?= $martialStatus['Id'] ?>">
                                    <?= $martialStatus['name'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <label>
                            <?= $this->lang->line('blood-type') ?>
                        </label>
                        <select class="form-control" name="blood-type">
                            <?php foreach ($bloodTypes as $bloodType) { ?>
                                <option <?= $bloodType['bloodtype_id'] === $profile['blood_group'] ?? "" ? "selected" : "" ?>
                                        value="<?= $bloodType['bloodtype_id'] ?>">
                                    <?= $bloodType['bloodtype_title_en'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <div class="labelbilal">
                            <label style="color: white;"><?= $this->lang->line("sms-whatsapp-mobile") ?></label>
                        </div>
                        <input class="form-control" type="tel" value="<?= $profile["sms_mobile"] ?>" name="sms-mobile">
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <label><?= $this->lang->line("category") ?></label>
                        <input class="form-control" placeholder="" value="<?= $profile["Category"] ?>"
                               name="category">
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <label><?= $this->lang->line("language") ?></label>
                        <select name="language" class="form-control">
                            <?php foreach (['English', 'Arabic'] as $language) { ?>
                                <option <?= $language === $profile['language'] ? "selected" : "" ?>
                                        value="<?= $language ?>">
                                    <?= $language ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <label><?= $this->lang->line("attendance-date") ?></label>
                        <input class="form-control" placeholder="" data-provide="datepicker"
                               data-date-format="yyyy-mm-dd"
                               value="<?= $formatDate($profile["attendance_date"]) ?>"
                               name="attendance-date">
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <div class="labelbilal">
                            <label style="color: white;"><?= $this->lang->line("po-box") ?></label>
                        </div>
                        <input class="form-control" type="tel" value="<?= $profile["po_box"] ?>" name="po-box">
                    </div>


                    <div class="col-lg-3 col-sm-12">
                        <label><?= $this->lang->line("registration-student-no") ?></label>
                        <input class="form-control" value="<?= $profile['Regstration_No'] ?? "" ?>" placeholder=""
                               name="registration-no">
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <label><?= $this->lang->line("registration-student-date") ?></label>
                        <input class="form-control" placeholder="" data-provide="datepicker"
                               data-date-format="yyyy-mm-dd"
                               value="<?= $formatDate($profile["Created"]) ?>"
                               name="registration-student-date">
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <label>
                            <?= $this->lang->line('last-visit-date') ?>
                        </label>
                        <input class="form-control" placeholder="" data-provide="datepicker"
                               data-date-format="yyyy-mm-dd"
                               value="<?= $formatDate($profile["last_visit_date"]) ?>"
                               name="last_visit_date">
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <div class="labeltube">
                            <label style="color: white;"><?= $this->lang->line("watch-mac-address") ?></label>
                        </div>
                        <input class="form-control" type="tel" value="<?= $profile["watch_mac"] ?>" name="watch_mac">
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <label><?= $this->lang->line("address") ?></label>
                        <textarea class="form-control" name="address"><?= $profile["address"] ?></textarea>
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <label><?= $this->lang->line("notes") ?></label>
                        <textarea class="form-control" name="Notes"><?= $profile["Notes"] ?></textarea>
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <label><?= $this->lang->line("requires") ?></label>
                        <textarea class="form-control" name="requires"><?= $profile["Requires"] ?></textarea>
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <div class="labeltube">
                            <label style="color: white;"><?= $this->lang->line("ring-mac-address") ?></label>
                        </div>
                        <input class="form-control" type="text" value="<?= $profile["ring_mac"] ?>" name="ring_mac">
                    </div>


                </div>
                <button type="submit" class="btn btn-primary mt-2 float-right"><i class="uil uil-save"></i> |
                    <?= $this->lang->line('submit') ?>
                </button>
            </form>
        </div>
        <div class="card">
            <div class="card-body text-center">
                <table class="table">
                    <thead style="background-color: #f2f2f2;">
                    <th><?= $this->lang->line("document") ?></th>
                    <th><?= $this->lang->line("document-type") ?></th>
                    <th><?= $this->lang->line("document-number") ?></th>
                    <th><?= $this->lang->line("document-expiry-date") ?></th>
                    </thead>
                    <tbody>
                    <?php foreach ($documents as $document) { ?>
                        <tr>
                            <td>
                                <a target="_blank" href="<?= $document['link'] ?>">
                                    <img src="<?= $document['link'] ?>"
                                         alt="<?= $document['name'] ?>"
                                         width="75" height="75"
                                         style="object-fit: cover;"
                                         title="<?= $this->lang->line("click-me-to-show-document") ?>">
                                </a>
                            </td>
                            <td style="text-align: center; vertical-align: middle;">
                                <?php foreach ($filesTypes as $fileType) { ?>
                                    <?php if ($fileType['Id'] == $document['fileType']) { ?>
                                        <span>
                                            <?= $fileType['Document'] ?>
                                        </span>
                                    <?php } ?>
                                <?php } ?>
                            </td>
                            <td style="text-align: center; vertical-align: middle;">
                                <strong>
                                    <?= $document['documentNumber'] ?>
                                </strong>
                            </td>
                            <td style="text-align: center; vertical-align: middle;">
                                <strong>
                                    <?= $document['expiryDate'] ?>
                                </strong>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <button type="button" class="btn btn-primary mt-2 m-auto"
                        data-toggle="modal" data-target=".showmedialist"
                        data-original-title="Show attachments" data-placement="top"
                        title="<?= $this->lang->line("show-attachments") ?>"> <?= $this->lang->line("upload-more-documents") ?>
                </button>
            </div>
        </div>
        <?php $this->load->view("Shared/Schools/users-profile/emergency-contacts"); ?>
        <div class="row">
            <?php $this->load->view("Shared/Schools/users-profile/card", ['user' => $profile]); ?>
            <?php
            foreach ($emergencyContacts as $emergencyContact) {
                $this->load->view("Shared/Schools/users-profile/card", ['user' => $emergencyContact]);
            }
            ?>
        </div>
    </div>
</div>
<script src="<?= base_url("assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js") ?>"></script>
<script src="<?= base_url("assets/libs/toastr/build/toastr.min.js"); ?>"></script>
<script>
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": 300,
        "hideDuration": 300,
        "timeOut": 5000,
        "extendedTimeOut": 1000,
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    function closeAlert(el) {
        $(el).parent().remove();
    }

    function getAge(dateString) {
        const today = new Date();
        const birthDate = new Date(dateString);
        let age = today.getFullYear() - birthDate.getFullYear();
        const m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        return age;
    }

    //calculated-age        getAge
    $(".dop-input").change(function () {
        const dop = $(".dop-input").val();
        $("#calculated-age").html(getAge(dop));
    });

    $(".profile-form").submit(function (e) {
        e.preventDefault();
        const submit = $('.profile-form button[type="submit"]');

        submit.attr("disabled", "disabled").html(submit.html() + "...");
        $(".profile-form .form-validation-issue").remove();
        $.ajax({
            type: "POST",
            url: "<?= current_url(); ?>",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                submit.removeAttr("disabled").html("<?= $this->lang->line('submit') ?>");
                if (response.status === "error") {
                    $(".profile-form").prepend(errorsAlert(response.message));
                    return;
                }
                toastr["success"]("<?= $this->lang->line('saved-successfully') ?>");
            }
        });
    });

    $("form.documents").submit(function (e) {
        e.preventDefault();
        const submit = $('.documents button[type="submit"]');

        submit.attr("disabled", "disabled").html(submit.html() + "...");
        $(".documents .form-validation-issue").remove();
        $.ajax({
            type: "POST",
            url: "<?= current_url(); ?>/documents",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                submit.removeAttr("disabled").html("<?= $this->lang->line('submit') ?>");
                if (response.status === "error") {
                    $(".documents").prepend(errorsAlert(response.message));
                    return;
                }
                toastr["success"]("<?= $this->lang->line('saved-successfully') ?>");
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }
        });
    });

    $('select[name="file_type"]').change(function (e) {
        const id = $(this).val();
        if (id.toLowerCase() === "all") {
            $('.document-container').removeClass("hidden-document");
            return;
        }
        $(".document-container").addClass("hidden-document");
        $('.document-container[data-file-type="' + id + '"]').removeClass("hidden-document");
    });

    $("#avatar-img").change(function (e) {
        const input = this;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $('.img-thumbnail').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    });
</script>