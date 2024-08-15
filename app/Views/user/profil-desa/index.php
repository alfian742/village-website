<?= $this->extend('user/layout/template'); ?>

<?= $this->section('content'); ?>

<section class="page-section" id="pageSection">
    <div class="container px-4">
        <div class="d-flex flex-wrap justify-content-center gap-2">
            <h2 class="my-auto text-center mb-4"><?= $title; ?></h2>
            <?php foreach ($situs as $site) : ?>
                <h2 class="my-auto text-center mb-4"><?= $site['nama_desa']; ?></h2>
            <?php endforeach; ?>
        </div>

        <div class="row">
            <div class="col">
                <div data-aos="fade-up" data-aos-duration="1000">
                    <div class="card rounded-4 m-0">
                        <div class="card-body p-0">
                            <div class="container p-4">
                                <article>
                                    <?= $tentang_desa['tentang_desa']; ?>
                                </article>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>