<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="<?= base_url("assets/css/bootstrap.css"); ?>" rel="stylesheet">
    <link href="<?= base_url("assets/css/app.css"); ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://fontawesome.com/releases/v5.15/css/all.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
            integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css"/>
    <title>SMART QR User List</title>

    <style>
        select {
            border: 1px solid #cecece;
            border-radius: 7px;
            padding: 0rem 7px;
            outline: none;
        }

        .close-modal {
            top: 0.5rem !important;
            right: 0.5rem !important;
        }

        .modal {
            height: auto;
        }
    </style>
</head>
<body class="h-100 d-flex align-items-center justify-content-center" style="min-height: 95vh">
<div class="container">
    <div id="ex1" class="modal">
        <p class="text-center">Qr Code :</p>
        <div class="w-100 d-flex justify-content-center" style="min-height: 300px">
            <img class="qr-viewer" width="300px" src="" crossorigin="anonymous" alt="">
        </div>
        <div class="d-flex">
            <button class="btn mr-1 print-qr-code justify-content-center d-flex btn-success w-100">
                <img alt="print" class="mr-2" src="<?= base_url("assets/images/icons/printer.svg") ?>">
                <span>Print</span>
            </button>
            <button class="btn download-qr-code justify-content-center d-flex btn-warning w-100">
                <img alt="download" class="mr-2" src="<?= base_url("assets/images/icons/download.svg") ?>">
                <span>Download</span>
            </button>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                <th>#</th>
                <th>Name</th>
                <th>Show</th>
                </thead>
                <tbody>
                <?php foreach ($profiles as $key => $item) { ?>
                    <tr>
                        <td><?= $key + 1 ?></td>
                        <td><?= $item->fullname ?></td>
                        <td>
                            <a href="#ex1" data-key="<?= $item->id ?>" class="open-qr" rel="modal:open">
                                <img src="<?= base_url("assets/images/icons/qr-code.png") ?>" width="30px" alt="open">
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
<script>
    const generateQrCode = (id) => {
        const url = "<?= base_url("Profiles/view/") ?>" + id;
        return `https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=${encodeURI(url)}&choe=UTF-8&t=` + new Date().getTime();
    }
    const table = $("table");

    const ImageToPrint = () => {
        const source = $(".qr-viewer").attr("src");
        return "<html><head><scri" + "pt>function step1(){\n" +
            "setTimeout('step2()', 10);}\n" +
            "function step2(){window.print();window.close()}\n" +
            "</scri" + "pt></head><body onload='step1()'>\n" +
            "<img src='" + source + "' /></body></html>";
    }

    $(document).ready(function () {
        table.DataTable();
        table.on("click", ".open-qr", function () {
            const id = $(this).data("key");
            $(".qr-viewer").attr("src", generateQrCode(id));
        });

        $(".print-qr-code").click(function () {
            const pageLink = "about:blank";
            const pwa = window.open(pageLink, "_new");
            pwa.document.open();
            pwa.document.write(ImageToPrint());
            pwa.document.close();
        });

        const downloadButton = $(".download-qr-code");
        const downloadButtonStatus = $(".download-qr-code span");
        downloadButton.click(function () {
            const source = $(".qr-viewer").attr("src");
            downloadButton.attr("disabled", "disabled");
            downloadButtonStatus.html("Please Wait");

            fetch(source)
                .then(response => response.blob())
                .then(blob => {
                    const url = URL.createObjectURL(blob);

                    const a = $("<a>")
                        .attr("href", url)
                        .attr("download", "qr_code.png")
                        .appendTo("body");

                    a[0].click();
                    a.remove();

                    URL.revokeObjectURL(url);

                    downloadButton.removeAttr("disabled", "");
                    downloadButtonStatus.html("Download");
                });
        });
    });
</script>