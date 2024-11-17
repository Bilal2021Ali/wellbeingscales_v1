<script>
    function resultsByStatus() {
        const results = $('#results_statuses');
        results.html(loadingDiv);

        $.ajax({
            type: 'POST',
            url,
            data: {
                ...getDefaultOptions(),
                type: TYPES.status,
                month: statusMonthSelect.val()
            },
            success: function (data) {
                results.html(data);
            },
            ajaxError: function () {
                results.html(errorContent);
            }
        });
    }
    resultsByStatus();
    statusMonthSelect.change(resultsByStatus);
</script>