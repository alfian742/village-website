<?= $this->extend('user/layout/template'); ?>

<?= $this->section('content'); ?>

<section class="page-section" id="pageSection">
    <div class="container px-4">
        <h2 class="my-auto text-center mb-4"><?= $title; ?></h2>

        <div class="row">
            <div class="col">
                <div data-aos="fade-up" data-aos-duration="1000">
                    <div class="card rounded-4 m-0">
                        <div class="card-body p-0">
                            <div class="container p-4">
                                <div class="divider">
                                    <div class="divider-text fw-bold text-uppercase rounded">Visi</div>
                                </div>
                                <article class="text-center">
                                    <?= $visi_misi['visi']; ?>
                                </article>

                                <div class="my-5"></div>

                                <div class="divider">
                                    <div class="divider-text fw-bold text-uppercase rounded">Misi</div>
                                </div>
                                <article>
                                    <?= $visi_misi['misi']; ?>
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