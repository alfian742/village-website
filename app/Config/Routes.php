<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// User
// Home
$routes->get('/', 'Home::index');

// Berita
$routes->group('berita', function ($routes) {
    $routes->get('/', 'Berita::index');
    $routes->get('(:segment)', 'Berita::detail/$1');
    $routes->post('komentar', 'Berita::komentar');
    $routes->post('komentar-balasan', 'Berita::komentarBalasan');
    $routes->delete('delete-komentar/(:num)', 'Berita::deleteKomentar/$1');
    $routes->delete('delete-komentar-balasan/(:num)', 'Berita::deleteKomentarBalasan/$1');
});

// Data Penduduk
$routes->get('data-penduduk', 'DataPenduduk::index');

// Dokumen Publik
$routes->group('dokumen', function ($routes) {
    $routes->get('/', 'DokumenPublik::index');
    $routes->get('download/(:segment)', 'DokumenPublik::download/$1');
});

// Dusun
$routes->group('data-kewilayahan', function ($routes) {
    $routes->get('/', 'Dusun::index');
    $routes->get('(:segment)', 'Dusun::detail/$1');
});

// Kategori Berita
$routes->group('kategori-berita', function ($routes) {
    $routes->get('/', 'Kategori::index');
    $routes->get('tidak-ada-kategori', 'Kategori::noCategory');
    $routes->get('(:segment)', 'Kategori::detail/$1');
});

// Kontak
$routes->get('kontak', 'Kontak::index');

// Layanan
$routes->group('layanan', function ($routes) {
    $routes->get('/', 'Layanan::index');
    $routes->get('(:segment)', 'Layanan::detail/$1');
});

// Pariwisata
$routes->group('pariwisata', function ($routes) {
    $routes->get('/', 'Pariwisata::index');
    $routes->get('(:segment)', 'Pariwisata::detail/$1');
    $routes->post('komentar', 'Pariwisata::komentar');
    $routes->post('komentar-balasan', 'Pariwisata::komentarBalasan');
    $routes->delete('delete-komentar/(:num)', 'Pariwisata::deleteKomentar/$1');
    $routes->delete('delete-komentar-balasan/(:num)', 'Pariwisata::deleteKomentarBalasan/$1');
});

// Pengumuman
$routes->group('pengumuman', function ($routes) {
    $routes->get('/', 'Pengumuman::index');
    $routes->get('(:segment)', 'Pengumuman::detail/$1');
});

// Sarana Prasarana
$routes->group('sarana-prasarana', function ($routes) {
    $routes->get('/', 'SaranaPrasarana::index');
    $routes->get('(:segment)', 'SaranaPrasarana::detail/$1');
});

// SOTK
$routes->get('sotk', 'SOTK::index');

// Tentang, Visi & Misi 
$routes->group('profil', function ($routes) {
    $routes->get('tentang', 'TentangDesa::index');
    $routes->get('visi-misi', 'TentangDesa::visiMisi');
});

// UMKM
$routes->group('umkm', function ($routes) {
    $routes->get('/', 'UMKM::index');
    $routes->get('(:segment)', 'UMKM::detail/$1');
    $routes->post('komentar', 'UMKM::komentar');
    $routes->post('komentar-balasan', 'UMKM::komentarBalasan');
    $routes->delete('delete-komentar/(:num)', 'UMKM::deleteKomentar/$1');
    $routes->delete('delete-komentar-balasan/(:num)', 'UMKM::deleteKomentarBalasan/$1');
});

