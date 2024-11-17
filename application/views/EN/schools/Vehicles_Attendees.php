<style>
    .ShowData {
        width: 100%;
        background: transparent;
        border: 0px;
        font-size: 18px;
        margin-bottom: -15px;
        text-align: center;
        transition: 0.2s all;
    }
</style>
<link href="<?= base_url('assets/libs/select2/css/select2.min.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?= base_url("assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css") ?>" rel="stylesheet">
<link href="<?= base_url('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') ?>" rel="stylesheet" />
<link rel="stylesheet" href="<?= base_url("assets/libs/@chenfengyuan/datepicker/datepicker.min.css") ?>">
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form class="row" id="getData" class="custom-validation">
                        <div class="col-lg-6">
                            <label class="form-label">Select Vehicle: </label>
                            <select class="form-control select2" name="teacher">
                                <?php foreach ($Vehicles as $Vehicle) { ?>
                                    <option value="<?= $Vehicle['Id'] ?>"><?= $Vehicle['No_vehicle'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Date Range</label>
                                <div class="input-daterange input-group" id="datepicker6" data-date-format="yyyy-mm-dd" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                    <input type="text" class="form-control" name="start" placeholder="Start Date" autocomplete="off" data-parsley-minlength="10" data-parsley-maxlength="10" />
                                    <input type="text" class="form-control" name="end" placeholder="End Date" autocomplete="off" data-parsley-minlength="10" data-parsley-maxlength="10" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="Submit" class="btn btn-primary waves-effect w-100"> Generate <i class="uil uil-angle-down"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th>#</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Result</th>
                            <th>Date</th>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url("assets/libs/datatables.net/js/jquery.dataTables.min.js") ?>"></script>
<script src="<?= base_url('assets/libs/select2/js/select2.min.js') ?>"></script>
<script src="<?= base_url("assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js") ?>"></script>
<script src="<?= base_url("assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js") ?>"></script>
<script>
    $(".select2").select2();
    $('.table').DataTable();
    $("#getData").on('submit', function(e) {
        $('.table tbody').html("Please wait....");
        e.preventDefault();
        console.log(new FormData(this));
        $.ajax({
            type: 'POST',
            url: '<?= current_url(); ?>',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data.status == "success") {
                    var records = data.records;
                    var sn = 0;
                    $('.table tbody').html("");
                    if (Object.keys(records).length == 3) {
                        // students
                        if(records['students'].length > 0){
                            $('.table tbody').append('<tr class="odd"><td colspan="5" class="dataTables_empty" valign="top">Students :</td></tr>')
                            records['students'].forEach(user => {
                                sn++;
                                var new_html = "";
                                new_html += "<tr>";
                                new_html += "<td>" + sn + "</td>";
                                new_html += "<td>" + user.username  + "</td>";
                                if (user.Attendees_status == "present") {
                                    new_html += '<td class="text-center"><span class="badge rounded-pill bg-success text-white p-2">present</span></td>';
                                } else {
                                    new_html += '<td class="text-center"><span class="badge rounded-pill bg-danger text-white p-2">Absent</span></td>';
                                }
                                new_html += '<td class="text-center">' + (user.Result !== null ? user.Result : "---") + '</td>';
                                new_html += '<td class="text-center">' + (user.date !== null ? user.date : "---") + '</td>';
                                new_html += "</tr>";
                                $('.table tbody').append(new_html);
                            });
                        }
                        // Teachers
                        if(records['teachers'].length > 0){
                            $('.table tbody').append('<tr class="odd"><td colspan="5" class="dataTables_empty" valign="top">Teachers :</td></tr>')
                            records['students'].forEach(user => {
                                sn++;
                                var new_html = "";
                                new_html += "<tr>";
                                new_html += "<td>" + sn + "</td>";
                                new_html += "<td>" + user.username  + "</td>";
                                if (user.Attendees_status == "present") {
                                    new_html += '<td class="text-center"><span class="badge rounded-pill bg-success text-white p-2">present</span></td>';
                                } else {
                                    new_html += '<td class="text-center"><span class="badge rounded-pill bg-danger text-white p-2">Absent</span></td>';
                                }
                                new_html += '<td class="text-center">' + (user.Result !== null ? user.Result : "---") + '</td>';
                                new_html += '<td class="text-center">' + (user.date !== null ? user.date : "---") + '</td>';
                                new_html += "</tr>";
                                $('.table tbody').append(new_html);
                            });
                        }
                        // staffs
                        if(records['teachers'].length > 0){
                            $('.table tbody').append('<tr class="odd"><td colspan="5" class="dataTables_empty" valign="top">Staff:</td></tr>')
                            records['staffs'].forEach(user => {
                                sn++;
                                var new_html = "";
                                new_html += "<tr>";
                                new_html += "<td>" + sn + "</td>";
                                new_html += "<td>" + user.username  + "</td>";
                                if (user.Attendees_status == "present") {
                                    new_html += '<td class="text-center"><span class="badge rounded-pill bg-success text-white p-2">present</span></td>';
                                } else {
                                    new_html += '<td class="text-center"><span class="badge rounded-pill bg-danger text-white p-2">Absent</span></td>';
                                }
                                new_html += '<td class="text-center">' + (user.Result !== null ? user.Result : "---") + '</td>';
                                new_html += '<td class="text-center">' + (user.date !== null ? user.date : "---") + '</td>';
                                new_html += "</tr>";
                                $('.table tbody').append(new_html);
                            });
                        }
                        $('.table').DataTable();
                    } else {
                        $('.table tbody').html('<tr class="odd"><td valign="top" colspan="3" class="dataTables_empty">No data available in table</td></tr>');
                    }
                }
            },
            beforeSend: function() {
                $('#staffsub').attr('disabled', '');
                $('#staffsub').html('Please wait.');
            },
            ajaxError: function() {
                $('.alert.alert-info').css('background-color', '#DB0404');
                $('.alert.alert-info').html("Ooops! Error was found.");
            }
        });
    });
</script>