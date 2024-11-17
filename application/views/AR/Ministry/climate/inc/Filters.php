<link href="<?= base_url("assets/libs/select2/css/select2.min.css"); ?>" rel="stylesheet" type="text/css" />
<link href="<?= base_url("assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css") ?>" rel="stylesheet">

<div class="card">
    <div class="card-body">
        <form class="row" method="post">
            <div class="col-12 mb-2">
                <label class="form-label">الفترة الزمنية:</label>
                <div class="input-daterange input-group" id="datepicker6" data-date-format="yyyy-mm-dd" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                    <input type="text" class="form-control" autocomplete="off" value="<?= $filters["from"] ?>" name="start" placeholder="From" />
                    <input type="text" class="form-control" autocomplete="off" name="end" value="<?= $filters["to"] ?>" placeholder="To" />
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                 <Label>المرحلة الدراسية:</Label>
                <select multiple name="class[]" class="form-control select2">
                    <?php foreach ($filterssource["classes"] as $class) { ?>
                        <option <?= in_array($class["Id"], $filters["class"]) ? "selected" : "" ?> value="<?= $class["Id"] ?>"><?= $class["Class_ar"] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                 <Label>الجنس:</Label>
                <select multiple name="gender[]" class="form-control select2">
                    <?php foreach ($filterssource["genders"] as $gender) { ?>
                        <option <?= in_array("'" . $gender["name"] . "'", $filters["gender"]) ? "selected" : "" ?> value="<?= $gender["name"] ?>"><?= $gender["display"] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <Label>مجموعة الجو العام:</Label>
                <select multiple name="category[]" class="form-control select2">
                    <?php foreach ($filterssource["category"] as $category) { ?>
                        <option <?= in_array($category["category_id"], $filters["category"]) ? "selected" : "" ?> value="<?= $category["category_id"] ?>"><?= $category["Cat_ar"] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                 <Label>نوع المستخدم:</Label>
                <select multiple name="usertype[]" class="form-control select2">
                    <?php foreach ($filterssource["userstypes"] as $userstype) { ?>
                        <option <?= in_array($userstype["code"], $filters["usertype"]) ? "selected" : "" ?> value="<?= $userstype["code"] ?>"><?= ucfirst($userstype["name"]) ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-12 mt-2">
                <button type="submit" class="btn btn-primary w-100">
                    بناء التقرير
                </button>
            </div>
        </form>
    </div>
</div>
<script src="<?= base_url(); ?>assets/libs/select2/js/select2.min.js"></script>
<script src="<?= base_url("assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js") ?>"></script>
<script>
    $(".select2").select2({
        placeholder: "تحديد ",
        closeOnSelect: false,
        allowClear: true
    });
</script>