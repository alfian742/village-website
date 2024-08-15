<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<section class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title my-auto">
                        <?= $title; ?>
                    </h5>
                    <div class="d-flex justify-content-end align-items-center gap-2">
                        <a href="<?= base_url(); ?>" target="_blank" class="btn btn-outline-success icon"><i class="bi bi-eye d-md-none"></i><span class="d-none d-md-inline">Lihat Pratinjau</span></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?= $this->include('admin/layout/alert-message'); ?>

                <div class="row">
                    <?php foreach ($sliders as $slider) : ?>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                            <div class="card">
                                <div class="card-content">
                                    <div class="ratio ratio-4x3">
                                        <img class="rounded-4 object-fit-cover" src="<?= base_url('img/slider/') . $slider['gambar']; ?>" alt="" />
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title text-center text-clamp-1 mb-3"><?= $slider['judul']; ?></h4>
                                        <a href="<?= base_url('dashboard/slider/edit/') . $slider['id']; ?>" class="btn btn-primary w-100">Edit</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>