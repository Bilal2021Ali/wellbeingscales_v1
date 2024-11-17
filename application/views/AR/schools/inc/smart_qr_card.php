<!-- for post request in smartqrcode -->
<style>
    .ToExp {
        border: 4px solid #add138;
        padding-top: 5px;
    }
</style>
<?php if (!empty($userdata)) { ?>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6" style="align-self: center;">
                        <p> إسم المستخدم : <?= $userdata['F_name_AR'] . " " . $userdata['L_name_AR'] ?></p>
                        <p> الهوية الوطنية : <?= $userdata['National_Id'] ?></p>
                    </div>
                    <div class="col-lg-6 data">
                        <div class="qr ToExp text-center" id="qr_<?= $sn ?>"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

        $('#qr_<?= $sn ?>').qrcode({
            // render method: 'canvas', 'image' or 'div'
            render: 'canvas',

            // version range somewhere in 1 .. 40
            minVersion: 1,
            maxVersion: 40,

            // error correction level: 'L', 'M', 'Q' or 'H'
            ecLevel: 'L',

            // offset in pixel if drawn onto existing canvas
            left: 0,
            top: 0,

            // size in pixel
            size: 200,

            // code color or image element
            fill: '#000',

            // background color or image element, null for transparent background
            background: null,
            // content
            text: `<imageXML><cte>
            <v1><?= $userdata['National_Id'] ?></v1>
            <v2>5</v2>
            <v3>#11855C</v3>
            <v4><?= $userdata['F_name_EN'] . " " .$userdata['M_name_EN'] . " " . $userdata['L_name_EN'] ?></v4>
            <v5>0</v5>
            <v6>0</v6>
            <v7>0</v7>
            <v8><?= date("d/m/Y H:i:s A") ?></v8>
            <v9><?= $userdata['F_name_AR'] . " " .$userdata['M_name_AR'] . " " . $userdata['L_name_AR'] ?></v9>
            <v10>1</v10>    
            <v11>COVID-19, mRNA, LNP-S, PF, 30 mcg/0.3 mL dose</v11>
            <v12>COVID-19, mRNA, LNP-S, PF, 30 mcg/0.3 mL dose</v12>
            <v13><?= date("Y-m-d")?></v13>
            <v14><?= date("Y-m-d")?></v14>
            <v15>-</v15>
            <v16>HC00000000</v16>
            <v17><?= date("Y-m-d")?></v17>
            <v18>Negative</v18>
            <v19>-</v19>
            </cte>
            <DS>FQAFAgQAAACTaIrNa2flSOxwPPgxZUCD4Zakf79NZetkE3xag8Z+8vR0rbYNLmTl6PRTjWDKjJoxMwMhwCJqZvJkFrhjD1rjIfiYbxL6k7/gXHDo6kbSyxwBXS2Lw7kxntltKHVPeP/7bbYhuxs/zVpSbUgKtcGN65568oTTa7I/ucTbK0CVC2K8wAHUE44e2WZoKcYtXR7kkXN7JezhXac5R6kmPSWC6hyTE964NjTwLLHkJX2U+RhwjvL8EuIQwtRj7U65wxDME1wSiFO8s5OLjsojRY+CuIQwtRj7+RhwjvL8EuIQwtR/FLhIcVnBkwkIp+0Y/sWh0HmGXaqw</DS></imageXML>`,
            // the code should start with A instead of F
            // corner radius relative to module width: 0.0 .. 0.5
            radius: 0.02,
            // quiet zone in modules
            quiet: 0,
            // modes
            // 0: normal
            // 1: label strip
            // 2: label box
            // 3: image strip
            // 4: image box
            mode: 0,
            mSize: 0.1,
            mPosX: 0.5,
            mPosY: 0.5,
            fontname: 'sans',
            fontcolor: '#000',
            image: null
        });
        </script>
        <?php } ?>