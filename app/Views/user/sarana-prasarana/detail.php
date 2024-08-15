<?= $this->extend('user/layout/template'); ?>

<?= $this->section('content'); ?>

<section class="page-section" id="pageSection">
    <div class="container px-4">
        <div class="ratio ratio-16x9 mb-4">
            <img class="object-fit-cover rounded-4" src="<?= base_url('img/sarana-prasarana/') . $sarana_prasarana['gambar']; ?>" alt="<?= $sarana_prasarana['nama']; ?>" loading="lazy" />
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h2 class="link-body-emphasis mb-4"><?= $sarana_prasarana['nama']; ?></h2>

                        <div class="mb-4"><?= date('d F Y H:i', strtotime($sarana_prasarana['created_at'])) . " WITA"; ?></div>

                        <article>
                            <?= $sarana_prasarana['deskripsi']; ?>
                        </article>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="position-sticky" style="top: 7.5rem;">
                    <div class="px-4">
                        <h4 class="fst-bold">Sarana & Prasarana Lainnya</h4>
                        <ul class="list-unstyled">
                            <?php foreach ($sarana_prasarana_terbaru as $sp_baru) : ?>
                                <li>
                                    <a href="<?= base_url('sarana-prasarana/') . $sp_baru['slug']; ?>" class="row align-items-center py-3 link-body-emphasis text-decoration-none border-top">
                                        <div class="col-4">
                                            <div class="ratio ratio-1x1">
                                                <img class="object-fit-cover rounded-4" src="<?= base_url('img/sarana-prasarana/') . $sp_baru['gambar']; ?>" alt="<?= $sp_baru['nama']; ?>" loading="lazy" />
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <h6 class="mb-lg-1 mb-2 text-clamp-1"><?= $sp_baru['nama']; ?></h6>
                                            <p class="mb-lg-1 mb-2 text-clamp-2"><?= implode(" ", array_slice(explode(" ", strip_tags($sp_baru['deskripsi'])), 0, 20)); ?></p>
                                            <div class="d-flex gap-2 align-items-center text-secondary">
                                                <small class="icon"><i class="bi bi-clock"></i></small>
                                                <small class="mt-1 text-clamp-1"><?= $sp_baru['interval']; ?></small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                            <li><a href="<?= base_url('sarana-prasarana'); ?>" class="btn btn-outline-primary mt-2 mb-4 w-100">Lihat Semua</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>