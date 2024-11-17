<div class="main-content">
    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th> # </th>
                            <th> Img </th>
                            <th> Name </th>
                            <th> Grade </th>
                            <th> National ID </th>
                            <th> Nationality </th>
                            <th> Edit </th>
                        </tr>
                    </thead>
                    <tbody id="">
                        <?php
                        $sN = 0;
                        foreach ($listofaStudents as $admin) {
                            $sN++;
                        ?>
                            <tr id="User_<?php echo $admin['Id'];  ?>">
                                <th scope="row"><?php echo $sN; ?></th>
                                <?php $avatars = $this->db->query("SELECT * FROM `l2_avatars` 
                        WHERE `For_User` = '" . $admin["Id"] . "' AND `Type_Of_User` = 'Student' LIMIT 1 ")->result_array();
                                if (!empty($avatars)) {
                                    foreach ($avatars as $avatar) {
                                ?>
                                        <td><img class="rounded-circle img-thumbnail avatar-sm" src="<?php echo base_url() . "uploads/avatars/" . $avatar['Link']; ?>" alt="Not Found"></td>
                                    <?php }
                                } else { ?>
                                    <td><img class="rounded-circle img-thumbnail avatar-sm" src="<?php echo base_url() . "uploads/avatars/default_avatar.jpg"; ?>" alt="Not Found"></td>
                                <?php } ?>
                                <td>
                                    <h6 class="font-size-15 mb-1 font-weight-normal"><?php echo $admin['F_name_EN'] . ' ' . $admin['L_name_EN']; ?></h6>
                                    <p><?php echo $admin['Action']; ?></p>
                                </td>
                                <td><?php echo $admin['Grades']; ?></td>
                                <td><?php echo $admin['National_Id']; ?></td>
                                <td><?php echo $admin['Nationality']; ?></td>
                                <td>
                                    <a href="<?php echo base_url() ?>EN/schools/UpdateStudent/<?php echo $admin['Id']; ?>">
                                        <i class="uil-pen" style="font-size: 25px;" title="Edit"></i></a>
                                    <a href="<?php echo base_url() ?>EN/schools/infos_Card/Student/<?php echo $admin['Id']; ?>">
                                        <i class="uil-credit-card" style="font-size: 25px;" title="Student Card"></i></a>
                                    <i class="uil-trash" style="font-size: 25px;" onClick="DeleteUser(<?php echo $admin['Id'] ?>,'<?php echo $admin['F_name_EN'] . ' ' . $admin['L_name_EN']; ?>','<?php echo $admin['National_Id']  ?>')" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"></i>
                                </td>
                            </tr>
                        <?php  } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $("table").DataTable();

    function DeleteUser(id, name, national_id) {
        Swal.fire({
            title: " Are you sure you want to delete " + name + "?",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: `yes`,
            cancelButtonText: `cancel`,
            icon: 'warning',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>EN/Schools/DeleteUser',
                    data: {
                        userid: id,
                        userType: 'Student',
                        national_id: national_id,
                    },
                    success: function(data) {
                        Swal.fire(
                            'success',
                            data,
                            'success'
                        );
                        $('#User_' + id).fadeOut();
                    },
                    ajaxError: function() {
                        Swal.fire(
                            'error',
                            'oops!! we have a error',
                            'error'
                        )
                    }
                });
            }
        });
    }
</script>