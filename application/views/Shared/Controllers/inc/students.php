<?php
/**
 * @var array $students
 */
?>
<div class="card">
    <div class="card-body">
        <button class="btn btn-warning btn-sm mb-3" id="select-all-students">
            Select All
        </button>
        <table class="table">
            <thead>
            <tr>
                <th> #</th>
                <th> Img</th>
                <th> Name</th>
                <th> Grade</th>
                <th> National ID</th>
                <th> Phone Number</th>
                <th> Nationality</th>
            </tr>
            </thead>
            <tbody id="">
            <?php foreach ($students as $student) { ?>
                <tr>
                    <th scope="row">
                        <div class="custom-control custom-checkbox">
                            <input value="<?= $student['id'] ?>" type="checkbox" name="toTransfer[]"
                                   class="custom-control-input"
                                   id="category_<?= $student['id'] ?>">
                            <label class="custom-control-label"
                                   for="category_<?= $student['id'] ?>"></label>
                        </div>
                    </th>
                    <td><img class="rounded-circle img-thumbnail avatar-sm"
                             src="<?= avatar($student['avatar']) ?>" alt="Not Found">
                    </td>
                    <td>
                        <h6 class="font-size-15 mb-1 font-weight-normal"><?= $student['name'] ?></h6>
                    </td>
                    <td><?= $student['Grades']; ?></td>
                    <td><?= $student['National_Id']; ?></td>
                    <td><?= $student['Phone']; ?></td>
                    <td><?= $student['Nationality']; ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>

    </div>
</div>