<?= $this->extend('user/layout/template'); ?>

<?= $this->section('content'); ?>

<section class="page-section" id="pageSection">
    <div class="container px-4">
        <div class="ratio ratio-16x9 mb-4">
            <img class="object-fit-cover rounded-4" src="<?= base_url('img/umkm/') . $umkm['gambar']; ?>" alt="<?= $umkm['nama']; ?>" loading="lazy" />
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h2 class="link-body-emphasis mb-4"><?= $umkm['nama']; ?></h2>

                        <div class="d-flex gap-2 align-items-center card-subtitle mb-2">
                            <span class="icon"><i class="bi bi-shop"></i></span>
                            <span class="mt-1 text-clamp-1"><?= $umkm['pemilik']; ?></span>
                        </div>

                        <div class="d-flex gap-2 align-items-center card-subtitle mb-4">
                            <span class="icon"><i class="bi bi-tag"></i></span>
                            <span class="mt-1"><?= 'Rp ' . number_format($umkm['harga'], 0, ',', '.'); ?></span>
                        </div>

                        <article class="mb-4">
                            <?= $umkm['deskripsi']; ?>
                        </article>

                        <div class="d-flex justify-content-end align-items-center gap-2">
                            <div class="d-flex gap-2 align-items-center my-auto">
                                <?php if (!empty($umkm['instagram'])) : ?>
                                    <a href="<?= $umkm['instagram']; ?>" target="_blank" class="btn bg-instagram icon"><i class="bi bi-instagram me-2"></i><span>Lihat Produk Kami</span></a>
                                <?php endif; ?>
                                <a href="<?= 'https://wa.me/+62' . $umkm['nomor_hp']; ?>" target="_blank" class="btn bg-whatsapp icon"><i class="bi bi-whatsapp me-2"></i><span>Hubungi Kami</span></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Komentar</h5>

                        <form action="<?= base_url('umkm/komentar'); ?>" method="post" class="mb-4">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="umkm_id" value="<?= $umkm['id']; ?>">
                            <input type="hidden" name="slug" value="<?= $umkm['slug']; ?>">

                            <div class="form-group mb-4">
                                <label for="nama">Nama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama" placeholder="Masukan Nama" name="nama" value="<?= old('nama'); ?>">
                            </div>

                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-label fs-6 fw-semibold">Rating <span class="text-danger">*</span></div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rating" id="rating1" value="1" <?= old('rating') == '1' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="rating1">1</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rating" id="rating2" value="2" <?= old('rating') == '2' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="rating2">2</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rating" id="rating3" value="3" <?= old('rating') == '3' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="rating3">3</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rating" id="rating4" value="4" <?= old('rating') == '4' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="rating4">4</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rating" id="rating5" value="5" <?= old('rating') == '5' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="rating5">5</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="deskripsi" class="form-label">Komentar <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="deskripsi" placeholder="Masukan Komentar" name="deskripsi" rows="4"><?= old('deskripsi'); ?></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </form>

                        <?php if (empty($komentar)) : ?>
                            <div class="border-top py-4">
                                <h6 class="text-center my-auto">Tidak ada komentar.</h6>
                            </div>
                        <?php else : ?>
                            <?php foreach ($komentar as $kmt) : ?>
                                <?php if ($kmt['umkm_id'] === $umkm['id']) : ?>
                                    <div class="border-top py-4">
                                        <div class="d-flex align-items-center gap-3">
                                            <span class="img-profile"><?= substr($kmt['nama'], 0, 1); ?></span>
                                            <span class="d-flex flex-column">
                                                <small><?= $kmt['nama']; ?></small>
                                                <small><?= date('d F Y H:i', strtotime($kmt['created_at'])) . ' WITA'; ?></small>
                                            </span>
                                        </div>
                                        <div class="ms-5 mt-1 mb-3">
                                            <?php
                                            $rating = '';

                                            if ($kmt['rating'] == 5) {
                                                $rating = '<span class="d-flex gap-1 text-warning">
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star-fill"></i>
                                                        </span>';
                                            } elseif ($kmt['rating'] == 4) {
                                                $rating = '<span class="d-flex gap-1 text-warning">
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star"></i>
                                                        </span>';
                                            } elseif ($kmt['rating'] == 3) {
                                                $rating = '<span class="d-flex gap-1 text-warning">
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star"></i>
                                                            <i class="bi bi-star"></i>
                                                        </span>';
                                            } elseif ($kmt['rating'] == 2) {
                                                $rating = '<span class="d-flex gap-1 text-warning">
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star"></i>
                                                            <i class="bi bi-star"></i>
                                                            <i class="bi bi-star"></i>
                                                        </span>';
                                            } elseif ($kmt['rating'] == 1) {
                                                $rating = '<span class="d-flex gap-1 text-warning">
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star"></i>
                                                            <i class="bi bi-star"></i>
                                                            <i class="bi bi-star"></i>
                                                            <i class="bi bi-star"></i>
                                                        </span>';
                                            } elseif ($kmt['rating'] == 0) {
                                                $rating = '<span class="d-flex gap-1 text-warning">
                                                            <i class="bi bi-star"></i>
                                                            <i class="bi bi-star"></i>
                                                            <i class="bi bi-star"></i>
                                                            <i class="bi bi-star"></i>
                                                            <i class="bi bi-star"></i>
                                                        </span>';
                                            } else {
                                                $rating = '<span class="text-clamp-1">Tidak ada rating</span>';
                                            }

                                            echo $rating;
                                            ?>
                                        </div>
                                        <p class="ms-5"><?= $kmt['deskripsi']; ?></p>
                                        <div class="ms-5 d-flex align-items-center gap-2">
                                            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseForm<?= $kmt['id']; ?>" aria-expanded="false" aria-controls="collapseForm<?= $kmt['id']; ?>">
                                                Balas
                                            </button>
                                            <?php if (logged_in() && (user()->level == 'super admin' || user()->level == 'admin' || user()->level == 'kepala desa' || user()->level == 'staff' || user()->level == 'kepala dusun')) : ?>
                                                <form action="<?= base_url('umkm/delete-komentar/') . $kmt['id']; ?>" method="post" class="d-inline">
                                                    <?= csrf_field(); ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="slug" value="<?= $umkm['slug']; ?>">
                                                    <button type="submit" class="btn btn-danger btn-delete icon"><i class="bi bi-trash"></i></button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="collapse mb-4" id="collapseForm<?= $kmt['id']; ?>">
                                        <form action="<?= base_url('umkm/komentar-balasan'); ?>" method="post" class="ps-5">
                                            <?= csrf_field(); ?>

                                            <input type="hidden" name="komentar_id" value="<?= $kmt['id']; ?>">
                                            <input type="hidden" name="slug" value="<?= $umkm['slug']; ?>">

                                            <div class="form-group mb-4">
                                                <label for="nama_balasan">Nama <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="nama_balasan" placeholder="Masukan Nama" name="nama_balasan" value="<?= old('nama_balasan'); ?>">
                                            </div>

                                            <div class="form-group mb-4">
                                                <label for="deskripsi_balasan" class="form-label">Komentar <span class="text-danger">*</span></label>
                                                <textarea class="form-control" id="deskripsi_balasan" placeholder="Masukan Komentar" name="deskripsi_balasan" rows="4"><?= old('deskripsi_balasan'); ?></textarea>
                                            </div>

                                            <button type="submit" class="btn btn-primary">Kirim</button>
                                        </form>
                                    </div>

                                    <div class="ps-5">
                                        <?php foreach ($komentar_balasan as $kmt_bls) : ?>
                                            <?php if ($kmt_bls['komentar_umkm_id'] === $kmt['id']) : ?>
                                                <div class="card m-0">
                                                    <div class="card-body p-0">
                                                        <div class="d-flex align-items-center gap-3 mb-2">
                                                            <span class="img-profile"><?= substr($kmt_bls['nama'], 0, 1); ?></span>
                                                            <span class="d-flex flex-column">
                                                                <small><?= $kmt_bls['nama']; ?></small>
                                                                <small><?= date('d F Y H:i', strtotime($kmt_bls['created_at'])) . ' WITA'; ?></small>
                                                            </span>
                                                        </div>
                                                        <p class="ms-5"><?= $kmt_bls['deskripsi']; ?></p>
                                                        <?php if (logged_in() && (user()->level == 'super admin' || user()->level == 'admin' || user()->level == 'kepala desa' || user()->level == 'staff' || user()->level == 'kepala dusun')) : ?>
                                                            <div class="position-absolute top-0 end-0 mt-1 me-1">
                                                                <form action="<?= base_url('umkm/delete-komentar-balasan/') . $kmt_bls['id']; ?>" method="post">
                                                                    <?= csrf_field(); ?>
                                                                    <input type="hidden" name="_method" value="DELETE">
                                                                    <input type="hidden" name="slug" value="<?= $umkm['slug']; ?>">
                                                                    <button type="submit" class="btn btn-danger btn-delete icon"><i class="bi bi-trash"></i></button>
                                                                </form>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="position-sticky" style="top: 7.5rem;">
                    <div class="px-4">
                        <h4 class="fst-bold">UMKM Lainnya</h4>
                        <ul class="list-unstyled">
                            <?php foreach ($umkm_terbaru as $umkm_baru) : ?>
                                <li>
                                    <a href="<?= base_url('umkm/') . $umkm_baru['slug']; ?>" class="row align-items-center py-3 link-body-emphasis text-decoration-none border-top">
                                        <div class="col-4">
                                            <div class="ratio ratio-1x1">
                                                <img class="object-fit-cover rounded-4" src="<?= base_url('img/umkm/') . $umkm_baru['gambar']; ?>" alt="<?= $umkm_baru['nama']; ?>" loading="lazy" />
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <h6 class="mb-lg-1 mb-3 text-clamp-2"><?= $umkm_baru['nama']; ?></h6>
                                            <div class="row align-items-center">
                                                <div class="col-12">
                                                    <div class="d-flex gap-2 align-items-center">
                                                        <small class="icon"><i class="bi bi-shop"></i></small>
                                                        <small class="mt-1 text-clamp-1"><?= $umkm_baru['pemilik']; ?></small>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="d-flex gap-2 align-items-center">
                                                        <small class="icon"><i class="bi bi-tag"></i></small>
                                                        <small class="mt-1"><?= 'Rp ' . number_format($umkm_baru['harga'], 0, ',', '.'); ?></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                            <li><a href="<?= base_url('umkm'); ?>" class="btn btn-outline-primary mt-2 mb-4 w-100">Lihat Semua</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->include('user/layout/toast-message'); ?>

<?= $this->endSection(); ?>