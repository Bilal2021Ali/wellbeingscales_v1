<?php
/**
 * @var \App\DTOs\RefrigeratorResultDTO $result
 */
?>


<div class="card">
    <div class="card-body text-center">
        <h5 class="card-title" style="font-size: 24px; color: #3db7b7;">
            <span style='font-size: 20px; color: #3db7b7;'><?= $result->getTime() ?></span>
            <br>
            <span style='font-size: 16px; color: gray;'><?= $result->getDate() ?></span><br>
        </h5>

        <p class="card-text"><?= __("temperature") ?></p>
        <div class="temp <?= $result->getTemperatureLabel()->cssClass() ?>">
            <span class="value"><?= $result->temp ?></span>
            <span class="highlight-title"><?= $result->getTemperatureLabel()->label() ?></span>
        </div>

        <p class="card-text standard">
            <?= __("standard") ?>
            <span class="good" >
                <span style="font-weight: bold; color: black;"><?= $result->getDeviceType() ?></span>
            </span>
        </p>

        <p class="card-text"><?= __("humidity") ?></p>
        <div class="hum <?= $result->getHumidityLabel()->cssClass() ?>">
            <span class="badge"><?= $result->getHumidity() ?></span>
            <span class="highlight-title"><?= $result->getHumidityLabel()->label() ?></span>
        </div>

        <p class="card-text" style="font-weight: bold; color: black;">
            <?= __("standard_humidity", [
                'min' => $result::MIN_HUMIDITY,
                'max' => $result::MAX_HUMIDITY,
            ]) ?>
        </p>
        <p class="card-text" style="color: black; font-size: 16px;">
            <?= $result->device_description ?>
        </p>
        <p class="card-text"><?= __("battery_life") ?> <?= $result->battery_life ?></p>

        <div class="device-status"
             style="border-color: <?= $result->getDeviceStatus()->borderColor() ?>;background-color: <?= $result->getDeviceStatus()->backgroundColor() ?>">
            <span><?= $result->getDeviceStatus()->label(); ?></span>
        </div>
    </div>
</div>
