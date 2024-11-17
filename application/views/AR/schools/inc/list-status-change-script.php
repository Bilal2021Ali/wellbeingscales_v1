<script>
    $("table").on("change", ".user-status", function () {
        const target = $(this).data("key");
        const isChecked = $(this).is(":checked");
        $.ajax({
            type: "POST",
            url: "<?= base_url("EN/schools/change-user-status/" . $type) ?>",
            data: {
                id: target
            },
            success: function (response) {
                if (response.status !== "ok") {
                    alert("sorry we had an error");
                } else {
                    toastr["success"]("<?= strpos(strtolower(current_url()), "/ar/") ? "Changes have been saved." : "تم حفظ التحديثات بنجاح" ?>")
                }
            }
        });
    });
</script>