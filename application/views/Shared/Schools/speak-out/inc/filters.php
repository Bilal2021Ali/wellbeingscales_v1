<div class="pb-3 filters-form row">
    <div class="col-lg-3 col-sm-12">
        <label><?= __('country') ?></label>
        <select name="country" class="form-control school-filter select2">
            <option value="" selected><?= __('all') ?></option>
            <?php foreach ($countries as $country) { ?>
                <option value="<?= $country['id'] ?>"><?= $country['name'] ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="col-lg-3 col-sm-12">
        <label><?= __('school-city') ?></label>
        <select name="city" class="form-control school-filter cities-select">
            <!--            --><?php //foreach ($cities as $city) { ?>
            <!--                <option value="--><?php //= $city['Id'] ?><!--">-->
            <?php //= $city['Name_EN'] ?><!--</option>-->
            <!--            --><?php //} ?>
        </select>
    </div>
    <div class="col-lg-3 col-sm-12">
        <label><?= __('school') ?></label>
        <select name="school" class="form-control">
            <option value="<?= isset($disableAllDefault) ? '' : 'all' ?>"
                    selected><?= __('all') ?></option>
            <?php foreach ($schools as $school) { ?>
                <option data-country="<?= $school['Country'] ?>" data-city="<?= $school['Citys'] ?>"
                        value="<?= $school['Id'] ?>"><?= $school['School_Name_' . $language] ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="col-lg-3 col-sm-12">
        <label><?= __('genders') ?></label>
        <select name="global-gender" class="form-control">
            <option value="" selected><?= __('all') ?></option>
            <option value="M"><?= __('male') ?></option>
            <option value="F"><?= __('female') ?></option>
        </select>
    </div>
</div>
<script>
    $('.school-filter').change(function () {
        const city = parseInt($('.filters-form select[name="city"]').val());
        const country = parseInt($('.filters-form select[name="country"]').val());

        $('.filters-form select[name="school"] option').each(function () {
            const el = $(this);
            const currentCity = el.data("city");
            const currentCountry = el.data("country");

            console.log({city, country, currentCity, currentCountry});
            if ((isNaN(city) || currentCity === city) && (!country || currentCountry === country)) {
                el.show();
            } else {
                el.hide();
            }
        });

        // reset to default
        $('select[name="school"]').val("").trigger('change');
    });

    $(document).ready(function () {
        $(".cities-select").select2();
        $('.filters-form select[name="country"]').change(function () {
            $(".cities-select").select2("destroy");
            const country = $(this).val();
            const options = country
                ? {
                    ajax: {
                        url: function () {
                            return '<?= base_url("EN/DashboardSystem/cities") ?>/' + $('.filters-form select[name="country"]').val() + "?withSchools=true";
                        },
                        dataType: 'json',
                        closeOnSelect: false,
                        allowClear: true,
                        placeholder: 'Select Cities',
                        processResults: function (data) {
                            return {
                                results: data.map(function (item) {
                                    return {
                                        text: item.name,
                                        id: item.id
                                    }
                                })
                            }
                        }
                    }
                } : {};
            $(".cities-select").select2(options);
        });
    });
</script>
