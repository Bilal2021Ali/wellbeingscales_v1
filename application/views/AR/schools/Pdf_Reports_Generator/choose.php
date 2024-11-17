<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>

<div class="main-content">
    <div class="page-content">
        <div class="col-12">
            <div id="iframe"></div>
            <div class="row">
                <?php foreach ($reports as $sn => $report) { ?>
                    <div class="col-lg-6">
                        <div class="card">
                            <iframe height="200" src="<?= base_url("uploads/PdfReportTemplates/") . $report['preview'] ?>" style="border : none"></iframe>
                            <div class="card-body text-center">
                                <h3 class="mb-2"><?= $report['title'] ?></h3>
                                <button onclick="Save_all_page_as_Pdf('001222');" href="<?= current_url() . "/" . ($sn + 1) ?>" class="btn btn-primary w-100">Generate This Report</button>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <section class="testExport" style="width : 300px">
                <div class="row">
                    <div class="col-6">
                        <img class="w-100" src="<?= base_url("assets/images/5224064.webp") ?>" alt="">
                    </div>
                    <div class="col-6">
                        <h2>Hi</h2>
                        <p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Proin eget tortor risus. Curabitur aliquet quam id dui posuere blandit. Pellentesque in ipsum id orci porta dapibus.
                            Sed porttitor lectus nibh. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Nulla quis lorem ut libero malesuada feugiat. Proin eget tortor risus.
                            Pellentesque in ipsum id orci porta dapibus. Donec sollicitudin molestie malesuada. Donec sollicitudin molestie malesuada. Donec rutrum congue leo eget malesuada.</p>
                    </div>
                </div>
            </section>
            <div id="elementH"></div>
        </div>
    </div>
</div>
<script src="<?= base_url("assets/libs/jspdf.min.js"); ?>"></script>

<script>
    function Save_all_page_as_Pdf(name) {
        // html2canvas($('.col-12')).then(function(canvas) {
        //     //document.body.appendChild(canvas);
        //     var imgdata = canvas.toDataURL('image/png');
        //     /*var imgdata_bar = html2canvas($('#bcTarget')).then(function(img){
        //         img.toDataURL('image/png');
        //     });	*/
        //     var doc = new jsPDF();
        //     //var pr = document.querySelector('#fOR8pRINT');
        //     //console.log(imgdata_bar);
        //     //doc.fromHTML(pr,15,15);
        //     doc.addImage(imgdata, 'PNG', 0, 10, 210, 210);
        //     //doc.addImage(imgdata_bar, 'PNG' , 120, 80);
        //     /* Add new page
        //     doc.addPage();
        //     doc.text(20, 20, 'Visit CodexWorld.com');*/

        //     // Save the PDF
        //     doc.save(name + '.pdf');
        // });
        var doc = new jsPDF();
        var elementHTML = $('.testExport').html();
        var specialElementHandlers = {
            '#elementH': function(element, renderer) {
                return true;
            }
        };
        doc.fromHTML(elementHTML, 15, 15, {
            'width': 300,
            'elementHandlers': specialElementHandlers
        });

        // Save the PDF
        doc.save('sample-document.pdf');
    }
</script>