<link href="<?= base_url("assets/libs/select2/css/select2.min.css"); ?>" rel="stylesheet" type="text/css"/>
<style>
    .disable-overflow {
        position: absolute;
        z-index: 100;
        background: #1b1b1b4f;
        width: 100%;
        height: 100%;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="row">

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <label>From School</label>
                        <select class="form-control select2 school" data-direction="from">
                            <option disabled selected>select a school</option>
                            <?php foreach ($schools as $item) { ?>
                                <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                            <?php } ?>
                        </select>

                        <label class="mt-4">From Class</label>
                        <div class="school-class" data-direction="from">waiting to select the school</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card relative">
                    <div class="disable-overflow" title="will be active when you select some students"></div>
                    <div class="card-body">
                        <label>To School</label>
                        <select class="form-control select2 school" data-direction="to">
                            <option disabled selected>select a school</option>
                            <?php foreach ($schools as $item) { ?>
                                <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                            <?php } ?>
                        </select>

                        <label class="mt-4">To Class</label>
                        <div class="school-class" data-direction="to">waiting to select the school</div>

                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <button class="btn btn-primary mt-2 mb-2 w-100" style="display: none" id="transfer-btn">Transfer
                </button>
            </div>

            <div class="col-md-12 students-list">

            </div>
        </div>
    </div>
</div>
<script src="<?= base_url("assets/libs/select2/js/select2.min.js"); ?>"></script>
<script>
    $(".school").select2();

    const disableOverflow = $(".disable-overflow");
    const transferBtn = $("#transfer-btn");

    $(".school").on("change", function () {
        const direction = $(this).data("direction");
        const school = $(this).val();
        const school_class = $(".school-class[data-direction=" + direction + "]");

        $.ajax({
            url: "<?= base_url("EN/Controller/school-classes") ?>",
            type: "POST",
            data: {school, direction},
            success: function (data) {
                school_class.html(data);
            },
            error: function () {
                school_class.html("Sorry We Had an Error");
            }
        });
    });

    function showTransferBtn() {
        const classesSelect = $('.classes[data-direction="to"]');
        console.log({classesSelect});
        if (classesSelect.length > 0 && classesSelect.val() !== null) {
            transferBtn.show();
            return;
        }
        transferBtn.hide();
    }

    $("body").on("change", ".classes[data-direction='to']", showTransferBtn);

    $("body").on("change", ".classes[data-direction='from']", function () {
        const classId = $(this).val();
        const school = $(".school[data-direction='from']").val();
        const students_list = $(".students-list");

        $.ajax({
            url: "<?= base_url("EN/Controller/students") ?>",
            type: "POST",
            data: {class: classId, school},
            success: function (data) {
                students_list.html(data);
            },
            error: function () {
                students_list.html("Sorry We Had an Error");
            }
        });
    });

    function getCheckedStudents() {
        console.log("changed ?");
        const checked = $('input[name="toTransfer[]"]:checked');
        const count = checked.length;

        if (count > 0) {
            disableOverflow.hide();
            showTransferBtn();
        } else {
            disableOverflow.show();
            transferBtn.hide();
        }
    }

    $('body').on('change', 'input[name="toTransfer[]"]', getCheckedStudents);

    $('body').on('click', '#select-all-students', function () {
        $('input[name="toTransfer[]"]').prop('checked', true);
        getCheckedStudents();
    });

    transferBtn.on("click", function () {
        const students = $('input[name="toTransfer[]"]:checked');
        const students_ids = [];
        students.each(function () {
            students_ids.push($(this).val());
        });

        const from = $(".school[data-direction='from']").val();
        const to = $(".school[data-direction='to']").val();
        const from_class = $(".classes[data-direction='from']").val();
        const student_class = $(".classes[data-direction='to']").val();

        if (!from || !to || !student_class) {
            Swal.fire({
                title: "Problem",
                text: "Make sure You filled All the inputs Please",
                icon: 'error',
            });
            return;
        }

        if (from === to && student_class === from_class) {
            Swal.fire({
                title: "Problem",
                text: "you can't transfer to the same school",
                icon: 'error',
            });
            return;
        }


        transferBtn.attr("disabled", true);
        $.ajax({
            url: "<?= base_url("EN/Controller/transfer") ?>",
            type: "POST",
            data: {students_ids, from, to, student_class},
            success: function (data) {
                transferBtn.removeAttr("disabled");
                if (data.status === "ok") {
                    Swal.fire({
                        title: "Success",
                        text: "Transferred Successfullyy",
                        icon: 'success',
                    });

                    setTimeout(() => {
                        location.reload()
                    }, 1000);
                }
            },
            error: function () {
                transferBtn.removeAttr("disabled");
                Swal.fire({
                    title: "error",
                    text: "Sorry We had an Error , Please Try Again Later",
                    icon: 'error',
                });
            }
        });
    });
</script>