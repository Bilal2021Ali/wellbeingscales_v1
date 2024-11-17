<div class="main-content">
    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <table>
                    <thead>
                    <th>#</th>
                    <th>School Name</th>
                    <th>Report Created At</th>
                    <th>Action</th>
                    </thead>
                    <tbody>
                    <?php foreach ($tests as $i => $test) { ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= $test['schoolName'] ?></td>
                            <td><?= $test['takenAt'] ?></td>
                            <td>
                                <a class="btn btn-success w-100"
                                   href="<?= base_url('AR/DashboardSystem/qm-results/' . $this->encrypt_url->safe_b64encode($test['id'])) ?>">
                                    Generate Report
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>