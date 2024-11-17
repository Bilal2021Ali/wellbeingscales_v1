<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Result</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Roboto Condensed', sans-serif;
        }

        /* Style for the logo */
        .logo {
            display: block;
            margin: 0 auto;
            text-align: center;
        }

        /* Style for the background text */
        .result {
            text-align: center;
        }

        .result p {
            display: block;
            margin: 10px auto;
            padding: 10px;
            text-align: center;
            border-radius: 15px;
            color: #fff;
        }

        .positive {
            background-color: #ef1919;
        }

        .negative {
            background-color: #00701c;
        }

        hr {
            border-color: #00559d;
        }
    </style>
</head>
<body>
<!-- Logo -->
<div class="logo">
    <img height="60px" src="<?= base_url("assets/images/settings/logos/" . $settings['logo_url']) ?>" alt="Logo">
</div>

<table style="width:100%;">
    <tr>
        <td style="width:50%; vertical-align:top;">
            <p>
                <b>Name Of Patient :</b> <?= $user['name'] ?>
            </p>
            <p>
                <b>NID :</b> <?= $user['National_Id'] ?>
            </p>
            <p>
                <b>AGE :</b> <?= $age ?>
            </p>
            <p>
                <b>GENDER :</b> <?= strtolower($user['Gender']) === "m" ? "Male" : "Female" ?>
            </p></td>
        <td style="width:50%; vertical-align:top;"><p>
                <b>Institution Name :</b> <?= $schoolName ?>
            </p>
            <p>
                <b><?= $label ?> :</b> <?= $user['extraData'] ?>
            </p>
            <p>
                <b>Test Title :</b> <?= $testType ?>
            </p>
            <p>
                <b>Test Date :</b> <?= $testDate ?>
            </p></td>
    </tr
    >
</table>
<hr/>
<!-- Background text -->
<div class="result">
    <h2>Result</h2>
    <p class=" <?= $result ?>"><?= ucfirst($result) ?></p>
</div>
</body>
</html>