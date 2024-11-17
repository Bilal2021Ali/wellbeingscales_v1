<style>
    .card-header {
        border-bottom: 1px solid;
    }

    .empty {
        width: 100%;
        text-align: center;
    }

    .empty img {
        width: 300px;
        margin-bottom: 10px;
    }

    .uil-message {
        font-size: 17px;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="row">
            <?php if (empty($files)) { ?>
                <div class="container text-center p-5 empty">
                    <img src="<?= base_url('assets/images/empty.svg') ?>" class="empty" alt="">
                    <h5 class="mt-2">There are no files here yet.</h5>
                </div>
            <?php } else { ?>
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-body">
                            <table>
                                <thead>
                                <th>#</th>
                                <th>Document Title</th>
                                <th>Date Uploaded</th>
                                <th>File Link</th>
                                <th>Messages</th>
                                </thead>
                                <tbody>
                                <?php foreach ($files as $sn => $file) { ?>
                                    <tr>
                                        <td><?= $sn + 1 ?></td>
                                        <td><?= $file['Comments'] ?></td>
                                        <td><?= $file['UploadedAt'] ?></td>
                                        <td>
                                            <a target="_blank"
                                               href="<?= base_url('uploads/consultants/' . $file['link']) ?>">Open</a>
                                        </td>
                                        <td class="text-center">
                                            <a data-toggle="tooltip" data-placement="top"
                                               title="Chat With The Consultant About This Report"
                                               href="<?= base_url("EN/" . $this->router->fetch_class() . "/Consultant" . (in_array($sessiondata['type'], ['Ministdy', 'Company']) ? "s" : "") . "/chat/" . $file['Id']); ?>">
                                                <?php if ($file['UnreadMessages'] > 0) { ?>
                                                    <span class="badge rounded-pill bg-warning text-white"><?= $file['UnreadMessages'] ?></span>
                                                <?php } ?>
                                                <i class="uil-message"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<script>
    $("table").DataTable();
</script>