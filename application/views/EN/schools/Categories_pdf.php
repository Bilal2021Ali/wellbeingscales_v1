<div class="main-content">
    <div class="page-content">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">List</h3>
                    <div class="overflow-auto">
                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th>Category</th>
                                <th>Surveys in the Category</th>
                                <th>Staff Report</th>
                                <th>Teacher Report</th>
                                <th>Student Report</th>
                                <th>Parent Report</th>
                            </thead>
                            <tbody>
                                <?php foreach ($categories as $sn => $category) { ?>
                                    <tr>
                                        <td><?= $sn + 1 ?></td>
                                        <td><?= $category['Cat_en'] ?></td>
                                        <td><?= $category['counter_of_using'] ?></td>
                                        <td class="text-center"><a href="<?= base_url("uploads/categories_reports/".$category['Staff_file_en']) ?>" target="_blank" class="btn btn-success btn-rounded waves-effect OpenFileReport <?= $category['Staff_file_en'] == null ? "disabled btn-danger" : "" ?>" data-key="<?= $category['Id'] ?>" data-user-type="staff" data-lang="en"><i class="uil uil-file"></i></a></td>
                                        <td class="text-center"><a href="<?= base_url("uploads/categories_reports/".$category['Teacher_file_en']) ?>" target="_blank" class="btn btn-success btn-rounded waves-effect OpenFileReport <?= $category['Teacher_file_en'] == null ? "disabled btn-danger" : "" ?>" data-key="<?= $category['Id'] ?>" data-user-type="teacher" data-lang="en"><i class="uil uil-file"></i></a></td>
                                        <td class="text-center"><a href="<?= base_url("uploads/categories_reports/".$category['Parent_file_en']) ?>" target="_blank" class="btn btn-success btn-rounded waves-effect OpenFileReport <?= $category['Parent_file_en'] == null ? "disabled btn-danger" : "" ?>" data-key="<?= $category['Id'] ?>" data-user-type="Student" data-lang="en"><i class="uil uil-file"></i></a></td>
                                        <td class="text-center"><a href="<?= base_url("uploads/categories_reports/".$category['Student_file_en']) ?>" target="_blank" class="btn btn-success btn-rounded waves-effect OpenFileReport <?= $category['Student_file_en'] == null ? "disabled btn-danger" : "" ?>" data-key="<?= $category['Id'] ?>" data-user-type="Parent" data-lang="en"><i class="uil uil-file"></i></a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>