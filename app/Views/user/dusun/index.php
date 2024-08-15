<?= $this->extend('user/layout/template'); ?>

<?= $this->section('content'); ?>

<section class="page-section" id="pageSection">
    <div class="container px-4">
        <h2 class="my-auto text-center mb-4"><?= $title; ?></h2>

        <div class="row justify-content-center g-4">
            <?php if (empty($dusun)) : ?>
                <?= $this->include('user/layout/no-data-page'); ?>
            <?php else : ?>
                <?php foreach ($dusun as $ds) : ?>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div data-aos="fade-up" data-aos-duration="1000">
                            <a class="card rounded-4 zoom" href="<?= base_url('data-kewilayahan/') . $ds['slug']; ?>">
                                <div class="ratio ratio-16x9">
                                    <img class="rounded-4 object-fit-cover" src="<?= base_url('img/dusun/') . $ds['gambar']; ?>" alt="" />
                                </div>
                                <div class="card-img-overlay bg-transparent rounded-4 p-0">
                                    <div class="bg-img-overlay-1 d-flex justify-content-center align-items-center rounded-4 p-2 h-100">
                                        <h3 class="card-title text-center my-auto"><?= $ds['nama_dusun']; ?></h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>