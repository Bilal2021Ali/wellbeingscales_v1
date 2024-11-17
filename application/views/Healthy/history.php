<div class="main-content">
    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <table>
                    <thead>
                    <th>#</th>
                    <th><?= $this->lang->line('school-name') ?></th>
                    <th><?= $this->lang->line('created-at') ?></th>
                    <th><?= $this->lang->line('action') ?></th>
                    </thead>
                    <tbody>
                    <?php foreach ($tests as $i => $test) { ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= $test['schoolName'] ?></td>
                            <td><?= $test['takenAt'] ?></td>
                            <td>

                                <a class="btn btn-success w-100"
                                   href="<?= base_url(''. ($activeLanguage ?? 'EN') .'/DashboardSystem/qm-results/' . $this->encrypt_url->safe_b64encode($test['id'])) ?>">
                                    <?= $this->lang->line('generate-report') ?>
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