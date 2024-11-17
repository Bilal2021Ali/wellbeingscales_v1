<div class="modal fade show-more-labels-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body overflow-auto text-center">

            </div>
        </div>
    </div>
</div>
<script>
    $("body").on("click", ".show-more-labels", function () {
        const value = $(this).data("value");
        if (!value || value.length < 1) return;

        $('.show-more-labels-modal').modal('show');

        let content = '';
        value.split(",").forEach(function (label) {
            content += `<span class="badge bg-success font-size-13 ml-1 mt-1 p-2 rounded-pill text-white">${label}</span>`;
        });

        $(".show-more-labels-modal .modal-body").html(content);
    });
</script>