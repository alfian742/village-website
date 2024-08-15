<?php foreach ($situs as $site) : ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $site['nama_desa'] . " | " . $title; ?></title>

        <!-- Favicon -->
        <link rel="shortcut icon" href="<?= base_url('img/logo/') . $site['logo']; ?>">
        <link rel="apple-touch-icon" href="<?= base_url('img/logo/') . $site['logo']; ?>">

        <!-- Core CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/css/app.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/css/app-dark.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/css/iconly.css">

        <!-- Others CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
        <link rel="stylesheet" href="<?= base_url('assets/css/dataTables.bootstrap5.min.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/dataTables-jquery.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    </head>

    <body>
        <!-- Check theme -->
        <script src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/static/js/initTheme.js"></script>

        <!-- Header -->
        <header class="fixed-top">
            <div class="container p-4">
                <div class="card rounded-4 border-0 m-0" id="navbar">
                    <div class="card-body p-0">
                        <nav class="navbar navbar-expand-lg p-2">
                            <div class="container px-2">
                                <a class="navbar-brand text-uppercase" href="<?= base_url(); ?>">
                                    <div class="d-flex justify-content-start align-items-center gap-2">
                                        <svg width="40" height="40">
                                            <image xlink:href="<?= base_url('img/logo/') . $site['logo']; ?>" width="40" height="40" />
                                        </svg>
                                        <div class="d-flex flex-column text-start">
                                            <span class="navbar-brand-title fw-bold"><?= $site['nama_desa']; ?></span>
                                            <span class="navbar-brand-subtitle fw-semibold"><?= $site['kabupaten']; ?></span>
                                        </div>
                                    </div>
                                </a>
                                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                                <div class="collapse navbar-collapse py-2" id="navbarNav">
                                    <ul class="navbar-nav ms-auto text-center">
                                        <li class="nav-item">
                                            <a class="nav-link <?= ($_SERVER['REQUEST_URI'] == '/') ? 'active' : ''; ?>" href="<?= base_url(); ?>">Beranda</a>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle <?= ($_SERVER['REQUEST_URI'] == '/profil/tentang' || $_SERVER['REQUEST_URI'] == '/profil/visi-misi' || $_SERVER['REQUEST_URI'] == '/sotk' || $_SERVER['REQUEST_URI'] == '/data-penduduk' || $_SERVER['REQUEST_URI'] == '/data-kewilayahan') ? 'active' : ''; ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Profil
                                            </a>
                                            <ul class="dropdown-menu px-2">
                                                <li><a class="dropdown-item <?= ($_SERVER['REQUEST_URI'] == '/profil/tentang') ? 'active' : ''; ?>" href="<?= base_url('profil/tentang'); ?>">Tentang</a></li>
                                                <li><a class="dropdown-item <?= ($_SERVER['REQUEST_URI'] == '/profil/visi-misi') ? 'active' : ''; ?>" href="<?= base_url('profil/visi-misi'); ?>">Visi & Misi</a></li>
                                                <li><a class="dropdown-item <?= ($_SERVER['REQUEST_URI'] == '/sotk') ? 'active' : ''; ?>" href="<?= base_url('sotk'); ?>">SOTK</a></li>
                                                <li><a class="dropdown-item <?= ($_SERVER['REQUEST_URI'] == '/data-penduduk') ? 'active' : ''; ?>" href="<?= base_url('data-penduduk'); ?>">Data Penduduk</a></li>
                                                <li><a class="dropdown-item <?= ($_SERVER['REQUEST_URI'] == '/data-kewilayahan') ? 'active' : ''; ?>" href="<?= base_url('data-kewilayahan'); ?>">Data Kewilayahan</a></li>
                                            </ul>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle <?= ($_SERVER['REQUEST_URI'] == '/berita' || $_SERVER['REQUEST_URI'] == '/pengumuman' || $_SERVER['REQUEST_URI'] == '/layanan' || $_SERVER['REQUEST_URI'] == '/sarana-prasarana' || $_SERVER['REQUEST_URI'] == '/dokumen') ? 'active' : ''; ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Informasi
                                            </a>
                                            <ul class="dropdown-menu px-2">
                                                <li><a class="dropdown-item <?= ($_SERVER['REQUEST_URI'] == '/berita') ? 'active' : ''; ?>" href="<?= base_url('berita'); ?>">Berita</a></li>
                                                <li><a class="dropdown-item <?= ($_SERVER['REQUEST_URI'] == '/pengumuman') ? 'active' : ''; ?>" href="<?= base_url('pengumuman'); ?>">Pengumuman</a></li>
                                                <li><a class="dropdown-item <?= ($_SERVER['REQUEST_URI'] == '/layanan') ? 'active' : ''; ?>" href="<?= base_url('layanan'); ?>">Layanan</a></li>
                                                <li><a class="dropdown-item <?= ($_SERVER['REQUEST_URI'] == '/sarana-prasarana') ? 'active' : ''; ?>" href="<?= base_url('sarana-prasarana'); ?>">Sarana & Prasarana</a></li>
                                                <li><a class="dropdown-item <?= ($_SERVER['REQUEST_URI'] == '/dokumen') ? 'active' : ''; ?>" href="<?= base_url('dokumen'); ?>">Dokumen Publik</a></li>
                                            </ul>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?= ($_SERVER['REQUEST_URI'] == '/pariwisata') ? 'active' : ''; ?>" href="<?= base_url('pariwisata'); ?>">Pariwisata</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?= ($_SERVER['REQUEST_URI'] == '/umkm') ? 'active' : ''; ?>" href="<?= base_url('umkm'); ?>">UMKM</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?= ($_SERVER['REQUEST_URI'] == '/kontak') ? 'active' : ''; ?>" href=" <?= base_url('kontak'); ?>">Kontak</a>
                                        </li>
                                        <?php if (!logged_in()) : ?>
                                            <li class="nav-item">
                                                <a class="nav-link <?= ($_SERVER['REQUEST_URI'] == '/login') ? 'active' : ''; ?>" href=" <?= url_to('login'); ?>">Masuk</a>
                                            </li>
                                        <?php elseif (logged_in()) : ?>
                                            <li class="nav-item">
                                                <a class="nav-link <?= ($_SERVER['REQUEST_URI'] == '/dashboard') ? 'active' : ''; ?>" href=" <?= base_url('dashboard'); ?>">Dashboard</a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>

                                    <div class="vr ms-2 me-3 d-none d-lg-inline"></div>

                                    <ul class="navbar-nav">
                                        <li class="nav-item">
                                            <!-- Theme toggle -->
                                            <div class="theme-toggle d-flex justify-content-center align-items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                                                    <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2" opacity=".3"></path>
                                                        <g transform="translate(-210 -1)">
                                                            <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                                            <circle cx="220.5" cy="11.5" r="4"></circle>
                                                            <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path>
                                                        </g>
                                                    </g>
                                                </svg>
                                                <div class="form-check form-switch fs-6 mt-1 ms-1">
                                                    <input class="form-check-input  me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
                                                    <label class="form-check-label"></label>
                                                </div>
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--mdi" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                                    <path fill="currentColor" d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main content -->
        <main>
            <?= $this->renderSection('content'); ?>
        </main>

        <!-- Footer -->
        <footer class="footer">
            <div class="card rounded-0 m-0">
                <div class="card-body px-0 pb-0 pt-1 border-top">
                    <div class="container p-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <img src="<?= base_url('img/logo/') . $site['logo']; ?>" alt="Logo" class="d-inline-block mb-4" height="64">

                                <h4 class="text-white mb-2"><?= $site['nama_desa']; ?></h4>

                                <div class="d-flex flex-column gap-1 mb-4">
                                    <span><?= 'Kecamatan ' . $site['kecamatan'] . ', ' . $site['kabupaten'] . ', '; ?></span>
                                    <span><?= 'Provinsi ' . $site['provinsi'] . ', Kode Pos ' . $site['kode_pos']; ?></span>
                                </div>

                                <div class="d-flex flex-column gap-2 mb-4">
                                    <a class="link-footer d-flex gap-3 align-items-center" href="mailto:<?= $kontak['email']; ?>">
                                        <span class="icon"><i class="bi bi-envelope"></i></span>
                                        <span><?= $kontak['email']; ?></span>
                                    </a>
                                    <a class="link-footer d-flex gap-3 align-items-center" href="<?= 'https://wa.me/+62' . $kontak['nomor_hp']; ?>">
                                        <span class="icon"><i class="bi bi-whatsapp"></i></span>
                                        <span><?= '+62' . $kontak['nomor_hp']; ?></span>
                                    </a>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="row mb-4">
                                    <div class="col">
                                        <h5 class="text-white mb-2">Menu</h5>

                                        <div class="d-flex flex-column gap-2">
                                            <a href="<?= base_url(); ?>" class="link-footer">Beranda</a>
                                            <div class="dropdown">
                                                <a class="link-footer dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Profil
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="<?= base_url('profil/tentang'); ?>">Tentang</a></li>
                                                    <li><a class="dropdown-item" href="<?= base_url('profil/visi-misi'); ?>">Visi & Misi</a></li>
                                                    <li><a class="dropdown-item" href="<?= base_url('sotk'); ?>">SOTK</a></li>
                                                    <li><a class="dropdown-item" href="<?= base_url('data-penduduk'); ?>">Data Penduduk</a></li>
                                                    <li><a class="dropdown-item" href="<?= base_url('data-kewilayahan'); ?>">Data Kewilayahan</a></li>
                                                </ul>
                                            </div>
                                            <div class="dropdown">
                                                <a class="link-footer dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Informasi
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="<?= base_url('berita'); ?>">Berita</a></li>
                                                    <li><a class="dropdown-item" href="<?= base_url('pengumuman'); ?>">Pengumuman</a></li>
                                                    <li><a class="dropdown-item" href="<?= base_url('layanan'); ?>">Layanan</a></li>
                                                    <li><a class="dropdown-item" href="<?= base_url('sarana-prasarana'); ?>">Sarana & Prasarana</a></li>
                                                    <li><a class="dropdown-item" href="<?= base_url('dokumen'); ?>">Dokumen Publik</a></li>
                                                </ul>
                                            </div>
                                            <a href="<?= base_url('pariwisata'); ?>" class="link-footer">Pariwisata</a>
                                            <a href="<?= base_url('umkm'); ?>" class="link-footer">UMKM</a>
                                            <a href="<?= base_url('kontak'); ?>" class="link-footer">Kontak</a>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <h5 class="text-white mb-2">Ikuti kami</h5>

                                        <div class="d-flex flex-wrap gap-2">
                                            <?php if (!empty($kontak['instagram'])) : ?>
                                                <a href="<?= $kontak['instagram']; ?>" target="_blank" class="btn btn-sm btn-footer icon"><i class="bi bi-instagram"></i></a>
                                            <?php endif; ?>
                                            <?php if (!empty($kontak['facebook'])) : ?>
                                                <a href="<?= $kontak['facebook']; ?>" target="_blank" class="btn btn-sm btn-footer icon"><i class="bi bi-facebook"></i></a>
                                            <?php endif; ?>
                                            <?php if (!empty($kontak['twitter'])) : ?>
                                                <a href="<?= $kontak['twitter']; ?>" target="_blank" class="btn btn-sm btn-footer icon"><i class="bi bi-twitter-x"></i></a>
                                            <?php endif; ?>
                                            <?php if (!empty($kontak['tiktok'])) : ?>
                                                <a href="<?= $kontak['tiktok']; ?>" target="_blank" class="btn btn-sm btn-footer icon"><i class="bi bi-tiktok"></i></a>
                                            <?php endif; ?>
                                            <?php if (!empty($kontak['youtube'])) : ?>
                                                <a href="<?= $kontak['youtube']; ?>" target="_blank" class="btn btn-sm btn-footer icon"><i class="bi bi-youtube"></i></a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="row justify-content-center align-items-center g-2 border-top pt-3 mt-2">
                                    <div class="col-lg-6">
                                        <div class="text-lg-start text-center fw-bold">
                                            &copy; <?= date('Y') . " " . $site['nama_desa']; ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="text-lg-end text-center fw-bold">
                                            Dibuat oleh <a href="https://www.instagram.com/alfian_742" target="_blank" class="link-footer">Alfian Hidayat</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Scroll to top -->
        <div class="position-fixed bottom-0 end-0 mb-4 me-4 z-1">
            <button class="btn btn-primary icon" id="scrollToTopBtn"><i class="bi bi-chevron-up"></i></button>
        </div>

        <!-- Core JS -->
        <script src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/static/js/components/dark.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/js/app.js"></script>

        <!-- Others JS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script src="<?= base_url('assets/js/jquery.min.js'); ?>"></script>
        <script src="<?= base_url('assets/js/jquery.dataTables.min.js'); ?>"></script>
        <script src="<?= base_url('assets/js/dataTables.bootstrap5.min.js'); ?>"></script>
        <script src="<?= base_url('assets/js/script.js'); ?>"></script>
    </body>

    </html>
<?php endforeach; ?>