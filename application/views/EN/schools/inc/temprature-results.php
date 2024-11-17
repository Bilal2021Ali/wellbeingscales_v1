<div class="col-md-6 col-xl-3 text-center">
    <div class="card notStatic">
        <div class="card-body" style="padding: 5px">
            <div class="card-body badge-soft-info" style="height: 130px;display: grid;align-items: center;border-radius: 5px;border: 6px solid #50a5f1;">
                <div>
                    <div class="row">
                        <div class="col-xl-2" style="text-align: center;align-items: center;display: grid;">
                            <img src="<?= base_url(); ?>assets/images/icons/png_icons/temperature_counter.png" alt="Low Temperature" style="width: 40px;">
                        </div>
                        <div class="col-xl-8">
                            <p class="mb-0 badge badge-info font-size-12">Low Temperature</p>
                            <span class="badge font-size-12" style="width: 104px;background-color: #172b88;color: #fff;margin: 5px auto;
                                                                display: block;"> Stay Home <?= $tempr['LOW_In_Home']; ?></span>
                            <span class="badge font-size-12" style="width: 104px;background-color: #ff2e00;color: #fff;margin: 5px auto;
                                                                display: block;"> Quarantine <?= $tempr['LOW_In_Quern']; ?></span>
                            <span class="badge font-size-12" style="width: 104px;background-color: #00ab00;color: #fff;margin: 5px auto;
                                                                display: block;"> No Action <?= $tempr['LOW_In_School']; ?></span>
                        </div>
                        <div class="col-xl-2" style="text-align: center;align-items: center;display: grid;">
                            <h4 class="mb-1 mt-1"> <span data-plugin="counterup"><?= $tempr['LOW']; ?></span> </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-6 col-xl-3 text-center">
    <div class="card notStatic">
        <div class="card-body" style="padding: 5px">
            <div class="card-body badge-soft-success" style="height: 130px;display: grid;align-items: center;border-radius: 5px;border: 6px solid #34ccc7;">
                <div class="row" style="margin-top: 13px;">
                    <div class="col-xl-2" style="text-align: center;align-items: center;display: grid;"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/green.png" alt="Temperature" style="width: 30px;margin-top: 5px;"> </div>
                    <div class="col-xl-10">
                        <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?= $tempr['NORMAL']; ?></span></h4>
                        <p class="mb-0 badge badge-success font-size-12">Normal Temperature</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-6 col-xl-3 text-center">
    <div class="card notStatic">
        <div class="card-body" style="padding: 5px">
            <div class="card-body badge-soft-warning" style="height: 130px;display: grid;align-items: center;border-radius: 5px;border: 6px solid #f1b44c;">
                <div>
                    <div class="row">
                        <div class="col-xl-2" style="text-align: center;align-items: center;display: grid;"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/orange.png" alt="Low Temperature" style="width: 30px;"> </div>
                        <div class="col-xl-8">
                            <p class="mb-0 badge badge-warning font-size-12">Moderate Temperature</p>
                            <span class="badge font-size-12" style="width: 104px;background-color: #172b88;color: #fff;margin: 5px auto;display: block;">Stay Home <?= $tempr['MODERATE_In_Home']; ?></span> <span class="badge font-size-12" style="width: 104px;background-color: #ff2e00;color: #fff;margin: 5px auto;display: block;">Quarantine <?= $tempr['MODERATE_In_Quern']; ?></span> <span class="badge font-size-12" style="width: 104px;background-color: #00ab00;color: #fff;margin: 5px auto;display: block;">No Action <?= $tempr['MODERATE_In_School']; ?></span>
                        </div>
                        <div class="col-xl-2" style="text-align: center;align-items: center;display: grid;">
                            <h4 class="mb-1 mt-1"> <span data-plugin="counterup"><?= $tempr['MODERATE']; ?></span> </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-6 col-xl-3 text-center">
    <div class="card notStatic">
        <div class="card-body" style="padding: 5px">
            <div class="card-body badge-soft-danger" style="border-radius: 4px;border: 6px solid #f57d6a;height: 130px;">
                <div class="float-right mt-2"> </div>
                <div class="row">
                    <div class="col-xl-2" style="text-align: center;align-items: center;display: grid;"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/red.png" alt="Low Temperature" style="width: 30px;"> </div>
                    <div class="col-xl-8">
                        <p class="mb-0 badge badge-danger font-size-12">High Temperature</p>
                        <span class="badge font-size-12" style="width: 104px;background-color: #172b88;color: #fff;margin: 5px auto;display: block;">Stay Home <?= $tempr['HIGH_In_Home']; ?></span> <span class="badge font-size-12" style="width: 104px;background-color: #ff2e00;color: #fff;margin: 5px auto;display: block;">Quarantine <?= $tempr['HIGH_In_Quern']; ?></span> <span class="badge font-size-12" style="width: 104px;background-color: #00ab00;color: #fff;margin: 5px auto;display: block;">No Action <?= $tempr['HIGH_In_School']; ?></span>
                    </div>
                    <div class="col-xl-2" style="text-align: center;align-items: center;display: grid;">
                        <h4 class="mb-1 mt-1"> <span data-plugin="counterup"><?= $tempr['HIGH'] ?></span> </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>