// Admin and Staff
$routes->group('dashboard', function ($routes) {
    // Dashboard
    $routes->get('/', 'Admin\Dashboard::index');

    // Agama
    $routes->group('agama', function ($routes) {
        $routes->get('/', 'Admin\Agama::index');
        $routes->post('update', 'Admin\Agama::update');
    });

    // Berita
    $routes->group('berita', function ($routes) {
        $routes->get('/', 'Admin\Berita::index');
        $routes->get('create', 'Admin\Berita::create');
        $routes->post('save', 'Admin\Berita::save');
        $routes->get('edit/(:segment)', 'Admin\Berita::edit/$1');
        $routes->post('update/(:segment)', 'Admin\Berita::update/$1');
        $routes->delete('delete/(:num)', 'Admin\Berita::delete/$1');
    });

    // Data Dusun
    $routes->group('data-dusun', function ($routes) {
        $routes->get('/', 'Admin\DataDusun::index');
        $routes->get('create', 'Admin\DataDusun::create');
        $routes->post('save', 'Admin\DataDusun::save');
        $routes->get('edit/(:segment)', 'Admin\DataDusun::edit/$1');
        $routes->post('update/(:segment)', 'Admin\DataDusun::update/$1');
        $routes->delete('delete/(:num)', 'Admin\DataDusun::delete/$1');
    });

    // Dusun
    $routes->group('dusun', function ($routes) {
        $routes->get('/', 'Admin\Dusun::index');
        $routes->get('create', 'Admin\Dusun::create');
        $routes->post('save', 'Admin\Dusun::save');
        $routes->get('edit/(:segment)', 'Admin\Dusun::edit/$1');
        $routes->post('update/(:segment)', 'Admin\Dusun::update/$1');
        $routes->delete('delete/(:num)', 'Admin\Dusun::delete/$1');
    });

    // Dokumen
    $routes->group('dokumen', function ($routes) {
        $routes->get('/', 'Admin\DokumenPublik::index');
        $routes->post('save', 'Admin\DokumenPublik::save');
        $routes->delete('delete/(:num)', 'Admin\DokumenPublik::delete/$1');
        $routes->get('download/(:segment)', 'Admin\DokumenPublik::download/$1');
    });

    // Geografis
    $routes->group('geografis', function ($routes) {
        $routes->get('/', 'Admin\Geografis::index');
        $routes->post('update/(:num)', 'Admin\Geografis::update/$1');
    });

    // Identitas Situs
    $routes->group('identitas-situs', function ($routes) {
        $routes->get('/', 'Admin\Situs::index');
        $routes->post('update/(:num)', 'Admin\Situs::update/$1');
    });

    // Jenis Kelamin
    $routes->group('jenis-kelamin', function ($routes) {
        $routes->get('/', 'Admin\JenisKelamin::index');
        $routes->post('update', 'Admin\JenisKelamin::update');
    });

    // Kategori
    $routes->group('kategori-berita', function ($routes) {
        $routes->get('/', 'Admin\Kategori::index');
        $routes->post('save', 'Admin\Kategori::save');
        $routes->post('update/(:num)', 'Admin\Kategori::update/$1');
        $routes->delete('delete/(:num)', 'Admin\Kategori::delete/$1');
    });

    // Kepala Dusun
    $routes->group('kepala-dusun', function ($routes) {
        $routes->get('/', 'Admin\KepalaDusun::index');
        $routes->get('create', 'Admin\KepalaDusun::create');
        $routes->post('save', 'Admin\KepalaDusun::save');
        $routes->get('edit/(:segment)', 'Admin\KepalaDusun::edit/$1');
        $routes->post('update/(:segment)', 'Admin\KepalaDusun::update/$1');
        $routes->delete('delete/(:segment)', 'Admin\KepalaDusun::delete/$1');
    });

    // Komentar Berita
    $routes->group('komentar-berita', function ($routes) {
        $routes->get('/', 'Admin\KomentarBerita::index');
        $routes->delete('delete/(:num)', 'Admin\KomentarBerita::delete/$1');
    });

    // Komentar Pariwisata
    $routes->group('komentar-pariwisata', function ($routes) {
        $routes->get('/', 'Admin\KomentarPariwisata::index');
        $routes->delete('delete/(:num)', 'Admin\KomentarPariwisata::delete/$1');
    });

    // Komentar UMKM
    $routes->group('komentar-umkm', function ($routes) {
        $routes->get('/', 'Admin\KomentarUMKM::index');
        $routes->delete('delete/(:num)', 'Admin\KomentarUMKM::delete/$1');
    });

    // Kontak
    $routes->group('kontak', function ($routes) {
        $routes->get('/', 'Admin\Kontak::index');
        $routes->post('update/(:num)', 'Admin\Kontak::update/$1');
    });

    // Kewilayahan
    $routes->group('kewilayahan', function ($routes) {
        // Data Dusun
        $routes->group('data-dusun', function ($routes) {
            $routes->get('/', 'Admin\Kewilayahan::index');
            $routes->get('create', 'Admin\Kewilayahan::createDataDusun');
            $routes->post('save', 'Admin\Kewilayahan::saveDataDusun');
            $routes->get('edit/(:segment)', 'Admin\Kewilayahan::editDataDusun/$1');
            $routes->post('update/(:segment)', 'Admin\Kewilayahan::updateDataDusun/$1');
            $routes->delete('delete/(:num)', 'Admin\Kewilayahan::deleteDataDusun/$1');
        });

        // Dusun
        $routes->group('dusun', function ($routes) {
            $routes->get('/', 'Admin\Kewilayahan::viewDusun');
            $routes->post('update', 'Admin\Kewilayahan::updateDusun');
        });
    });

    // Layanan
    $routes->group('layanan', function ($routes) {
        $routes->get('/', 'Admin\Layanan::index');
        $routes->get('create', 'Admin\Layanan::create');
        $routes->post('save', 'Admin\Layanan::save');
        $routes->get('edit/(:segment)', 'Admin\Layanan::edit/$1');
        $routes->post('update/(:segment)', 'Admin\Layanan::update/$1');
        $routes->delete('delete/(:num)', 'Admin\Layanan::delete/$1');
    });

    // Manage Users
    $routes->group('manage-user', function ($routes) {
        $routes->get('/', 'Admin\ManageUser::index');
        $routes->get('edit-data/(:segment)', 'Admin\ManageUser::editData/$1');
        $routes->post('update-data/(:segment)', 'Admin\ManageUser::updateData/$1');
        $routes->get('edit-password/(:segment)', 'Admin\ManageUser::editPassword/$1');
        $routes->post('update-password/(:segment)', 'Admin\ManageUser::updatePassword/$1');
        $routes->get('reset-password/(:segment)', 'Admin\ManageUser::resetPassword/$1');
    });

    // Pariwisata
    $routes->group('pariwisata', function ($routes) {
        $routes->get('/', 'Admin\Pariwisata::index');
        $routes->get('create', 'Admin\Pariwisata::create');
        $routes->post('save', 'Admin\Pariwisata::save');
        $routes->get('edit/(:segment)', 'Admin\Pariwisata::edit/$1');
        $routes->post('update/(:segment)', 'Admin\Pariwisata::update/$1');
        $routes->delete('delete/(:num)', 'Admin\Pariwisata::delete/$1');
    });

    // Pekerjaan
    $routes->group('pekerjaan', function ($routes) {
        $routes->get('/', 'Admin\Pekerjaan::index');
        $routes->get('create', 'Admin\Pekerjaan::create');
        $routes->post('save', 'Admin\Pekerjaan::save');
        $routes->get('edit/(:num)', 'Admin\Pekerjaan::edit/$1');
        $routes->post('update/(:num)', 'Admin\Pekerjaan::update/$1');
        $routes->delete('delete/(:num)', 'Admin\Pekerjaan::delete/$1');
    });

    // Pengumuman
    $routes->group('pengumuman', function ($routes) {
        $routes->get('/', 'Admin\Pengumuman::index');
        $routes->get('create', 'Admin\Pengumuman::create');
        $routes->post('save', 'Admin\Pengumuman::save');
        $routes->get('edit/(:segment)', 'Admin\Pengumuman::edit/$1');
        $routes->post('update/(:segment)', 'Admin\Pengumuman::update/$1');
        $routes->delete('delete/(:num)', 'Admin\Pengumuman::delete/$1');
    });

    // Perangkat Desa
    $routes->group('perangkat-desa', function ($routes) {
        $routes->get('/', 'Admin\PerangkatDesa::index');
        $routes->get('create', 'Admin\PerangkatDesa::create');
        $routes->post('save', 'Admin\PerangkatDesa::save');
        $routes->get('edit/(:segment)', 'Admin\PerangkatDesa::edit/$1');
        $routes->post('update/(:segment)', 'Admin\PerangkatDesa::update/$1');
        $routes->delete('delete/(:segment)', 'Admin\PerangkatDesa::delete/$1');
    });

    // Profil
    $routes->group('profil', function ($routes) {
        $routes->get('/', 'Admin\Profil::index');
        $routes->post('update-data', 'Admin\Profil::updateData');
        $routes->post('update-password', 'Admin\Profil::updatePassword');
    });

    // Sarana Prasarana
    $routes->group('sarana-prasarana', function ($routes) {
        $routes->get('/', 'Admin\SaranaPrasarana::index');
        $routes->get('create', 'Admin\SaranaPrasarana::create');
        $routes->post('save', 'Admin\SaranaPrasarana::save');
        $routes->get('edit/(:segment)', 'Admin\SaranaPrasarana::edit/$1');
        $routes->post('update/(:segment)', 'Admin\SaranaPrasarana::update/$1');
        $routes->delete('delete/(:num)', 'Admin\SaranaPrasarana::delete/$1');
    });

    // Slider
    $routes->group('slider', function ($routes) {
        $routes->get('/', 'Admin\Slider::index');
        $routes->get('edit/(:num)', 'Admin\Slider::edit/$1');
        $routes->post('update/(:num)', 'Admin\Slider::update/$1');
    });

    // Struktur Organisasi
    $routes->group('struktur-organisasi', function ($routes) {
        $routes->get('/', 'Admin\StrukturOrganisasi::index');
        $routes->post('update/(:num)', 'Admin\StrukturOrganisasi::update/$1');
    });

    // Tentang Desa
    $routes->group('tentang-desa', function ($routes) {
        $routes->get('/', 'Admin\TentangDesa::index');
        $routes->get('edit/(:num)', 'Admin\TentangDesa::edit/$1');
        $routes->post('update/(:num)', 'Admin\TentangDesa::update/$1');
    });

    // UMKM
    $routes->group('umkm', function ($routes) {
        $routes->get('/', 'Admin\UMKM::index');
        $routes->get('create', 'Admin\UMKM::create');
        $routes->post('save', 'Admin\UMKM::save');
        $routes->get('edit/(:segment)', 'Admin\UMKM::edit/$1');
        $routes->post('update/(:segment)', 'Admin\UMKM::update/$1');
        $routes->delete('delete/(:num)', 'Admin\UMKM::delete/$1');
    });

    // Usia
    $routes->group('usia', function ($routes) {
        $routes->get('/', 'Admin\Usia::index');
        $routes->post('update', 'Admin\Usia::update');
    });

    // Video
    $routes->group('video', function ($routes) {
        $routes->get('/', 'Admin\Video::index');
        $routes->post('update/(:num)', 'Admin\Video::update/$1');
    });
});

// Erorrs
$routes->set404Override(function () {
    $data = [
        'title' => '404 | Tidak Ditemukan'
    ];

    return view('pages/errors/error-404', $data);
});
$routes->get('403-forbidden', 'Pages::forbiddenPage');
$routes->get('404-not-found', 'Pages::notFoundPage');
$routes->get('500-internal-error', 'Pages::internalErrorPage');
