<style>
    .emergency-contact-item label {
        margin-top: 1rem;
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

    .labelupdate > label:not(.btn) {
        background: linear-gradient(to right, #2193b0, #6dd5ed);
        padding: 10px;
        color: #ffffff;
        border-radius: 4px;
        height: 40px;
        width: 100%;
        text-align: left;
    }
</style>
<div class="card">
    <form class="card-body" id="emergency-contacts-form">
        <h3 class="card-title mb-4"><?= $this->lang->line('emergency-contact') ?> :
            <button class="btn btn-success waves-effect btn-rounded float-right add-emergency"
                    type="button"><i class="uil uil-plus"></i> | <?= $this->lang->line('add') ?></button>
        </h3>
        <div class="w-100" id="emergency-contacts">
            <?php foreach ($emergencyContacts as $key => $contact) { ?>
                <div class="row emergency-contact-item" data-id="<?= $key ?>">
                    <hr class="w-100">
                    <input type="hidden" name="keys[]" value="<?= $key ?>">
                    <input type="hidden" name="id[]" value="<?= $contact['Id'] ?>">

                    <div class="col-lg-2 col-sm-12">
                        <div class="labelsub">
                            <label><?= $this->lang->line('relationship') ?>:</label>
                        </div>
                        <select class="form-control" name="relationship[]">
                            <?php foreach ($relationsTypes as $type) { ?>
                                <option <?= $type['id'] === $contact['relationship_id'] ? "selected" : "" ?>
                                    value="<?= $type['id'] ?>"><?= $type['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-lg-5 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("english-full-name") ?></label>
                        </div>
                        <input type="text" name="name_en[]" value="<?= $contact['Name_EN'] ?>"
                               placeholder="" class="form-control">
                    </div>

                    <div class="col-lg-5 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("arabic-full-name") ?></label>
                        </div>
                        <input type="text" name="name_ar[]" value="<?= $contact['Name_AR'] ?>"
                               placeholder="" class="form-control">
                    </div>

                    <div class="col-lg-2 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("nationality") ?></label>
                        </div>
                        <select class="form-control" name="nationality[]">
                            <?php foreach ($countries as $country) { ?>
                                <option <?= strtolower($country['name']) === strtolower($contact['Nationality']) ? "selected" : "" ?>
                                    value="<?= $country['name'] ?>"><?= $country['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-2 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("dop") ?></label>
                        </div>
                        <input type="text" name="dop[]" data-provide="datepicker"
                               data-date-format="yyyy-mm-dd"
                               value="<?= $contact['DOP'] ?>"
                               placeholder="<?= $this->lang->line("dop") ?>..." class="form-control">
                    </div>

                    <div class="col-lg-2 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("place-of-birth") ?></label>
                        </div>
                        <input class="form-control" placeholder="" value="<?= $contact["Place_of_Birth"] ?>"
                               name="place_of_birth[]">
                    </div>

                    <div class="col-lg-2 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("gender") ?></label>
                        </div>
                        <select name="gender[]" class="form-control">
                            <?php foreach ($genders as $gender) { ?>
                                <option <?= $gender['id'] === $contact['Gender'] ? "selected" : "" ?>
                                    value="<?= $gender['id'] ?>"><?= $gender['Gender_Type'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-lg-2 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("martial-status") ?></label>
                        </div>
                        <select name="martial_status[]" class="form-control">
                            <?php foreach ($martialStatuses as $martialStatus) { ?>
                                <option <?= $martialStatus['Id'] === $contact['martial_status'] ?>
                                    value="<?= $martialStatus['Id'] ?>"><?= $martialStatus['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-lg-2 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("language") ?></label>
                        </div>
                        <select class="form-control" name="language[]">
                            <?php foreach (['en', 'ar'] as $language) { ?>
                                <option <?= $language === $contact['LANGUAGE'] ? "selected" : "" ?>
                                    value="<?= $language ?>"><?= $language ?></option>
                            <?php } ?>
                        </select>
                    </div>


                    <div class="col-lg-2 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("national-id") ?></label>
                        </div>
                        <input class="form-control" type="text" value="<?= $contact["National_Id"] ?? "" ?>"
                               name="national_id[]">
                    </div>

                    <div class="col-lg-2 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("national-id-expiry-date") ?></label>
                        </div>
                        <input class="form-control"
                               data-provide="datepicker"
                               data-date-format="yyyy-mm-dd"
                               value="<?= $formatDate($contact["National_Id_Expire"]) ?>" placeholder=""
                               name="national_no_expiry[]">
                    </div>

                    <div class="col-lg-2 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("passport-number") ?></label>
                        </div>
                        <input type="text" name="passport_no[]" value="<?= $contact['passport_no'] ?>"
                               placeholder="<?= $this->lang->line('passport-no') ?>..." class="form-control">
                    </div>

                    <div class="col-lg-2 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("passport-expiry-date") ?></label>
                        </div>
                        <input type="text" name="passport_expiry[]" data-provide="datepicker"
                               data-date-format="yyyy-mm-dd"
                               value="<?= $contact['passport_expiry'] ?>"
                               placeholder="<?= $this->lang->line("passport-expiry-date") ?>..." class="form-control">
                    </div>

                    <div class="col-lg-2 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("hc-card-number") ?></label>
                        </div>
                        <input class="form-control" placeholder="" value="<?= $contact["hc_card_no"] ?>"
                               name="hc_card_no[]">
                    </div>
                    <div class="col-lg-2 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("hc-card-expiry-date") ?></label>
                        </div>
                        <input class="form-control" placeholder="" data-provide="datepicker"
                               data-date-format="yyyy-mm-dd"
                               value="<?= $formatDate($contact["hc_card_expiry"]) ?>"
                               name="hc_code_expiry[]">
                    </div>

                    <div class="col-lg-2 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("driving-license") ?></label>
                        </div>
                        <input type="text" name="driving_license[]" value="<?= $contact['Driving_license'] ?>"
                               placeholder="<?= $this->lang->line('driving-license') ?>..." class="form-control">
                    </div>

                    <div class="col-lg-2 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("spouse-name") ?></label>
                        </div>
                        <input type="text" name="spouse_name[]" value="<?= $contact['Spouse_name'] ?>"
                               placeholder="<?= $this->lang->line('spouse-name') ?>..." class="form-control">
                    </div>


                    <div class="col-lg-2 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("category") ?></label>
                        </div>
                        <input class="form-control" placeholder="" value="<?= $contact["Category"] ?>"
                               name="category[]">
                    </div>

                    <div class="col-lg-2 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("blood-type") ?></label>
                        </div>
                        <select class="form-control" name="blood_type[]">
                            <?php foreach ($bloodTypes as $bloodType) { ?>
                                <option <?= $bloodType['bloodtype_id'] === $contact['blood_group'] ?? "" ? "selected" : "" ?>
                                    value="<?= $bloodType['bloodtype_id'] ?>"><?= $bloodType['bloodtype_title_en'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-2 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("degree") ?></label>
                        </div>
                        <input type="text" name="degree[]" value="<?= $contact['Degree'] ?>" placeholder=""
                               class="form-control">
                    </div>
                    <div class="col-lg-2 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("position") ?></label>
                        </div>
                        <input type="text" name="POSITION[]" value="<?= $contact['POSITION'] ?>" placeholder=""
                               class="form-control">
                    </div>

                    <div class="col-lg-2 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("mobile") ?></label>
                        </div>
                        <input type="text" name="Phone[]" value="<?= $contact['Phone'] ?>" placeholder=""
                               class="form-control">
                    </div>

                    <div class="col-lg-2 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("sms-mobile") ?></label>
                        </div>
                        <input type="text" name="sms_mobile[]" value="<?= $contact['sms_mobile'] ?>" placeholder=""
                               class="form-control">
                    </div>

                    <div class="col-lg-2 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("office-phone") ?></label>
                        </div>
                        <input type="text" name="office_phone[]" value="<?= $contact['office_phone'] ?>" placeholder=""
                               class="form-control">
                    </div>

                    <div class="col-lg-2 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("email") ?></label>
                        </div>
                        <input type="text" name="Email[]" value="<?= $contact['Email'] ?>" placeholder=""
                               class="form-control">
                    </div>

                    <div class="col-lg-2 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("po-box") ?></label>
                        </div>
                        <input type="text" name="po_box[]" value="<?= $contact['po_box'] ?>" placeholder=""
                               class="form-control">
                    </div>

                    <div class="col-lg-2 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("created-record") ?></label>
                        </div>
                        <input type="text" name="Created[]" value="<?= $contact['Created'] ?>" placeholder=""
                               class="form-control">
                    </div>

                    <div class="col-lg-2 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("watch-mac-address") ?></label>
                        </div>
                        <input type="text" name="watch_mac[]" value="<?= $contact['watch_mac'] ?>" placeholder=""
                               class="form-control">
                    </div>

                    <div class="col-lg-2 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("ring-mac-address") ?></label>
                        </div>
                        <input type="text" name="ring_mac[]" value="<?= $contact['ring_mac'] ?>" placeholder=""
                               class="form-control">
                    </div>

                    <div class="col-lg-4 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("notes") ?></label>
                        </div>
                        <textarea placeholder="<?= $this->lang->line("notes") ?>.." name="notes[]"
                                  class="form-control"><?= $contact['Notes'] ?></textarea>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("requires") ?></label>
                        </div>
                        <textarea class="form-control" name="requires[]"><?= $contact["Requires"] ?></textarea>
                    </div>

                    <div class="col-lg-6 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("attendance-date") ?></label>
                        </div>
                        <input type="text" name="attendance_date[]" value="<?= $contact['attendance_date'] ?>"
                               data-provide="datepicker" data-date-format="yyyy-mm-dd"
                               placeholder="" class="form-control">
                    </div>

                    <div class="col-lg-6 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("address") ?></label>
                        </div>
                        <input type="text" name="address[]" value="<?= $contact['address'] ?>" placeholder=""
                               class="form-control">
                    </div>

                    <div class="col-lg-6 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("Regstration-No") ?></label>
                        </div>
                        <input type="text" name="Regstration_No[]" value="<?= $contact['Regstration_No'] ?>"
                               placeholder="" class="form-control">
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("country") ?></label>
                        </div>
                        <select class="form-control" name="country[]">
                            <?php foreach ($countries as $country) { ?>
                                <option <?= intval($country['id']) === intval($contact['country']) ? "selected" : "" ?>
                                    value="<?= $country['id'] ?>"><?= $country['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            <?php } ?>
        </div>
        <hr style="background-color: blue;">

        <button type="submit" class="btn btn-warning mt-2 float-right">
            <i class="uil uil-save"></i> | <?= $this->lang->line('submit') ?>
        </button>
    </form>
</div>
<script>
    $(".add-emergency").click(function () {
        const items = $("#emergency-contacts .emergency-contact-item").length;
        $("#emergency-contacts").append(`
                <div class="row emergency-contact-item" data-id="${items + 1}">
                        <hr class="w-100">
                        <input type="hidden" name="keys[]" value="${items + 1}">

                    <div class="col-lg-2 col-sm-12">
					<div class="labelgrade">
                            <label><?= $this->lang->line('relationship') ?>:</label>
						</div>
                        <select class="form-control" name="relationship[]">
                            <?php foreach ($relationsTypes as $type) { ?>
                                <option value="<?= $type['id'] ?>"><?= $type['name_en'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-lg-5 col-sm-12">
					<div class="labelgrade">
                            <label><?= $this->lang->line("english-full-name") ?></label>
						</div>
                        <input type="text" name="name_en[]" placeholder="" class="form-control">
                    </div>

                    <div class="col-lg-5 col-sm-12">
					<div class="labelgrade">
                            <label><?= $this->lang->line("arabic-full-name") ?></label>
						</div>
                        <input type="text" name="name_ar[]" placeholder="" class="form-control">
                    </div>

                    <div class="col-lg-2 col-sm-12">
					<div class="labelgrade">
                            <label><?= $this->lang->line("nationality") ?></label>
						</div>
                        <select class="form-control" name="nationality[]">
                            <?php foreach ($countries as $country) { ?>
                                <option value="<?= $country['name'] ?>"><?= $country['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
					<div class="col-lg-2 col-sm-12">
					<div class="labelgrade">
                            <label><?= $this->lang->line("dop") ?></label>
						</div>
                        <input type="text" name="dop[]" data-provide="datepicker"
                               data-date-format="yyyy-mm-dd" placeholder="" class="form-control">
                    </div>

				<div class="col-lg-2 col-sm-12">
					<div class="labelgrade">
                            <label><?= $this->lang->line("place-of-birth") ?></label>
						</div>
                        <input class="form-control" placeholder="" name="place_of_birth[]">
                    </div>

				<div class="col-lg-2 col-sm-12">
					<div class="labelgrade">
                            <label><?= $this->lang->line("gender") ?></label>
						</div>
                        <select name="gender[]" class="form-control">
                            <?php foreach ($genders as $gender) { ?>
                                <option value="<?= $gender['id'] ?>"><?= $gender['Gender_Type'] ?></option>
                            <?php } ?>
                        </select>
						</div>

				<div class="col-lg-2 col-sm-12">
					<div class="labelgrade">
                            <label><?= $this->lang->line("martial-status") ?></label>
						</div>
                        <select name="martial_status[]" class="form-control">
                            <?php foreach ($martialStatuses as $martialStatus) { ?>
                                <option value="<?= $martialStatus['Id'] ?>"><?= $martialStatus['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

				<div class="col-lg-2 col-sm-12">
					<div class="labelgrade">
                            <label><?= $this->lang->line("language") ?></label>
						</div>
                        <select class="form-control" name="language[]">
                            <?php foreach (['en', 'ar'] as $language) { ?>
                                <option value="<?= $language ?>"><?= $language ?></option>
                            <?php } ?>
                        </select>
                    </div>


                    <div class="col-lg-2 col-sm-12">
					<div class="labelgrade">
                            <label><?= $this->lang->line("national-id") ?></label>
						</div>
                        <input class="form-control" type="text" name="national_id[]">
                    </div>

                    <div class="col-lg-2 col-sm-12">
					<div class="labelgrade">
                            <label><?= $this->lang->line("national-id-expiry-date") ?></label>
						</div>
                        <input class="form-control"
                               data-provide="datepicker"
                               data-date-format="yyyy-mm-dd" placeholder=""
                               name="national_no_expiry[]">
                    </div>

                    <div class="col-lg-2 col-sm-12">
					<div class="labelgrade">
                            <label><?= $this->lang->line("passport-number") ?></label>
						</div>
                        <input type="text" name="passport_no[]" placeholder="<?= $this->lang->line('passport-no') ?>..." class="form-control">
                    </div>

                    <div class="col-lg-2 col-sm-12">
					<div class="labelgrade">
                            <label><?= $this->lang->line("passport-expiry-date") ?></label>
						</div>
                        <input type="text" name="passport_expiry[]" data-provide="datepicker"
                               data-date-format="yyyy-mm-dd" placeholder="<?= $this->lang->line("passport-expiry-date") ?>..." class="form-control">
                    </div>

                     <div class="col-lg-2 col-sm-12">
					<div class="labelgrade">
                            <label><?= $this->lang->line("hc-card-number") ?></label>
						</div>
                        <input class="form-control" placeholder="" name="hc_card_no[]">
                    </div>
				<div class="col-lg-2 col-sm-12">
					<div class="labelgrade">
                            <label><?= $this->lang->line("hc-card-expiry-date") ?></label>
						</div>
                        <input class="form-control" placeholder="" data-provide="datepicker"
                               data-date-format="yyyy-mm-dd" name="hc_code_expiry[]">
                    </div>

<div class="col-lg-2 col-sm-12">
					<div class="labelgrade">
                            <label><?= $this->lang->line("driving-license") ?></label>
						</div>
                        <input type="text" name="driving_license[]" placeholder="<?= $this->lang->line('driving-license') ?>..." class="form-control">
                    </div>

<div class="col-lg-2 col-sm-12">
					<div class="labelgrade">
                            <label><?= $this->lang->line("spouse-name") ?></label>
						</div>
                        <input type="text" name="spouse_name[]" placeholder="<?= $this->lang->line('spouse-name') ?>..." class="form-control">
                    </div>



                <div class="col-lg-2 col-sm-12">
					<div class="labelgrade">
                            <label><?= $this->lang->line("category") ?></label>
						</div>
                        <input class="form-control" placeholder="" name="category[]">
                </div>

<div class="col-lg-2 col-sm-12">
					<div class="labelgrade">
                            <label><?= $this->lang->line("blood-type") ?></label>
						</div>
                        <select class="form-control" name="blood_type[]">
                            <?php foreach ($bloodTypes as $bloodType) { ?>
                                <option value="<?= $bloodType['bloodtype_id'] ?>"><?= $bloodType['bloodtype_title_en'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
		<div class="col-lg-2 col-sm-12">
					<div class="labelgrade">
                            <label><?= $this->lang->line("degree") ?></label>
						</div>
                        <input type="text" name="degree[]" placeholder=""
                               class="form-control">
                    </div>
		<div class="col-lg-2 col-sm-12">
					<div class="labelgrade">
                            <label><?= $this->lang->line("position") ?></label>
						</div>
                        <input type="text" name="POSITION[]" placeholder=""
                               class="form-control">
                    </div>

					<div class="col-lg-2 col-sm-12">
						<div class="labelgrade">
                            <label><?= $this->lang->line("mobile") ?></label>
						</div>
                        <input type="text" name="Phone[]" placeholder=""
                               class="form-control">
                    </div>

					<div class="col-lg-2 col-sm-12">
						<div class="labelgrade">
                            <label><?= $this->lang->line("sms-mobile") ?></label>
						</div>
                        <input type="text" name="sms_mobile[]" placeholder=""
                               class="form-control">
                    </div>

					<div class="col-lg-2 col-sm-12">
						<div class="labelgrade">
                            <label><?= $this->lang->line("office-phone") ?></label>
						</div>
                        <input type="text" name="office_phone[]" placeholder=""
                               class="form-control">
                    </div>

					<div class="col-lg-2 col-sm-12">
						<div class="labelgrade">
                            <label><?= $this->lang->line("email") ?></label>
						</div>
                        <input type="text" name="Email[]" placeholder=""
                               class="form-control">
                    </div>

					<div class="col-lg-2 col-sm-12">
						<div class="labelgrade">
                            <label><?= $this->lang->line("po-box") ?></label>
						</div>
                        <input type="text" name="po_box[]" placeholder=""
                               class="form-control">
                    </div>

					<div class="col-lg-2 col-sm-12">
						<div class="labelgrade">
                            <label><?= $this->lang->line("created-record") ?></label>
						</div>
                        <input type="text" name="Created[]" placeholder=""
                               class="form-control">
                    </div>

					<div class="col-lg-2 col-sm-12">
						<div class="labelgrade">
                            <label><?= $this->lang->line("watch-mac-address") ?></label>
						</div>
                        <input type="text" name="watch_mac[]" placeholder=""
                               class="form-control">
                    </div>

					<div class="col-lg-2 col-sm-12">
						<div class="labelgrade">
                            <label><?= $this->lang->line("ring-mac-address") ?></label>
						</div>
                        <input type="text" name="ring_mac[]" placeholder=""
                               class="form-control">
                    </div>

                    <div class="col-lg-4 col-sm-12">
						<div class="labelgrade">
                            <label><?= $this->lang->line("notes") ?></label>
						</div>
                        <textarea placeholder="<?= $this->lang->line("notes") ?>.." name="notes[]"
                                  class="form-control"></textarea>
                    </div>
                    <div class="col-lg-4 col-sm-12">
						<div class="labelgrade">
                            <label><?= $this->lang->line("requires") ?></label>
						</div>
                        <textarea class="form-control" name="requires[]"></textarea>
                    </div>

                    <div class="col-lg-6 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("attendance-date") ?></label>
                        </div>
                        <input type="text" name="attendance_date[]" data-provide="datepicker" data-date-format="yyyy-mm-dd"
                               placeholder="" class="form-control">
                    </div>

                    <div class="col-lg-6 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("address") ?></label>
                        </div>
                        <input type="text" name="address[]" placeholder="" class="form-control">
                    </div>

                    <div class="col-lg-6 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("Regstration-No") ?></label>
                        </div>
                        <input type="text" name="Regstration_No[]" placeholder="" class="form-control">
                    </div>

                    <div class="col-lg-6 col-sm-12">
                        <div class="labelupdate">
                            <label><?= $this->lang->line("country") ?></label>
                        </div>
                        <select class="form-control" name="country[]">
                            <?php foreach ($countries as $country) { ?>
                                <option value="<?= $country['id'] ?>"><?= $country['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
           </div>
        `);
    });

    $("#emergency-contacts").on("click", ".delete-emergency", function () {
        const id = $(this).attr("data-emergency-key");
        console.log('.emergency-contact-item[data-id="' + id + '"]');
        $('.emergency-contact-item[data-id="' + id + '"]').remove();
    });


    $("#emergency-contacts-form").submit(function (e) {
        e.preventDefault();
        const submit = $('#emergency-contacts-form button[type="submit"]');

        submit.attr("disabled", "disabled").html(submit.html() + "...");
        $("#emergency-contacts .form-validation-issue").remove();
        $.ajax({
            type: "POST",
            url: "<?= base_url(config_item('env')['INDEX_PAGE'] . "/EN/schools/emergency-contact/" . $this->type . "/" . $this->id); ?>",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                submit.removeAttr("disabled").html("<?= $this->lang->line('submit') ?>");
                if (response.status === "error") {
                    $("#emergency-contacts .profile-form").prepend(errorsAlert(response.message));
                    return;
                }
                toastr["success"]("<?= $this->lang->line('saved-successfully') ?>");
                setTimeout(function () {
                    location.reload();
                }, 750);
            }
        });
    });
</script>