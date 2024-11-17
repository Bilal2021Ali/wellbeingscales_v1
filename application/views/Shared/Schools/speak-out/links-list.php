<style>
    .rounded-container {
        height: 10rem;
        border-radius: 100%;
        border-width: 0.6rem;
        border-style: solid;
        width: 10rem;
        display: grid;
        align-items: center;
        justify-items: center;
        align-content: center;
    }

    .rounded-container p {
        margin: 0;
        font-weight: bold;
    }

    .loading-container {
        min-height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding-bottom: 2rem;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <?php if (!$isMinistry) { ?>
            <?php $this->load->view("Shared/Schools/speak-out/sections/by-status") ?>
            <?php $this->load->view("Shared/Schools/speak-out/sections/by-priority") ?>
        <?php } ?>
        <?php $this->load->view($language . "/Global/Links/Lists", ['links' => $links, 'disableDefaultLayout' => true]) ?>
    </div>
</div>
<?php if (!$isMinistry) { ?>
    <script>
        const loadingDiv = `<div class="loading-container"><div class="spinner-border text-warning m-1" role="status" id="red1"><span class="sr-only">--><?= __("loading") ?>...</span> </div></div>`;
        const errorContent = `<div class="alert alert-danger w-100"><?= __("error") ?></div>`;
        const url = '<?= base_url("/index.php/" . $language . "/" . ($isMinistry ? "DashboardSystem" : "schools") . "/speak-out-dashboard"); ?>';

        function getDefaultOptions() {
            return {};
        }

        const TYPES = {
            status: "status",
            PRIORITY: "priority"
        };

        const statusMonthSelect = $('select[name="status-month"]');
        const priorityMonthSelect = $('select[name="priority-month"]');
    </script>
    <?php $this->load->view("Shared/Schools/speak-out/inc/results-by-status"); ?>
    <?php $this->load->view("Shared/Schools/speak-out/inc/results-by-priority"); ?>
<?php } ?>
