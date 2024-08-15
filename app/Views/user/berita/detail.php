<?= $this->extend('user/layout/template'); ?>

<?= $this->section('content'); ?>

<section class="page-section" id="pageSection">
    <div class="container px-4">
        <div class="ratio ratio-16x9 mb-4">
            <img class="object-fit-cover rounded-4" src="<?= base_url('img/berita/') . $berita['gambar']; ?>" alt="<?= $berita['judul']; ?>" loading="lazy" />
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h2 class="link-body-emphasis mb-4"><?= $berita['judul']; ?></h2>

                        <div class="d-flex flex-column gap-2 mb-4">
                            <div><?= date('d F Y H:i', strtotime($berita['created_at'])) . " WITA oleh " . $berita['penulis']; ?></div>
                            <small class="text-muted"><?= 'Dibaca ' . $berita['viewer'] . '⨉'; ?></small>
                        </div>

                        <article class="mb-4">
                            <?= $berita['deskripsi']; ?>
                        </article>

                        <a href="<?= base_url('kategori-berita/') . $berita['kategori_slug']; ?>" class="badge text-bg-secondary">
                            <i class="bi bi-tag me-2"></i>
                            <span class="mt-1"><?= $berita['kategori_berita']; ?></span>
                        </a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Komentar</h5>

                        <form action="<?= base_url('berita/komentar'); ?>" method="post" class="mb-4">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="berita_id" value="<?= $berita['id']; ?>">
                            <input type="hidden" name="slug" value="<?= $berita['slug']; ?>">

                            <div class="form-group mb-4">
                                <label for="nama">Nama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama" placeholder="Masukan Nama" name="nama" value="<?= old('nama'); ?>">
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
                                <?php if ($kmt['berita_id'] === $berita['id']) : ?>
                                    <div class="border-top py-4">
                                        <div class="d-flex align-items-center gap-3 mb-2">
                                            <span class="img-profile"><?= substr($kmt['nama'], 0, 1); ?></span>
                                            <span class="d-flex flex-column">
                                                <small><?= $kmt['nama']; ?></small>
                                                <small><?= date('d F Y H:i', strtotime($kmt['created_at'])) . ' WITA'; ?></small>
                                            </span>
                                        </div>
                                        <p class="ms-5"><?= $kmt['deskripsi']; ?></p>
                                        <div class="ms-5 d-flex align-items-center gap-2">
                                            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseForm<?= $kmt['id']; ?>" aria-expanded="false" aria-controls="collapseForm<?= $kmt['id']; ?>">
                                                Balas
                                            </button>
                                            <?php if (logged_in() && (user()->level == 'super admin' || user()->level == 'admin' || user()->level == 'kepala desa' || user()->level == 'staff')) : ?>
                                                <form action="<?= base_url('berita/delete-komentar/') . $kmt['id']; ?>" method="post" class="d-inline">
                                                    <?= csrf_field(); ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="slug" value="<?= $berita['slug']; ?>">
                                                    <button type="submit" class="btn btn-danger btn-delete icon"><i class="bi bi-trash"></i></button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="collapse mb-4" id="collapseForm<?= $kmt['id']; ?>">
                                        <form action="<?= base_url('berita/komentar-balasan'); ?>" method="post" class="ps-5">
                                            <?= csrf_field(); ?>

                                            <input type="hidden" name="komentar_id" value="<?= $kmt['id']; ?>">
                                            <input type="hidden" name="slug" value="<?= $berita['slug']; ?>">

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
                                            <?php if ($kmt_bls['komentar_berita_id'] === $kmt['id']) : ?>
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
                                                        <?php if (logged_in() && (user()->level == 'super admin' || user()->level == 'admin' || user()->level == 'kepala desa' || user()->level == 'staff')) : ?>
                                                            <div class="position-absolute top-0 end-0 mt-1 me-1">
                                                                <form action="<?= base_url('berita/delete-komentar-balasan/') . $kmt_bls['id']; ?>" method="post">
                                                                    <?= csrf_field(); ?>
                                                                    <input type="hidden" name="_method" value="DELETE">
                                                                    <input type="hidden" name="slug" value="<?= $berita['slug']; ?>">
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
                        <h4 class="fst-bold">Berita Terbaru</h4>
                        <ul class="list-unstyled">
                            <?php foreach ($berita_terbaru as $brt_baru) : ?>
                                <li>
                                    <a href="<?= base_url('berita/') . $brt_baru['slug']; ?>" class="row align-items-center py-3 link-body-emphasis text-decoration-none border-top">
                                        <div class="col-4">
                                            <div class="ratio ratio-1x1">
                                                <img class="object-fit-cover rounded-4" src="<?= base_url('img/berita/') . $brt_baru['gambar']; ?>" alt="<?= $brt_baru['judul']; ?>" loading="lazy" />
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <h6 class="mb-lg-1 mb-2 text-clamp-1"><?= $brt_baru['judul']; ?></h6>
                                            <p class="mb-lg-1 mb-2 text-clamp-2"><?= implode(" ", array_slice(explode(" ", strip_tags($brt_baru['deskripsi'])), 0, 20)); ?></p>
                                            <div class="d-flex gap-2 align-items-center text-secondary">
                                                <small class="icon"><i class="bi bi-clock"></i></small>
                                                <small class="mt-1 text-clamp-1"><?= $brt_baru['interval']; ?></small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                            <li><a href="<?= base_url('berita'); ?>" class="btn btn-outline-primary mt-2 mb-4 w-100">Lihat Semua</a></li>
                        </ul>
                    </div>
                    <div class="px-4">
                        <h4 class="fst-bold">Kategori Berita</h4>
                        <ul class="list-unstyled">
                            <?php foreach ($kategori as $ktg) : ?>
                                <li><a href="<?= base_url('kategori-berita/') . $ktg['slug']; ?>" class="badge text-bg-secondary mb-2"><i class="bi bi-tag me-2"></i><span class="mt-1"><?= $ktg['kategori']; ?></span></a></li>
                            <?php endforeach; ?>
                            <li><a href="<?= base_url('kategori-berita/tidak-ada-kategori'); ?>" class="badge text-bg-secondary mb-2"><i class="bi bi-tag me-2"></i><span class="mt-1">Tidak Ada Kategori</span></a></li>
                            <li><a href="<?= base_url('kategori-berita'); ?>" class="btn btn-outline-secondary mt-2 w-100">Lihat Semua</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->include('user/layout/toast-message'); ?>

<?= $this->endSection(); ?>