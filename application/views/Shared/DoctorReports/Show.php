<?php
/**
 * @var string $filtersSource
 */
?>
<style>
    .loading-container {
        height: 350px;
        display: grid;
        width: 100%;
        align-items: center;
        justify-items: center;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="card">
            <form class="card-body" id="filters">
                <h3 class="card-title"><?= __('filters') ?></h3>
                <?php $this->load->view($filtersSource); ?>
            </form>
        </div>

        <div class="card">
            <div class="card-body" id="results">

            </div>
        </div>
    </div>
</div>
<!-- Required datatable js -->
<script src="<?php echo base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/jszip/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
<script>
    const resultsContainer = $('#results');
    const filtersApplyButton = $('#filters button[type="button"]');
    const loadingDiv = `<div class="loading-container"><div class="spinner-border text-success m-1" role="status" id="red1"><span class="sr-only"><?= __("loading") ?>...</span> </div></div>`;


    const getFilters = () => new FormData(document.getElementById('filters'));


    const refreshResults = () => {
        const filters = getFilters();
        resultsContainer.html(loadingDiv);

        $.ajax({
            type: 'POST',
            url: '<?= current_url() ?>',
            data: filters,
            contentType: false,
            cache: false,
            processData: false,
            success: function (content) {
                resultsContainer.html(content);
            },
            error: function (err, xht) {
                resultsContainer.html(`<div class="alert alert-danger text-center w-100"><?= __("oops_error") ?></div>`);
            }
        });
    }

    $(document).ready(refreshResults);
    filtersApplyButton.click(refreshResults);
</script>

