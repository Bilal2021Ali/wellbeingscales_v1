<link href="<?= base_url("assets/libs/select2/css/select2.min.css"); ?>" rel="stylesheet" type="text/css"/>
<script src="<?= base_url("assets/libs/select2/js/select2.min.js"); ?>"></script>
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
        <?php $this->load->view("Shared/Schools/speak-out/inc/filters", ['disableAllDefault' => true]) ?>
        <div class="pt-4 w-100" id="filters-results"></div>
    </div>
</div>
<script>

    $(".select2").select2();
    const loadingDiv = `<div class="loading-container"><div class="spinner-border text-warning m-1" role="status" id="red1"><span class="sr-only">Loading...</span> </div></div>`;
    const errorContent = `<div class="alert alert-danger w-100">Ooops! Error was found.</div>`;

    const schoolFilter = $('select[name="school"]');
    const classSelect = $('select[name="schools-classes[]"]');

    function getResults() {
        const results = $('#filters-results');
        results.html(loadingDiv);
        const city = $('.filters-form select[name="city"]')?.val();
        const country = $('.filters-form select[name="country"]')?.val();

        $.ajax({
            type: 'POST',
            url: '<?= base_url("/AR/DashboardSystem/speak-out"); ?>',
            data: {
                school: schoolFilter.val() ?? "",
                classes: classSelect.val() ?? [],
                city,
                country
            },
            success: function (data) {
                console.log(data);
                results.html(data);
                $('.table').DataTable({
                    language: {
                        url: '<?= base_url("assets/js/arabic_datatable.json"); ?>'
                    }
                });
            },
            ajaxError: function () {
                results.html(errorContent);
            }
        });
    }

    getResults();
    schoolFilter.change(getResults);
    classSelect.change(getResults);
</script>