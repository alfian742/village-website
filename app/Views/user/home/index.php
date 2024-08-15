<?= $this->extend('user/layout/template'); ?>

<?= $this->section('content'); ?>

<!-- Hero -->
<section class="hero">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner rounded-0">
            <?php foreach ($slider as $key => $slide) : ?>
                <div class="carousel-item <?= $key === 0 ? ' active' : ''; ?>" data-bs-interval="10000">
                    <div class="carousel-img-overlay"></div>
                    <img src="<?= base_url('img/slider/') . $slide['gambar']; ?>" class="carousel-img object-fit-cover d-block w-100" alt="<?= $slide['judul']; ?>">
                    <div class="carousel-caption text-center d-flex align-items-center justify-content-center">
                        <div class="container">
                            <h2 class="mb-3" data-aos="fade-down" data-aos-duration="1000"><?= $slide['judul']; ?></h2>
                            <p class="fs-5 mb-3" data-aos="fade-down" data-aos-duration="1000"><?= $slide['deskripsi']; ?></p>
                            <?php if (!empty($slide['relevan_url'])) : ?>
                                <div data-aos="fade-up" data-aos-duration="1000">
                                    <a href="<?= $slide['relevan_url']; ?>" class="btn btn-lg btn-primary">Lihat Selengkapnya</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon d-none" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon d-none" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>

