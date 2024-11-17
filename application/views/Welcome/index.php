<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Choose Country Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css">

<!-- Font Awesome for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Almarai:wght@700&display=swap" rel="stylesheet">

<style>
    body {
        margin: 0;
        padding: 0;
        background: url('assets/images/bg-01.jpg') no-repeat center center fixed;
        background-size: cover;
        font-family: 'Almarai', sans-serif;
        animation: backgroundMove 30s linear infinite;
    }

    @keyframes backgroundMove {
        0% {
            background-position: 0% center;
        }
        100% {
            background-position: 100% center;
        }
    }

    .container {
        height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .header-title {
        font-size: 2.5rem;
        font-weight: bold;
        color: #fff;
        margin-bottom: 20px;
        text-align: center;
    }

    .row {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
    }

    .icon-box {
        text-align: center;
    }

    .icon-box img {
        width: 100px;
        height: auto;
        margin-bottom: 10px;
        transition: transform 0.3s ease;
        cursor: pointer;
    }

    .icon-box img:hover {
        transform: scale(1.2);
    }

    .icon-box a {
        text-decoration: none;
        color: #fff;
        font-size: 1.2rem;
        font-weight: bold;
    }

    .privacy-policy {
        margin-top: 20px;
        text-align: center;
        font-size: 1rem;
    }

    .privacy-policy a {
        color: #fff;
        text-decoration: none;
        font-weight: bold;
    }

    .footer {
        margin-top: 30px;
        text-align: center;
        color: #fff;
        font-size: 1rem;
    }

    .footer-links {
        margin-top: 10px;
        font-size: 0.9rem;
    }

    .footer-links a {
        color: #fff;
        text-decoration: none;
        margin: 0 15px;
        font-weight: bold;
    }

    .footer-links a:hover {
        text-decoration: underline;
    }
</style>
</head>
<body>
<div class="container">
    <!-- عنوان الصفحة -->
    <div class="header-title">
        Welcome to Wellbeing Scales
    </div>

    <div class="row">
    <!-- الرابط الأول: السعودية -->
    <div class="icon-box">
        <a href="<?= base_url(); ?>EN/Users">
            <img src="<?= base_url(); ?>assets/images/saudi-arabia.png" alt="Saudi Arabia">
            <p>السعودية</p>
        </a>
    </div>
    <!-- الرابط الثاني: قطر -->
    <div class="icon-box">
        <a href="<?= base_url(); ?>EN/Users">
            <img src="<?= base_url(); ?>assets/images/qatar.png" alt="Qatar">
            <p>قطر</p>
        </a>
    </div>
    <!-- الرابط الثالث: الإمارات -->
    <div class="icon-box">
        <a href="<?= base_url(); ?>EN/Users">
            <img src="<?= base_url(); ?>assets/images/united-arab-emirates.png" alt="UAE">
            <p>الإمارات</p>
        </a>
    </div>
    <!-- الرابط الرابع - الأردن -->
    <div class="icon-box">
        <a href="<?= base_url(); ?>EN/Users">
            <img src="<?= base_url(); ?>assets/images/jordan.png" alt="Jordan">
            <p>الأردن</p>
        </a>
    </div>
</div>


    <!-- الفوتر مع السنة الديناميكية -->
    <div class="footer">
        

        <!-- روابط إضافية في الفوتر -->
        <div class="footer-links">
            <a href="terms-and-conditions.html">Terms & Conditions</a>
            <a href="privacy-policy.html">Privacy Policy</a>
            <a href="cookies-policy.html">Cookies Policy</a>
            <a href="copyright-notification.html">Copyrights Notification</a>
        </div>
		<br>
		<p>Copyright © <span id="currentYear"></span> Wellbeing Scales. All rights reserved.</p>
    </div>
</div>

<!-- JavaScript لجعل السنة ديناميكية -->
<script>
    // جلب السنة الحالية
    document.getElementById("currentYear").textContent = new Date().getFullYear();
</script>
</body>
</html>
