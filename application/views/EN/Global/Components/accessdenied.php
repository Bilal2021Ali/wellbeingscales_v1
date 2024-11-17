<style>
    .accessdeniedimg {
        width: 100%;
        max-width: 300px;
    }
</style>
<div class="col-12 text-center">
    <img src="<?= base_url("assets/images/temp_compnent_access.svg") ?>" class="img-responsive mb-2 mt-2 accessdeniedimg" alt="">
    <?php if ($this->uri->segment(1) == "AR") { ?>
        <h3>نعتذر !! ليس لديك إذن للوصول إلى هذا الإمكانية</h3>
    <?php } else { ?>
        <h3>Sorry. you don't have permission to access this component</h3>
    <?php } ?>
</div>