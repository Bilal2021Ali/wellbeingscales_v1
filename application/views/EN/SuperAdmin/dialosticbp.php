<link href="<?= base_url("assets/libs/spectrum-colorpicker2/spectrum.min.css") ?>" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="<?= base_url("assets/libs/toastr/build/toastr.min.css") ?>">
<style>
    td {
        text-align: center;
    }
</style>
<div class="main-content">
	
    <div class="page-content">
	<h4 class="card-title" style="background: #800080; padding: 10px;color: #ffffff;border-radius: 4px;">SU 101: Control monitors pages colors</h4>
    <h5 class="card-title" style="background: #fff2cc; padding: 10px;color: #444444;border-radius: 4px;">This is effect will be on this reports
		<br>1- Department - Daily Monitor
		<br>2- Department - Quarantine Report
		<br>3- Department - Stay Home Monitor
		<br>4- Department - Visitors Report
		<br>5- School - Daily Monitor
		<br>6- School - Quarantine Monitor
		<br>7- School - Stay Home Monitor
		</h5>
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-bordered table-responsive">
                        <thead>
                            <th>#</th>
                            <th>Low Value</th>
                            <th>Low back color</th>
                            <th>Low Font color</th>
                            <th>Normal Value</th>
                            <th>Normal back color</th>
                            <th>Normal Font color</th>
                            <th>Pre Value</th>
                            <th>Pre back color</th>
                            <th>Pre Font color</th>
                            <th>High Value</th>
                            <th>High back color</th>
                            <th>High Font color</th>
                            <th>High 2 Value</th>
                            <th>High 2 back color</th>
                            <th>High 2 Font color</th>
                        </thead>
                        <tbody>
                            <?php foreach ($dialosticbps as $sn => $dialosticbp) { ?>
                                <tr>
                                    <td><?= $sn + 1 ?></td>
                                    <td>From: <?= $dialosticbp['low_from'] ?> , To : <?= $dialosticbp['from_to'] ?></td>
                                    <td> <input type="text" data-id="<?= $dialosticbp['id'] ?>" data-col="low_back_col" class="form-control colorpicker" value="#<?= $dialosticbp['low_back_col'] ?>"> </td>
                                    <td> <input type="text" data-id="<?= $dialosticbp['id'] ?>" data-col="low_font_col" class="form-control colorpicker" value="#<?= $dialosticbp['low_font_col'] ?>"> </td>
                                    <td>From: <?= $dialosticbp['normal_from'] ?> , To : <?= $dialosticbp['normal_to'] ?></td>
                                    <td><input type="text" data-id="<?= $dialosticbp['id'] ?>" data-col="normal_back_col" class="form-control colorpicker" value="#<?= $dialosticbp['normal_back_col'] ?>"> </td>
                                    <td><input type="text" data-id="<?= $dialosticbp['id'] ?>" data-col="normal_font_col" class="form-control colorpicker" value="#<?= $dialosticbp['normal_font_col'] ?>"> </td>
                                    <td>From: <?= $dialosticbp['pre_from'] ?> , To : <?= $dialosticbp['pre_to'] ?></td>
                                    <td><input type="text" data-id="<?= $dialosticbp['id'] ?>" data-col="pre_back_col" class="form-control colorpicker" value="#<?= $dialosticbp['pre_back_col'] ?>"> </td>
                                    <td><input type="text" data-id="<?= $dialosticbp['id'] ?>" data-col="pre_font_col" class="form-control colorpicker" value="#<?= $dialosticbp['pre_font_col'] ?>"> </td>
                                    <td>From: <?= $dialosticbp['high_from'] ?> , To : <?= $dialosticbp['hight_to'] ?></td>
                                    <td><input type="text" data-id="<?= $dialosticbp['id'] ?>" data-col="hight_back_col" class="form-control colorpicker" value="#<?= $dialosticbp['hight_back_col'] ?>"> </td>
                                    <td><input type="text" data-id="<?= $dialosticbp['id'] ?>" data-col="hight_font_col" class="form-control colorpicker" value="#<?= $dialosticbp['hight_font_col'] ?>"> </td>
                                    <td>From: <?= $dialosticbp['high2_from'] ?> , To : <?= $dialosticbp['high2_to'] ?></td>
                                    <td><input type="text" data-id="<?= $dialosticbp['id'] ?>" data-col="high2_back_col" class="form-control colorpicker" value="#<?= $dialosticbp['high2_back_col'] ?>"> </td>
                                    <td><input type="text" data-id="<?= $dialosticbp['id'] ?>" data-col="high2_font_col" class="form-control colorpicker" value="#<?= $dialosticbp['high2_font_col'] ?>"> </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url("assets/libs/toastr/build/toastr.min.js") ?>"></script>
<script src="<?= base_url("assets/libs/spectrum-colorpicker2/spectrum.min.js") ?>"></script>
<script>
    $(".colorpicker").spectrum();
    $('.table').DataTable();
    $('.table').on('change', "input", function() {
        var newval = $(this).val();
        var col_id = $(this).attr("data-id");
        var col = $(this).attr("data-col");
        $.ajax({
            type: "POST",
            url: "<?= base_url("EN/Dashboard/dialosticbp") ?>",
            data: {
                col_id: col_id,
                new_val: newval,
                col: col
            },
            success: function(response) {
                if (response == "ok") {
                    toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": 300,
                        "hideDuration": 1000,
                        "timeOut": 5000,
                        "extendedTimeOut": 1000,
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    }
                    Command: toastr["success"]("The data was successfully updated.");
                } else {
                    toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": 300,
                        "hideDuration": 1000,
                        "timeOut": 5000,
                        "extendedTimeOut": 1000,
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    }
                    Command: toastr["error"]("Error was found. Please try again later.")
                }
            }
        });
    });
</script>