<style>
    .time-border {
	    
        border: 3px solid #e9f2f9
;
        padding: 5px 35px;
        border-radius: 5px;
    }

    .time-border span {
        font-size: 18px;
    }

    .real-time-clock,
    .real-time-clock * {
        font-family: 'Glegoo', sans-serif !important;
    }
</style>
<div class="align-items-center btn d-flex font-weight-bolder header-item waves-effect real-time-clock">
    <div class="time-border <?= isset($center) && $center ? "m-auto" : "" ?>">
        <span class="hours">--</span>
        :
        <span class="minutes">--</span>
        :
        <span class="seconds">--</span>
    </div>
</div>
<script>
    // first Load
    var today = new Date();
    $(".real-time-clock .seconds").html(today.getSeconds());
    $(".real-time-clock .minutes").html(today.getMinutes());
    $(".real-time-clock .hours").html(today.getHours());
    // update 
    setInterval(() => {
        var today = new Date();
        $(".real-time-clock .seconds").html(today.getSeconds());
        $(".real-time-clock .minutes").html(today.getMinutes());
        $(".real-time-clock .hours").html(today.getHours());
    }, 1000);
</script>