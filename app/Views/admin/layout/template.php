<?php if (logged_in() && user()->level == 'super admin' || user()->level == 'admin' || user()->level == 'kepala desa' || user()->level == 'staff' || user()->level == 'kepala dusun') : ?>
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
            <link rel="stylesheet" href="<?= base_url('assets/css/dataTables.bootstrap5.min.css'); ?>">
            <link rel="stylesheet" href="<?= base_url('assets/css/dataTables-jquery.css'); ?>">
            <link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css'); ?>">
        </head>

        <body>
            <!-- Check theme -->
            <script src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/static/js/initTheme.js"></script>

            <div id="app">
                <!-- Sidebar -->
                <aside id="sidebar">
                    <div class="sidebar-wrapper active">
                        <div class="sidebar-header position-relative">
                            <div class="logo sidebar-logo text-uppercase text-center fs-5 mb-2">
                                <a href="<?= base_url('dashboard'); ?>">
                                    <svg width="40" height="40" class="d-block mx-auto mb-2">
                                        <image xlink:href="<?= base_url('img/logo/') . $site['logo']; ?>" width="40" height="40" />
                                    </svg>
                                    <span><?= $site['nama_desa']; ?></span>
                                </a>
                            </div>

                            <div class="sidebar-toggler x">
                                <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                            </div>
                        </div>

                        <div class="divider">
                            <div class="divider-text fw-bold text-uppercase rounded">Menu</div>
                        </div>

                        <div class="sidebar-menu">
                            <ul class="menu">
                                <li class="sidebar-item <?= ($_SERVER['REQUEST_URI'] == '/') ? 'active' : ''; ?>">
                                    <a href="<?= base_url(); ?>" class='sidebar-link'>
                                        <i class="bi bi-house"></i>
                                        <span>Beranda Website</span>
                                    </a>
                                </li>

                                <li class="sidebar-item <?= ($_SERVER['REQUEST_URI'] == '/dashboard') ? 'active' : ''; ?>">
                                    <a href="<?= base_url('dashboard'); ?>" class='sidebar-link'>
                                        <i class="bi bi-grid"></i>
                                        <span>Dashboard</span>
                                    </a>
                                </li>

                                <?php if (user()->level == 'kepala dusun') : ?>
                                    <li class="sidebar-item has-sub <?= ($_SERVER['REQUEST_URI'] == '/dashboard/kewilayahan/dusun' || $_SERVER['REQUEST_URI'] == '/dashboard/kewilayahan/data-dusun') ? 'active' : ''; ?>">
                                        <a href="#" class='sidebar-link'>
                                            <i class="bi bi-view-list"></i>
                                            <span>Kewilayahan</span>
                                        </a>

                                        <ul class="submenu ">
                                            <li class="submenu-item <?= ($_SERVER['REQUEST_URI'] == '/dashboard/kewilayahan/dusun') ? 'active' : ''; ?>">
                                                <a href="<?= base_url('dashboard/kewilayahan/dusun'); ?>" class="submenu-link">Profil Wilayah</a>
                                            </li>
                                            <li class="submenu-item <?= ($_SERVER['REQUEST_URI'] == '/dashboard/kewilayahan/data-dusun') ? 'active' : ''; ?>">
                                                <a href="<?= base_url('dashboard/kewilayahan/data-dusun'); ?>" class="submenu-link">Data Wilayah</a>
                                            </li>
                                        </ul>
                                    </li>
                                <?php endif; ?>

                                <?php if (user()->level == 'super admin' || user()->level == 'admin' || user()->level == 'kepala desa') : ?>
                                    <li class="sidebar-item <?= ($_SERVER['REQUEST_URI'] == '/dashboard/slider') ? 'active' : ''; ?>">
                                        <a href="<?= base_url('dashboard/slider'); ?>" class='sidebar-link'>
                                            <i class="bi bi-images"></i>
                                            <span>Slider</span>
                                        </a>
                                    </li>

                                    <li class="sidebar-item <?= ($_SERVER['REQUEST_URI'] == '/dashboard/video') ? 'active' : ''; ?>">
                                        <a href="<?= base_url('dashboard/video'); ?>" class='sidebar-link'>
                                            <i class="bi bi-play-btn"></i>
                                            <span>Video</span>
                                        </a>
                                    </li>

                                    <li class="sidebar-item has-sub <?= ($_SERVER['REQUEST_URI'] == '/dashboard/tentang-desa' || $_SERVER['REQUEST_URI'] == '/dashboard/geografis' || $_SERVER['REQUEST_URI'] == '/dashboard/struktur-organisasi' || $_SERVER['REQUEST_URI'] == '/dashboard/perangkat-desa' || $_SERVER['REQUEST_URI'] == '/dashboard/dusun' || $_SERVER['REQUEST_URI'] == '/dashboard/kepala-dusun' || $_SERVER['REQUEST_URI'] == '/dashboard/data-dusun') ? 'active' : ''; ?>">
                                        <a href="#" class='sidebar-link'>
                                            <i class="bi bi-view-list"></i>
                                            <span data-bs-toggle="tooltip" data-bs-title="Profil Desa/Kelurahan">Profil Desa/Kel...</span>
                                        </a>

                                        <ul class="submenu ">
                                            <li class="submenu-item <?= ($_SERVER['REQUEST_URI'] == '/dashboard/tentang-desa') ? 'active' : ''; ?>">
                                                <a href="<?= base_url('dashboard/tentang-desa'); ?>" class="submenu-link">Tentang</a>
                                            </li>
                                            <li class="submenu-item <?= ($_SERVER['REQUEST_URI'] == '/dashboard/geografis') ? 'active' : ''; ?>">
                                                <a href="<?= base_url('dashboard/geografis'); ?>" class="submenu-link">Geografis</a>
                                            </li>
                                            <li class="submenu-item <?= ($_SERVER['REQUEST_URI'] == '/dashboard/struktur-organisasi') ? 'active' : ''; ?>">
                                                <a href="<?= base_url('dashboard/struktur-organisasi'); ?>" class="submenu-link">Struktur Organisasi</a>
                                            </li>
                                            <li class="submenu-item <?= ($_SERVER['REQUEST_URI'] == '/dashboard/perangkat-desa') ? 'active' : ''; ?>">
                                                <a href="<?= base_url('dashboard/perangkat-desa'); ?>" class="submenu-link">Aparatur</a>
                                            </li>
                                            <li class="submenu-item has-sub <?= ($_SERVER['REQUEST_URI'] == '/dashboard/dusun' || $_SERVER['REQUEST_URI'] == '/dashboard/kepala-dusun' || $_SERVER['REQUEST_URI'] == '/dashboard/data-dusun') ? 'active' : ''; ?>">
                                                <a href="#" class="submenu-link">Kewilayahan</a>
                                                <ul class="submenu submenu-level-2 ">
                                                    <li class="submenu-item <?= ($_SERVER['REQUEST_URI'] == '/dashboard/kepala-dusun') ? 'active' : ''; ?>">
                                                        <a href="<?= base_url('dashboard/kepala-dusun'); ?>" class="submenu-link">Pelaksana</a>
                                                    </li>
                                                    <li class="submenu-item <?= ($_SERVER['REQUEST_URI'] == '/dashboard/dusun') ? 'active' : ''; ?>">
                                                        <a href="<?= base_url('dashboard/dusun'); ?>" class="submenu-link">Wilayah</a>
                                                    </li>
                                                    <li class="submenu-item <?= ($_SERVER['REQUEST_URI'] == '/dashboard/data-dusun') ? 'active' : ''; ?>">
                                                        <a href="<?= base_url('dashboard/data-dusun'); ?>" class="submenu-link">Data Wilayah</a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item has-sub <?= ($_SERVER['REQUEST_URI'] == '/dashboard/agama' || $_SERVER['REQUEST_URI'] == '/dashboard/jenis-kelamin' || $_SERVER['REQUEST_URI'] == '/dashboard/pekerjaan' || $_SERVER['REQUEST_URI'] == '/dashboard/usia') ? 'active' : ''; ?>">
                                        <a href="#" class='sidebar-link'>
                                            <i class="bi bi-people"></i>
                                            <span>Data Penduduk</span>
                                        </a>

                                        <ul class="submenu ">
                                            <li class="submenu-item <?= ($_SERVER['REQUEST_URI'] == '/dashboard/agama') ? 'active' : ''; ?>">
                                                <a href="<?= base_url('dashboard/agama'); ?>" class="submenu-link">Agama</a>
                                            </li>
                                            <li class="submenu-item <?= ($_SERVER['REQUEST_URI'] == '/dashboard/jenis-kelamin') ? 'active' : ''; ?>">
                                                <a href="<?= base_url('dashboard/jenis-kelamin'); ?>" class="submenu-link">Jenis Kelamin</a>
                                            </li>
                                            <li class="submenu-item <?= ($_SERVER['REQUEST_URI'] == '/dashboard/pekerjaan') ? 'active' : ''; ?>">
                                                <a href="<?= base_url('dashboard/pekerjaan'); ?>" class="submenu-link">Pekerjaan</a>
                                            </li>
                                            <li class="submenu-item <?= ($_SERVER['REQUEST_URI'] == '/dashboard/usia') ? 'active' : ''; ?>">
                                                <a href="<?= base_url('dashboard/usia'); ?>" class="submenu-link">Usia</a>
                                            </li>
                                        </ul>
                                    </li>
                                <?php endif; ?>

                                <?php if (user()->level == 'super admin' || user()->level == 'admin' || user()->level == 'kepala desa' || user()->level == 'staff') : ?>
                                    <li class="sidebar-item has-sub <?= ($_SERVER['REQUEST_URI'] == '/dashboard/pengumuman' || $_SERVER['REQUEST_URI'] == '/dashboard/layanan' || $_SERVER['REQUEST_URI'] == '/dashboard/sarana-prasarana' || $_SERVER['REQUEST_URI'] == '/dashboard/dokumen') ? 'active' : ''; ?>">
                                        <a href="#" class='sidebar-link'>
                                            <i class="bi bi-info-circle"></i>
                                            <span>Informasi</span>
                                        </a>

                                        <ul class="submenu ">
                                            <li class="submenu-item <?= ($_SERVER['REQUEST_URI'] == '/dashboard/pengumuman') ? 'active' : ''; ?>">
                                                <a href="<?= base_url('dashboard/pengumuman'); ?>" class="submenu-link">Pengumuman</a>
                                            </li>
                                            <li class="submenu-item <?= ($_SERVER['REQUEST_URI'] == '/dashboard/layanan') ? 'active' : ''; ?>">
                                                <a href="<?= base_url('dashboard/layanan'); ?>" class="submenu-link">Layanan</a>
                                            </li>
                                            <li class="submenu-item <?= ($_SERVER['REQUEST_URI'] == '/dashboard/sarana-prasarana') ? 'active' : ''; ?>">
                                                <a href="<?= base_url('dashboard/sarana-prasarana'); ?>" class="submenu-link">Sarana & Prasarana</a>
                                            </li>
                                            <li class="submenu-item <?= ($_SERVER['REQUEST_URI'] == '/dashboard/dokumen') ? 'active' : ''; ?>">
                                                <a href="<?= base_url('dashboard/dokumen'); ?>" class="submenu-link">Dokumen Publik</a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item has-sub <?= ($_SERVER['REQUEST_URI'] == '/dashboard/berita' || $_SERVER['REQUEST_URI'] == '/dashboard/komentar-berita' || $_SERVER['REQUEST_URI'] == '/dashboard/kategori') ? 'active' : ''; ?>">
                                        <a href="#" class='sidebar-link'>
                                            <i class="bi bi-newspaper"></i>
                                            <span>Berita</span>
                                        </a>

                                        <ul class="submenu ">
                                            <li class="submenu-item <?= ($_SERVER['REQUEST_URI'] == '/dashboard/berita') ? 'active' : ''; ?>">
                                                <a href="<?= base_url('dashboard/berita'); ?>" class="submenu-link">Daftar Berita</a>
                                            </li>
                                            <li class="submenu-item <?= ($_SERVER['REQUEST_URI'] == '/dashboard/komentar-berita') ? 'active' : ''; ?>">
                                                <a href="<?= base_url('dashboard/komentar-berita'); ?>" class="submenu-link">Komentar</a>
                                            </li>
                                            <li class="submenu-item <?= ($_SERVER['REQUEST_URI'] == '/dashboard/kategori-berita') ? 'active' : ''; ?>">
                                                <a href="<?= base_url('dashboard/kategori-berita'); ?>" class="submenu-link">Kategori</a>
                                            </li>
                                        </ul>
                                    </li>
                                <?php endif; ?>

                                <li class="sidebar-item has-sub <?= ($_SERVER['REQUEST_URI'] == '/dashboard/pariwisata' || $_SERVER['REQUEST_URI'] == '/dashboard/komentar-pariwisata') ? 'active' : ''; ?>">
                                    <a href="#" class='sidebar-link'>
                                        <i class="bi bi-suitcase-lg"></i>
                                        <span>Pariwisata</span>
                                    </a>

                                    <ul class="submenu ">
                                        <li class="submenu-item <?= ($_SERVER['REQUEST_URI'] == '/dashboard/pariwisata') ? 'active' : ''; ?>">
                                            <a href="<?= base_url('dashboard/pariwisata'); ?>" class="submenu-link">Daftar Pariwisata</a>
                                        </li>
                                        <li class="submenu-item <?= ($_SERVER['REQUEST_URI'] == '/dashboard/komentar-pariwisata') ? 'active' : ''; ?>">
                                            <a href="<?= base_url('dashboard/komentar-pariwisata'); ?>" class="submenu-link">Komentar</a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="sidebar-item has-sub <?= ($_SERVER['REQUEST_URI'] == '/dashboard/umkm' || $_SERVER['REQUEST_URI'] == '/dashboard/komentar-umkm') ? 'active' : ''; ?>">
                                    <a href="#" class='sidebar-link'>
                                        <i class="bi bi-shop"></i>
                                        <span>UMKM</span>
                                    </a>

                                    <ul class="submenu ">
                                        <li class="submenu-item <?= ($_SERVER['REQUEST_URI'] == '/dashboard/umkm') ? 'active' : ''; ?>">
                                            <a href="<?= base_url('dashboard/umkm'); ?>" class="submenu-link">Daftar UMKM</a>
                                        </li>
                                        <li class="submenu-item <?= ($_SERVER['REQUEST_URI'] == '/dashboard/komentar-umkm') ? 'active' : ''; ?>">
                                            <a href="<?= base_url('dashboard/komentar-umkm'); ?>" class="submenu-link">Komentar</a>
                                        </li>
                                    </ul>
                                </li>

                                <?php if (user()->level == 'super admin' || user()->level == 'admin' || user()->level == 'kepala desa') : ?>
                                    <li class="sidebar-item <?= ($_SERVER['REQUEST_URI'] == '/dashboard/manage-user') ? 'active' : ''; ?>">
                                        <a href="<?= base_url('dashboard/manage-user'); ?>" class='sidebar-link'>
                                            <i class="bi bi-person-circle"></i>
                                            <span>Kelola Pengguna</span>
                                        </a>
                                    </li>

                                    <li class="sidebar-item <?= ($_SERVER['REQUEST_URI'] == '/dashboard/kontak') ? 'active' : ''; ?>">
                                        <a href="<?= base_url('dashboard/kontak'); ?>" class='sidebar-link'>
                                            <i class="bi bi-postcard"></i>
                                            <span>Kontak</span>
                                        </a>
                                    </li>

                                    <li class="sidebar-item <?= ($_SERVER['REQUEST_URI'] == '/dashboard/identitas-situs') ? 'active' : ''; ?>">
                                        <a href="<?= base_url('dashboard/identitas-situs'); ?>" class='sidebar-link'>
                                            <i class="bi bi-globe-americas"></i>
                                            <span>Identitas Situs</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </aside>

                <!-- Main content -->
                <main id="main">
                    <!-- Header -->
                    <header>
                        <div class="card">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <!-- Sidebar toggle -->
                                    <a href="#" class="burger-btn d-inline d-xl-none mb-1">
                                        <i class="bi bi-justify fs-3"></i>
                                    </a>

                                    <div class="vr mx-3 d-inline d-xl-none"></div>

                                    <!-- Theme toggle -->
                                    <div class="theme-toggle d-flex align-items-center gap-2">
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

                                    <!-- Profile toggle -->
                                    <div class="ms-auto">
                                        <div class="dropdown me-2">
                                            <button class="btn border-0 dropdown-header" type="button" id="dropdownProfileButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="d-none d-md-inline fw-bold me-1"><?= user()->fullname; ?></span> <img src="<?= base_url('img/staff/') . user()->user_img; ?>" alt="" class="avatar object-fit-cover me-0" width="32" height="32">
                                            </button>
                                            <div class="dropdown-menu mt-4" aria-labelledby="dropdownProfileButton">
                                                <a class="dropdown-item" href="<?= base_url('dashboard/profil'); ?>">
                                                    <i class="bi bi-person me-2"></i> Profil
                                                </a>
                                                <a class="dropdown-item" href="#" id="btn-logout" data-logout-fullname="<?= user()->fullname; ?>">
                                                    <i class="bi bi-power me-2"></i> Keluar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>

                    <!-- Content -->
                    <div class="page-content">
                        <?= $this->renderSection('content'); ?>
                    </div>

                    <!-- Footer -->
                    <footer class="mt-auto">
                        <div class="footer clearfix mb-0 text-muted">
                            <div class="row justify-content-center align-items-center g-2">
                                <div class="col-lg-6">
                                    <div class="text-lg-start text-center fw-bold">
                                        &copy; <?= date('Y') . " " . $site['nama_desa']; ?>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="text-lg-end text-center fw-bold pe-lg-5">
                                        Dibuat oleh <a href="https://www.instagram.com/alfian_742" target="_blank" class="link-footer">Alfian Hidayat</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </footer>

                    <!-- Scroll to top -->
                    <div class="position-fixed bottom-0 end-0 mb-4 me-4">
                        <div class="container px-2">
                            <button class="btn btn-primary icon" id="scrollToTopBtn"><i class="bi bi-chevron-up"></i></button>
                        </div>
                    </div>
                </main>
            </div>

            <!-- Core JS -->
            <script src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/static/js/components/dark.js"></script>
            <script src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
            <script src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/js/app.js"></script>

            <!-- Others JS -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>
            <script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
            <script src="<?= base_url('assets/js/jquery.min.js'); ?>"></script>
            <script src="<?= base_url('assets/js/jquery.dataTables.min.js'); ?>"></script>
            <script src="<?= base_url('assets/js/dataTables.bootstrap5.min.js'); ?>"></script>
            <script src="<?= base_url('assets/js/dashboard.js'); ?>"></script>
            <script>
                // login message
                <?php if (session('login-message')) : ?>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: "Sukses!",
                            html: `<?= session('login-message'); ?><br><strong><?= user()->fullname; ?></strong>`,
                            icon: "success",
                            showConfirmButton: true,
                            timer: 5000
                        });
                    });
                <?php endif; ?>

                // Logout button
                $('#btn-logout').on('click', function() {
                    var userFullname = $(this).data('logout-fullname');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        html: "<strong>" + userFullname + "</strong><br>Anda akan keluar dari sesi ini!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, keluar!',
                        cancelButtonText: 'Tidak'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '<?= url_to('logout'); ?>';
                        }
                    });
                });
            </script>
        </body>

        </html>
    <?php endforeach; ?>
<?php endif; ?>