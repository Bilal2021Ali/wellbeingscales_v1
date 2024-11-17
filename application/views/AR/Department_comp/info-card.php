    <style>
        .data {
            padding: 20px;
        }
    </style>
    <?php $qrcodes = []; ?>
    <div class="main-content">
        <div class="page-content">
            <div class="row pagecon">
                <div class="col-12">
                    <?php foreach ($user_data as $user) :
                        $id = $user['Id'];
                        if (strtolower($user['Gender']) == 'm') {
                            $gender = "Male";
                        } else {
                            $gender = "Female";
                        }
                        $n_id = $user['National_Id'];
                        $text = "Full Name :" . $user['F_name_EN'] . ' ' . $user['M_name_EN'] . ' ' . $user['L_name_EN'] . '\n';
                        $text .= "Gender :" . $gender . '\n';
                        $text .= "Nationality :" . $user['Nationality'] . '\n';
                        $text .= "National ID :" . $user['National_Id'] . '\n';
                        $text .= "Department Name :" . $sessiondata['username'] . '\n';
                        $qrcodes['user_' . $id] =  $text; ?>
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">Card For <?= $user['F_name_EN'] . ' ' . $user['L_name_EN'] ?></div>
                                <div class="row">
                                    <div class="fOR8pRINT col-lg-8 " id="fOR8pRINT">
                                        <div class="col-lg-8" style="padding-top: 40px;">
                                            <h4> Full Name : <?= $user['F_name_EN'] . ' ' . $user['M_name_EN'] . ' ' . $user['L_name_EN'] ?></h4>
                                            <h4> Gender : <?= $gender; ?></h4>
                                            <h4> DOB : <?= $user['DOP']; ?></h4>
                                            <h4> Nationality : <?= $user['Nationality']; ?></h4>
                                            <h4> National ID : <?= $user['National_Id']; ?></h4>
                                            <h4> Department Name : <?= $sessiondata['username']; ?></h4>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 data">
                                        <div class="qr ToExp" id="<?= 'user_' . $id ?>"></div>
                                        <!-- <div style="margin-left: -67px;margin-top: 12px;">
                                            <canvas id="bcTarget_<?= $id ?>" class="ToExp"></canvas>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="row text-center mt-2">
                                    <div class="col-sm-4">
                                        <button type="button" class="btn btn-primary btn-block waves-effect waves-light mt-2 mr-1" onClick="Save_As_Pdf('<?= $user['F_name_EN'] . '_' . $user['M_name_EN'] . '_' . $user['L_name_EN'] ?>' , <?= $user['Id'] ?>)">
                                            <i class="uil uil-file mr-2"></i> Save as PDF
                                        </button>
                                    </div>
                                    <div class="col-sm-4">
                                        <button type="button" class="btn btn-light btn-block waves-effect  mt-2 waves-light" onClick="prin_card();">
                                            <i class="uil uil-print mr-2"></i> Print Now
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <?php print_r($qrcodes) ?>
    </body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script src="<?= base_url("assets/libs/jspdf.min.js"); ?>"></script>
    <script src="<?= base_url('assets/js/jquery-qrcode-min.js'); ?>"></script>
    <script src="<?= base_url("assets/js/jquery-barcode.min.js"); ?>"></script>
    <script>
        var settings = {
            barWidth: 3,
            barHeight: 50,
            moduleSize: 5,
            showHRI: true,
            addQuietZone: true,
            marginHRI: 15,
            bgColor: "#FFFFFF",
            color: "#000000",
            fontSize: 10,
            output: 'canvas',
            posX: 0,
            posY: 0,
            x: 10,
            y: 20,
        };
        <?php foreach ($qrcodes as $key => $qrcode) { ?>
            $('#' + '<?= $key ?>').qrcode({
                render: 'canvas',
                minVersion: 1,
                maxVersion: 40,
                ecLevel: 'L',
                left: 0,
                top: 0,
                size: 200,
                fill: '#000',
                background: null,
                text: `<?= $qrcode; ?>`,
                radius: 0.02,
                quiet: 0,
                mode: 0,
                mSize: 0.1,
                mPosX: 0.5,
                mPosY: 0.5,
                fontname: 'sans',
                fontcolor: '#000',
                image: null
            });
        <?php } ?>

        function Save_all_page_as_Pdf(name) {
            html2canvas($('.pagecon')).then(function(canvas) {
                //document.body.appendChild(canvas);
                var imgdata = canvas.toDataURL('image/png');
                var doc = new jsPDF();
                doc.addImage(imgdata, 'PNG', 0, 0);
                //doc.addImage(imgdata_bar, 'PNG' , 120, 80);
                // Save the PDF 
                doc.save(name + '.pdf');
            });
        }

        function Save_As_Pdf(name, id, classname = 'data') {
            html2canvas($('.' + classname)).then(function(canvas) {
                document.body.appendChild(canvas);
                var imgdata = canvas.toDataURL('image/png');
                var doc = new jsPDF();
                let width = doc.internal.pageSize.width - 70;
                console.log('width is :', width);
                var pr = document.querySelector('#fOR8pRINT');
                //console.log(imgdata_bar);
                doc.fromHTML(pr, 15, 15);
                doc.addImage(imgdata, 'PNG', width, 0);
                // Save the PDF
                doc.save(name + '.pdf');
            });
        }

        function prin_card() {
            html2canvas($('.data')).then(function(canvas) {
                var imgdata = canvas.toDataURL('image/png');
                var restorpage = document.body.innerHTML;
                var printcontent = document.getElementById('fOR8pRINT').innerHTML;
                document.body.innerHTML = printcontent;
                document.body.appendChild(canvas);
                window.print();
                location.reload();
            });
        }
    </script>