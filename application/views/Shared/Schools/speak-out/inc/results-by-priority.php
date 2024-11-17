<script>
    function resultsByPriority() {
        const results = $('#results_priorities');
        results.html(loadingDiv);

        $.ajax({
            type: 'POST',
            url,
            data: {
                ...getDefaultOptions(),
                type: TYPES.PRIORITY,
                month: priorityMonthSelect.val()
            },
            success: function (data) {
                results.html(data);
            },
            ajaxError: function () {
                results.html(errorContent);
            }
        });
    }

    resultsByPriority();
    priorityMonthSelect.change(resultsByPriority);
</script>