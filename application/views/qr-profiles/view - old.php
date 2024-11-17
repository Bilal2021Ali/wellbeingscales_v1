<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="<?= base_url("assets/css/bootstrap.css"); ?>" rel="stylesheet">
    <link href="<?= base_url("assets/css/app.css"); ?>" rel="stylesheet">

    <title><?= $profile->fullname ?> Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <style>
        .tabs-container {
            margin-top: -33px;
        }

        .tabs-container span {
            border-radius: 1rem 1rem 0 0;
            box-shadow: 0 0 0 0;
            padding: 0.3rem 2rem 6px 2rem;
            background: #5b73e8;
            color: #d9d9d9;
            cursor: pointer;
        }

        .tabs-container span.active {
            background: #fff;
            color: black;
        }

        .tab-component {
            margin-bottom: 0.3rem;
            background: transparent;
            border-bottom: 1px solid #d3d3d3;
            box-shadow: 0 0 0 0;
        }

        .tab-component p {
            margin-bottom: 0;
        }

        .tab-component .card-body {
            align-items: center;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .icon-container {
            width: 3rem;
            font-size: 25px;
        }
    </style>
</head>
<body>
<header class="bg-primary p-5 text-center w-100">
    <img class="avatar avatar-lg rounded-lg mb-2"
         src="<?= base_url("uploads/company-profiles/" . $profile->id . ".jpg") ?>">
    <h3 class="mb-4 text-white"><?= $profile->fullname ?></h3>
</header>
<div class="container">
    <div class="d-flex justify-content-around tabs-container">
        <span data-target="contact" class="active tab">Contact</span>
        <span data-target="company" class="tab">Company</span>
        <span data-target="socials" class="tab">Socials</span>
    </div>

    <div class="pt-3 tab-content contact-tab active">
        <?= $showComponent("phone", "Mobile Phone", $profile->mobile) ?>
        <?= $showComponent("envelope", "Email", $profile->email) ?>
        <?= $showComponent("globe", "Personal Website", $profile->website) ?>
        <?= $showComponent("location-dot", "Location", $profile->location) ?>
    </div>

    <div class="pt-3 tab-content company-tab">
        <?= $showComponent("building", "Company", $profile->company) ?>
        <?= $showComponent("address-card", "Position", $profile->position) ?>
    </div>

    <div class="pt-3 tab-content socials-tab">
        <?= $showComponent('fab fa-facebook-square', "Facebook", $profile->facebook) ?>
        <?= $showComponent('fab fa-instagram', "Instagram", $profile->instagram) ?>
        <?= $showComponent("fab fa-twitter", 'twitter', $profile->twitter) ?>
        <?= $showComponent("fab fa-youtube", "youtube", $profile->youtube) ?>
        <?= $showComponent("fab fa-tiktok", "tiktok", $profile->tiktok) ?>
        <?= $showComponent("fab fa-linkedin", "Linked in", $profile->linkedIn) ?>
    </div>
</div>
</body>
<script>
    document.querySelectorAll(".tabs-container span.tab").forEach((el) => {
        el.addEventListener("click", function () {
            document.querySelector(".tabs-container .tab.active").classList.remove("active");
            document.querySelector(".tab-content.active").classList.remove("active");
            document.querySelector("." + el.dataset.target + "-tab").classList.add("active");
            el.classList.add("active");
        });
    });
</script>
</html>