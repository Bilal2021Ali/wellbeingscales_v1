<style>
    .rounded {
        border-radius: 15px !important;
    }

    .img-responsive {
        max-width: 200px;
    }

    .filter-btn.btn-primary,
    #applyfilters {
        color: #fff !important;
        background: #0eacd8;
        border: #0eacd8;
    }

    .filter-btn.btn-outline-primary {
        color: #0eacd8;
        border-color: #0eacd8;
    }

    .filter-btn.btn-outline-primary:hover {
        color: #fff;
        background-color: #048cb2;
        border-color: #048cb2;
    }

    .btn-success {
        color: #fff !important;
        background-color: #8eac2d;
        border-color: #8eac2d;
    }

    .btn-outline-success {
        color: #8eac2d;
        border-color: #95b626;
    }

    .btn-success:hover , .btn-success:active {
        color: #ffffff;
        background-color: #add138 !important;
        border-color: #add138 !important;
    }

    .btn-outline-success:hover ,.btn-outline-success:active  {
        color: #fff;
        background-color: #8fae2a !important;
        border-color: #add138 !important;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <h3 class="card text-center" style="background: #0eacd8; padding: 30px;color: #fff;border-radius: 20px;">INSTITUTIONAL WELLBEING CLIMATE DETAILED REPORT</h3>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Filters : </h3>
                <div class="row">
                    <?php foreach ($userstypes as $userstype) { ?>
                        <div class="col">
                            <button type="button" data-filter="t" data-value="<?= $userstype['code'] ?>" class="btn filter-btn filter-btn-t <?= $t == $userstype['code'] ? "btn-primary" : "btn-outline-primary" ?> w-100 waves-effect waves-light"><?= ucfirst($userstype['name']); ?></button>
                        </div>
                    <?php } ?>
                    <div class="col">
                        <button type="button" data-filter="C" data-value="d" class="btn filter-btn filter-btn-c <?= $c == 'd' ? "btn-success" : "btn-outline-success" ?> w-100 waves-effect waves-light">Daily Counter</button>
                    </div>
                    <div class="col">
                        <button type="button" data-filter="C" data-value="M" class="btn filter-btn filter-btn-c <?= $c == 'm' ? "btn-success" : "btn-outline-success" ?> w-100 waves-effect waves-light">Monthly Counter</button>
                    </div>
                    <div class="col">
                        <button type="button" data-filter="C" data-value="y" class="btn filter-btn filter-btn-c <?= $c == 'y' ? "btn-success" : "btn-outline-success" ?> w-100 waves-effect waves-light">Yearly Counter</button>
                    </div>
                </div>
                <form action="<?= current_url(); ?>" method="post">
                    <input type="hidden" name="t" value="<?= $t ?>">
                    <input type="hidden" name="C" value="<?= $c ?>">
                    <button id="applyfilters" type="submit" class="btn btn-primary w-100 waves-effect waves-light mt-2">Regenerate</button>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <?php if (!empty($results)) { ?>
                    <div class="row">
                        <?php foreach ($results as $result) { ?>
                            <div class="col-xl-4 col-sm-6">
                                <div class="text-center" dir="ltr">
                                    <h5 class="font-size-14 mb-3"><?= $result['title'] ?></h5>
                                    <input class="knob" data-width="150" data-height="150" data-linecap=round data-fgColor="#0eacd8" value="<?= $result['ff'] ?>" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".5" />
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <div class="w-100 text-center p-5">
                        <img src="<?= base_url('assets/images/nosurveys.svg'); ?>" class="img-responsive">
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <p class="mb-0">ملاحظة: يوصى باستخدام المقاييس والمقاييس المتوفرة في مكتبة المسح لتقييم الحالات السلوكية والعقلية المحددة بناءً على مستوى المناخ. تشير الدرجة 50٪ (من 100٪) وما فوق إلى ظروف الرفاهية البارزة التي تحتاج إلى مزيد من التقييم.</p>
            </div>
        </div>
       <div class="card-body">
                <h3 class="card text-center" style="background: #0eacd8; padding: 30px;color: #fff;border-radius: 20px;">خطة العمل الموصى بها</h3>
            </div>
        <div class="row px-2">
            <div class="col text-center card p-2 bg-success text-white ml-2 rounded">
                مقياس المناخ المدرسي
            </div>
            <div class="col text-center card p-2 bg-warning text-white ml-2 rounded">
                إدارة المقاييس والمقاييس لمزيد من التقييم
            </div>
            <div class="col text-center card p-2 bg-primary text-white ml-2 rounded">
                تفسير البيانات والتدخل المحتمل
            </div>
            <div class="col text-center card p-2 bg-danger text-white ml-2 rounded">
                تحسين المناخ المؤسسي
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url("assets/libs/jquery-knob/jquery.knob.min.js") ?>"></script>
<script>
    const defaultfilters = {
        "t": <?= $t ?>,
        "C": "<?= $c ?>"
    }
    $('.filter-btn').click(function() {
        const $this = $(this);
        const typeoffilter = $(this).data('filter');
        const filter = $(this).data('value');
        const variant = typeoffilter == 't' ? "primary" : "success";
        $('.filter-btn-' + typeoffilter).removeClass('btn-' + variant + '');
        $('.filter-btn-' + typeoffilter).addClass('btn-outline-' + variant + '');
        $($this).addClass('btn-' + variant + '');
        $($this).addClass('btn-outline-' + variant + '');
        console.log(filter);
        $('input[name="' + typeoffilter + '"]').val(filter);
        return $('#applyfilters').removeClass('hidden');
        $('#applyfilters').addClass('hidden');
    });
    $(function() {
        $(".knob").knob();
    });
</script>