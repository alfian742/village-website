<?= $this->extend('user/layout/template'); ?>

<?= $this->section('content'); ?>

<section class="page-section" id="pageSection">
    <div class="container px-4">
        <h2 class="my-auto text-center mb-4"><?= $title; ?></h2>

        <div class="row justify-content-center g-4">
            <?php if (empty($kategori)) : ?>
                <?= $this->include('user/layout/no-data-page'); ?>
            <?php else : ?>
                <?php foreach ($kategori as $ktg) : ?>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <a class="card rounded-4 zoom" href="<?= base_url('kategori-berita/') . $ktg['slug']; ?>">
                            <div class="ratio ratio-16x9">
                                <img class="rounded-4 object-fit-cover" src="https://source.unsplash.com/random/300×300/?village" alt="" />
                            </div>
                            <div class="card-img-overlay bg-transparent rounded-4 p-0">
                                <div class="bg-img-overlay-1 d-flex justify-content-center align-items-center rounded-4 p-2 h-100">
                                    <h3 class="card-title text-center my-auto"><?= $ktg['kategori']; ?></h3>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <a class="card rounded-4 zoom" href="<?= base_url('kategori-berita/tidak-ada-kategori'); ?>">
                        <div class="ratio ratio-16x9">
                            <img class="rounded-4 object-fit-cover" src="https://source.unsplash.com/random/300×300/?village" alt="" />
                        </div>
                        <div class="card-img-overlay bg-transparent rounded-4 p-0">
                            <div class="bg-img-overlay-1 d-flex justify-content-center align-items-center rounded-4 p-2 h-100">
                                <h3 class="card-title text-center my-auto">Tidak Ada Kategori</h3>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>