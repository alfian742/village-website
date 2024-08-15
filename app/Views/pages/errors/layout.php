<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= base_url('assets/img/logo.svg'); ?>">
    <link rel="apple-touch-icon" href="<?= base_url('assets/img/logo.svg'); ?>">

    <!-- Core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/css/app.css">

    <!-- Custom CSS -->
    <style>
        #error {
            background-color: #ebf3ff;
            padding: 2rem 0;
            min-height: 100vh
        }

        #error .img-error {
            height: 435px;
            object-fit: contain;
            padding: 3rem 0
        }

        #error .error-title {
            font-size: 3rem;
            margin-top: 1rem
        }

        html[data-bs-theme=dark] #error {
            background-color: #151521
        }
    </style>
</head>

<body>
    <!-- Check theme -->
    <script src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/static/js/initTheme.js"></script>

    <!-- Content -->
    <div id="error">
        <div class="error-page container">
            <?= $this->renderSection('content'); ?>
        </div>
    </div>
</body>

</html>