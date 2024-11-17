<style>
    .groping {
        font-size: 20px;
    }
</style>
<div class="main-content">
    <div class="page-content">
	<h4 class="card-title" style="background: #800080; padding: 10px;color: #ffffff;border-radius: 4px;">SU 016: Create Grouping for calculation of Surveys for Dedicated Standard</h4>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="responsive-table">
                            <table class="table">
                                <thead>
                                    <th>#</th>
                                    <th>Date &amp; Time</th>
                                    <th>Name AR</th>
                                    <th>Name EN</th>
                                    <th>Actions</th>
                                </thead>
                                <tbody>
                                    <?php foreach ($standars as $sn => $standard) { ?>
                                        <tr>
                                            <td><?= $sn + 1  ?></td>
                                            <td><?= $standard['TimeStamp'] ?></td>
                                            <td><?= $standard['Name_ar'] ?></td>
                                            <td><?= $standard['Name_en'] ?></td>
                                            <td class="text-center">
                                                <a href="<?= base_url("EN/Dashboard/standarsGrouping/".$standard['Id']."/".$survey_id) ?>" class="groping" data-toggle="tooltip" data-placement="top" title="" data-original-title="Results Groups">
                                                    <i class="uil uil-sitemap"></i>
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
        </div>
    </div>
</div>
<script>
        $('.table').DataTable({
        dom: 'Bfrtip',
        buttons: ['copy', 'excel', 'pdf', 'colvis']
    });
</script>