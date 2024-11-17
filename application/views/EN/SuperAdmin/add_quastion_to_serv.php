<label for="new_to_add">Select the questions you want to add :</label>
<select name="new_questions[]" id="new_to_add" class="form-control select2"  multiple="multiple">
<?php foreach ($av_questions as $sn => $question) { ?>
    <option value="<?php echo $question['Id'] ?>"><?php echo ($sn+1).".  ".$question['en_title'] ?></option>
<?php } ?>
</select>
<input type="hidden" name="__surv_" value="<?= $suerv_id; ?>" >
<input type="hidden" name="__survtype__" value="<?= $survey_type ?>">
<script>
    $(".select2").select2();
</script>