<!-- Link -->
<section class="page-section">
    <div class="card rounded-0 m-0">
        <div class="card-body p-0">
            <div class="link-wrapper">
                <div class="link-wrapper-main">
                    <?php
                    $loop_count = 2;

                    for ($i = 0; $i < $loop_count; $i++) {
                    ?>
                        <div class="link-wrapper-item">
                            <a href="<?= base_url('berita'); ?>" class="link-main">
                                <div class="link-main-item">
                                    <div class="d-flex flex-column gap-2">
                                        <span class="fs-2 icon">
                                            <i class="bi bi-newspaper"></i>
                                        </span>
                                        <h5>Berita</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="link-wrapper-item">
                            <a href="<?= base_url('pengumuman'); ?>" class="link-main">
                                <div class="link-main-item">
                                    <div class="d-flex flex-column gap-2">
                                        <span class="fs-2 icon">
                                            <i class="bi bi-megaphone"></i>
                                        </span>
                                        <h5>Pengumuman</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="link-wrapper-item">
                            <a href="<?= base_url('layanan'); ?>" class="link-main">
                                <div class="link-main-item">
                                    <div class="d-flex flex-column gap-2">
                                        <span class="fs-2 icon">
                                            <i class="bi bi-award"></i>
                                        </span>
                                        <h5>Layanan</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="link-wrapper-item">
                            <a href="<?= base_url('sarana-prasarana'); ?>" class="link-main">
                                <div class="link-main-item">
                                    <div class="d-flex flex-column gap-2">
                                        <span class="fs-2 icon">
                                            <i class="bi bi-bank"></i>
                                        </span>
                                        <h5>Sarana dan Prasarana</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="link-wrapper-item">
                            <a href="<?= base_url('dokumen'); ?>" class="link-main">
                                <div class="link-main-item">
                                    <div class="d-flex flex-column gap-2">
                                        <span class="fs-2 icon">
                                            <i class="bi bi-file-earmark"></i>
                                        </span>
                                        <h5>Dokumen Publik</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="link-wrapper-item">
                            <a href="<?= base_url('data-penduduk'); ?>" class="link-main">
                                <div class="link-main-item">
                                    <div class="d-flex flex-column gap-2">
                                        <span class="fs-2 icon">
                                            <i class="bi bi-people"></i>
                                        </span>
                                        <h5>Data Penduduk</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="link-wrapper-item">
                            <a href="<?= base_url('data-kewilayahan'); ?>" class="link-main">
                                <div class="link-main-item">
                                    <div class="d-flex flex-column gap-2">
                                        <span class="fs-2 icon">
                                            <i class="bi bi-globe-asia-australia"></i>
                                        </span>
                                        <h5>Data Kewilayahan</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Perangkat Desa & Video -->
<section class="page-section">
    <div class="container px-4">
        <div class="row justify-content-center align-items-center g-4">
            <div class="col-lg-5">
                <div data-aos="fade-up" data-aos-duration="1000">
                    <div id="carouselStaffs" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php if (empty($perangkat_desa) && empty($dusun)) : ?>
                                <div class="carousel-item active" data-bs-interval="5000">
                                    <div class="container px-5">
                                        <div class="card rounded-4 m-0">
                                            <div class="ratio ratio-1x1">
                                                <img class="rounded-4 object-fit-cover" src="<?= base_url('img/staff/default.svg'); ?>" alt="...">
                                            </div>
                                            <div class="card-img-overlay bg-transparent rounded-4 d-flex flex-column justify-content-end p-2">
                                                <div class="bg-img-overlay-2 p-2 rounded-4">
                                                    <h5 class="card-title text-center text-clamp-1">Tidak ada Data</h5>
                                                    <hr class="my-2">
                                                    <p style="font-size: 14px;" class="card-text text-center">Tidak ada Data</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php else : ?>
                                <?php foreach ($perangkat_desa as $key => $pd) : ?>
                                    <div class="carousel-item <?= $key === 0 ? ' active' : ''; ?>" data-bs-interval="5000">
                                        <div class="container px-5">
                                            <div class="card rounded-4 m-0">
                                                <div class="ratio ratio-1x1">
                                                    <img class="rounded-4 object-fit-cover" src="<?= base_url('img/staff/') . $pd['foto']; ?>" alt="<?= $pd['nama']; ?>">
                                                </div>
                                                <div class="card-img-overlay bg-transparent rounded-4 d-flex flex-column justify-content-end p-2">
                                                    <div class="bg-img-overlay-2 p-2 rounded-4">
                                                        <h5 class="card-title text-center text-clamp-1"><?= $pd['nama']; ?></h5>
                                                        <hr class="my-2">
                                                        <p style="font-size: 14px;" class="card-text text-center"><?= $pd['jabatan']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <?php foreach ($dusun as $key => $ds) : ?>
                                    <div class="carousel-item <?= ($key === 0 && empty($perangkat_desa)) ? 'active' : ''; ?>" data-bs-interval="5000">
                                        <div class="container px-5">
                                            <div class="card rounded-4 m-0">
                                                <?php foreach ($kepala_dusun as $kd) : ?>
                                                    <?php if ($kd['id'] === $ds['kepala_dusun_id']) : ?>
                                                        <div class="ratio ratio-1x1">
                                                            <img class="rounded-4 object-fit-cover" src="<?= base_url('img/staff/') . $kd['foto']; ?>" alt="<?= $kd['nama']; ?>" />
                                                        </div>
                                                        <div class="card-img-overlay bg-transparent rounded-4 d-flex flex-column justify-content-end p-2">
                                                            <div class="bg-img-overlay-2 p-2 rounded-4">
                                                                <h5 class="card-title text-center text-clamp-1"><?= $kd['nama']; ?></h5>
                                                                <hr class="my-2">
                                                                <p style="font-size: 14px;" class="card-text text-center mb-0">Pelaksana Kewilayahan</p>
                                                                <p style="font-size: 14px;" class="card-text text-center"><?= $ds['nama_dusun']; ?></p>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselStaffs" data-bs-slide="prev">
                            <span class="carousel-icon-custom text-bg-dark me-auto" aria-hidden="true"><i class="bi bi-chevron-left"></i></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselStaffs" data-bs-slide="next">
                            <span class="carousel-icon-custom text-bg-dark ms-auto" aria-hidden="true"><i class="bi bi-chevron-right"></i></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div data-aos="fade-up" data-aos-duration="1000">
                    <div class="ratio ratio-16x9">
                        <iframe class="rounded-4" src="<?= $video['video_url']; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pariwisata -->
<section class="page-section">
    <div class="card rounded-0 m-0">
        <div class="card-body p-0">
            <div class="container p-4">
                <h2 class="text-center mb-4">Destinasi Pariwisata</h2>

                <div class="row justify-content-center">
                    <?php foreach ($pariwisata as $ps) : ?>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div data-aos="flip-left" data-aos-duration="1000">
                                <div class="card rounded-4 border">
                                    <div class="card-content">
                                        <div class="ratio ratio-4x3">
                                            <img class="object-fit-cover rounded-top-4" src="<?= base_url('img/pariwisata/') . $ps['gambar']; ?>" alt="<?= $ps['judul']; ?>" loading="lazy" />
                                        </div>
                                        <div class="card-body">
                                            <h4 class="card-title text-clamp-2"><?= $ps['judul']; ?></h4>

                                            <div class="d-flex gap-2 align-items-center card-subtitle mb-3">
                                                <span class="icon"><i class="bi bi-person-circle"></i></span>
                                                <span class="mt-1"><?= $ps['penulis']; ?></span>
                                            </div>

                                            <p class="card-text text-clamp-3"> <?= implode(" ", array_slice(explode(" ", strip_tags($ps['deskripsi'])), 0, 20)); ?></p>

                                            <hr>

                                            <div class="row justify-content-between align-items-center g-3">
                                                <div class="col-lg-8">
                                                    <div class="d-flex gap-2 align-items-center text-muted my-auto">
                                                        <small class="icon"><i class="bi bi-clock"></i></small>
                                                        <small class="mt-1"><?= $ps['interval']; ?></small>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <a href="<?= base_url('pariwisata/') . $ps['slug']; ?>" class="btn btn-primary w-100 stretched-link">Lihat</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="d-flex justify-content-center align-items-center">
                    <a href="<?= base_url('pariwisata'); ?>" class="btn btn-primary">Lihat Semua</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- UMKM -->
<section class="page-section">
    <div class="container px-4">
        <h2 class="text-center mb-4">Produk UMKM Terbaru</h2>

        <div class="row justify-content-center">
            <?php foreach ($umkm as $umkms) : ?>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div data-aos="flip-right" data-aos-duration="1000">
                        <div class="card rounded-4">
                            <div class="card-content">
                                <div class="ratio ratio-4x3">
                                    <img class="object-fit-cover rounded-top-4" src="<?= base_url('img/umkm/') . $umkms['gambar']; ?>" alt="<?= $umkms['nama']; ?>" loading="lazy" />
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title text-clamp-2"><?= $umkms['nama']; ?></h4>

                                    <div class="row align-items-center g-2">
                                        <div class="col-lg-6">
                                            <div class="d-flex gap-2 align-items-center card-subtitle">
                                                <span class="icon"><i class="bi bi-shop"></i></span>
                                                <span class="mt-1 text-clamp-1"><?= $umkms['pemilik']; ?></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="d-flex gap-2 justify-content-lg-end justify-content-start align-items-center card-subtitle">
                                                <span class="icon"><i class="bi bi-tag"></i></span>
                                                <span class="mt-1"><?= 'Rp ' . number_format($umkms['harga'], 0, ',', '.'); ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row align-items-center g-3">
                                        <div class="col-lg-5 z-3">
                                            <div class="d-flex gap-3 gap-lg-2 align-items-center my-auto">
                                                <?php if (!empty($umkms['instagram'])) : ?>
                                                    <a href="<?= $umkms['instagram']; ?>" target="_blank" class="btn bg-instagram icon w-100"><i class="bi bi-instagram"></i></a>
                                                <?php endif; ?>
                                                <a href="<?= 'https://wa.me/+62' . $umkms['nomor_hp']; ?>" target="_blank" class="btn bg-whatsapp icon w-100"><i class="bi bi-whatsapp"></i><?= (!empty($umkms['instagram'])) ? '' : '<span class="ms-2 d-inline d-lg-none">Whatsapp</span>'; ?></a>
                                            </div>
                                        </div>
                                        <div class="col-lg-7 z-1">
                                            <a href="<?= base_url('umkm/') . $umkms['slug']; ?>" class="btn btn-primary w-100 stretched-link">Lihat Produk</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="d-flex justify-content-center align-items-center">
            <a href="<?= base_url('umkm'); ?>" class="btn btn-primary">Lihat Semua Produk</a>
        </div>
    </div>
</section>

<!-- Lokasi -->
<section class="page-section">
    <div class="card rounded-0 m-0">
        <div class="card-body p-0">
            <div class="container p-4">
                <div class="row justify-content-center g-4">
                    <div class="col-lg-7">
                        <div data-aos="fade-up" data-aos-duration="1000">
                            <div class="ratio ratio-16x9">
                                <iframe src="https://maps.google.com/maps?q=<?= urlencode($geografis['lokasi']); ?>&hl=id&m=h&output=embed" class="rounded-4" style="border:0;" allowfullscreen="" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div data-aos="fade-up" data-aos-duration="1000">
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th colspan="4">Batas Wilayah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="align-middle">
                                            <td>Timur</td>
                                            <td>:</td>
                                            <td><?= $geografis['timur']; ?></td>
                                        </tr>
                                        <tr class="align-middle">
                                            <td>Barat</td>
                                            <td>:</td>
                                            <td><?= $geografis['barat']; ?></td>
                                        </tr>
                                        <tr class="align-middle">
                                            <td>Selatan</td>
                                            <td>:</td>
                                            <td><?= $geografis['selatan']; ?></td>
                                        </tr>
                                        <tr class="align-middle">
                                            <td>Utara</td>
                                            <td>:</td>
                                            <td><?= $geografis['utara']; ?></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="align-middle">
                                            <th>Luas</th>
                                            <th>:</th>
                                            <th>
                                                <?php
                                                if (empty($geografis['luas'])) {
                                                    echo '-';
                                                } else {
                                                    echo $geografis['luas'];
                                                }
                                                ?>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>