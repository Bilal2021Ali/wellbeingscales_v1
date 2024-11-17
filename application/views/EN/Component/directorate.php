<style>
    select:disabled {
        opacity: 0.4 !important;
    }
</style>
<div class="col-md-6">
    <div class="form-group mb-6"> <br>
        <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">Main Directorate</h4>
        <select class="form-control select2" name="directorate">
            <?php foreach ($directorates as $directorate) { ?>
                <option <?= $directorate['Id'] == $default_directorate ? "selected" : "" ?> value="<?= $directorate['Id'];  ?>">
                    <?= $directorate['Directorate_EN']; ?>
                </option>
            <?php  } ?>
        </select>
    </div>
</div>
<div class="col-md-6">
    <div class="form-group mb-6"> <br>
        <h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">Directorate <span class="float-right directorate-note"></span></h4>
        <select class="form-control select2" name="sub_directorate">
            <?php foreach ($sub_directorate as $directorate) { ?>
                <option <?= $directorate['Id'] == $default_directorate_type ? "selected" : "" ?> data-parent="<?= $directorate['Directorate_Id'] ?>" value="<?= $directorate['Id'];  ?>">
                    <?= $directorate['Directorate_Type_EN']; ?>
                </option>
            <?php  } ?>
        </select>
    </div>
</div>
<script>
    $('select[name="directorate"]').change(function(e) {
        e.preventDefault();
        showsubdirectorates($(this).children("option:selected").val());
    });

    showsubdirectorates($("select[name='directorate'] option:selected").val());

    function showsubdirectorates(pid) {
        $("select[name='sub_directorate'] option").hide();
        $("select[name='sub_directorate'] option[data-parent=" + pid + "]").show();
        if ($("select[name='sub_directorate'] option[data-parent=" + pid + "]").length <= 0) {
            $("select[name='sub_directorate']").attr("disabled", "disabled");
            $(".directorate-note").html("Can't find any data");
        } else {
            $("select[name='sub_directorate']").removeAttr("disabled");
            $(".directorate-note").html("");
        }
    }
</script>