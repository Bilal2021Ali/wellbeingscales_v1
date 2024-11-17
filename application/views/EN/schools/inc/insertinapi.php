<!-- the only reason why this page exsists is to call OTPLogin api -->
<script>
    // var data = {
    //     "email": "<?= $data["email"] ?>",
    //     "password": "<?= $data["password"] ?>",
    //     "reg_id": "<?= $data["reg_id"] ?>",
    //     "device_type": "<?= $data["device_type"] ?>",
    //     "language": "<?= $data["language"] ?>",
    //     "lat": "<?= $data["lat"] ?>",
    //     "log": "<?= $data["log"] ?>",
    //     "iso_from_registar": "<?= $data["iso_from_registar"] ?>",
    //     "city_name": "<?= $data["city_name"] ?>",
    //     "tracksystem": "<?= $data["tracksystem"] ?>",
    //     "country_id": "<?= $data["country_id"] ?>",
    //     "companyName": "<?= $data["companyName"] ?>",
    //     "nationalId": "<?= $data["nationalId"] ?>",
    //     "username": "<?= $data["username"] ?>",
    //     "gender": "<?= $data["gender"] ?>",
    //     "date_of_birth": "<?= $data["date_of_birth"] ?>"
    // };
    // $.ajax({
    //     type: "POST",
    //     url: "https://qlickhealth.com/admin/api/user/OTPLogin",
    //     data: JSON.stringify(data),
    //     success: function(response) {

    //     }
    // });


    var form = new FormData();
    form.append("email", "<?= $data["email"] ?>");
    form.append("password", "<?= $data["password"] ?>");
    form.append("reg_id", "<?= $data["reg_id"] ?>");
    form.append("device_type", "<?= $data["device_type"] ?>");
    form.append("language", "<?= $data["language"] ?>");
    form.append("lat", "<?= $data["lat"] ?>");
    form.append("log", "<?= $data["log"] ?>");
    form.append("iso_from_registar", "<?= $data["iso_from_registar"] ?>");
    form.append("city_name", "<?= $data["city_name"] ?>");
    form.append("tracksystem", "<?= $data["tracksystem"] ?>");
    form.append("country_id", "<?= $data["country_id"] ?>");
    form.append("companyName", "<?= $data["companyName"] ?>");
    form.append("nationalId", "<?= $data["nationalId"] ?>");
    form.append("username", "<?= $data["username"] ?>");
    form.append("gender", "<?= $data["gender"] ?>");
    form.append("date_of_birth", "<?= $data["date_of_birth"] ?>");

    var settings = {
        "url": "https://qlickhealth.com/admin/api/user/OTPLogin",
        "method": "POST",
        "timeout": 0,
        "processData": false,
        "mimeType": "multipart/form-data",
        "contentType": false,
        "data": form
    };

    $.ajax(settings).done(function(response) {
        console.log(response);
    });
</script>