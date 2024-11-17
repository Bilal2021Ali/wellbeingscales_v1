<select class="form-control classes" data-direction="<?= $direction ?>">
    <option value="" disabled selected>Select Class</option>
    <?php foreach ($classes as $class) { ?>
        <option value="<?= $class["Id"] ?>"><?= $class['Class'] ?></option>
    <?php } ?>
</select>