<?php foreach ($situs as $site) : ?>
    <!DOCTYPE html>
    <html lang="eng">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $site['nama_desa']; ?></title>

        <!-- Favicon -->
        <link rel="shortcut icon" href="<?= base_url('img/logo/') . $site['logo']; ?>">
        <link rel="apple-touch-icon" href="<?= base_url('img/logo/') . $site['logo']; ?>">

        <!-- Core CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/css/app.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/css/app-dark.css">

        <!-- Others CSS -->
        <style>
            main {
                height: 100vh;
                width: 100%;
            }

            .bg-radial-gradient {
                background-color: hsl(218, 41%, 15%);
                background-image: radial-gradient(650px circle at 0% 0%,
                        hsl(218, 41%, 35%) 15%,
                        hsl(218, 41%, 30%) 35%,
                        hsl(218, 41%, 20%) 75%,
                        hsl(218, 41%, 19%) 80%,
                        transparent 100%),
                    radial-gradient(1250px circle at 100% 100%,
                        hsl(218, 41%, 45%) 15%,
                        hsl(218, 41%, 30%) 35%,
                        hsl(218, 41%, 20%) 75%,
                        hsl(218, 41%, 19%) 80%,
                        transparent 100%);
            }

            .bg-glass {
                background-color: hsla(0, 0%, 100%, 0.9) !important;
                backdrop-filter: saturate(200%) blur(25px);
            }

            html[data-bs-theme=dark] .bg-glass {
                background-color: rgba(0, 0, 0, 0.8) !important;
                backdrop-filter: saturate(200%) blur(25px);
            }

            #radius-shape-1 {
                height: 220px;
                width: 220px;
                top: -60px;
                left: -130px;
                background: radial-gradient(#44006b, #ad1fff);
                overflow: hidden;
            }

            #radius-shape-2 {
                border-radius: 38% 62% 63% 37% / 70% 33% 67% 30%;
                bottom: -60px;
                right: -110px;
                width: 300px;
                height: 300px;
                background: radial-gradient(#44006b, #ad1fff);
                overflow: hidden;
            }
        </style>
    </head>

    <body>
        <!-- Check theme -->
        <script src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/static/js/initTheme.js"></script>

        <!-- Main content -->
        <main class="bg-radial-gradient overflow-hidden">
            <div class="overflow-y-auto overflow-x-hidden h-100">
                <div class="container px-4 py-5 my-5">
                    <div class="row align-items-center">
                        <div class="col-lg-6 z-3 text-center">
                            <div class="d-flex justify-content-center mb-5">
                                <svg width="124" height="124">
                                    <image xlink:href="<?= base_url('img/logo/') . $site['logo']; ?>" width="124" height="124" />
                                </svg>
                            </div>

                            <h1 class="fw-bold mb-3" style="color: hsl(218, 81%, 95%)"><?= $site['nama_desa']; ?></h1>

                            <h4 class="opacity-70 mb-5" style="color: hsl(218, 81%, 85%)">
                                <?= 'Kecamatan ' . $site['kecamatan'] . ', ' . $site['kabupaten'] . ', Provinsi ' . $site['provinsi']; ?>
                            </h4>
                        </div>

                        <div class="col-lg-6 position-relative">
                            <div id="radius-shape-1" class="position-absolute rounded-circle shadow"></div>
                            <div id="radius-shape-2" class="position-absolute shadow"></div>

                            <?= $this->renderSection('content'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Core JS -->
        <script src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/static/js/components/dark.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/js/app.js"></script>
    </body>

    </html>
<?php endforeach; ?>