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

                <form action="<?= base_url('dashboard/video/update/') . $video['id']; ?>" method="post">
                    <div class="row">
                        <div class="col-xl-8 col-lg-7 col-md-6">
                            <div class="ratio ratio-16x9 mb-4">
                                <iframe class="rounded-4" src="<?= $video['video_url']; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-5 col-md-6">
                            <?= csrf_field(); ?>

                            <div class="form-group">
                                <label for="video_url">URL Video <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= session('errors.video_url') ? 'is-invalid' : ''; ?>" id="video_url" placeholder="Masukan URL" name="video_url" value="<?= $video['video_url']; ?>">
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= session('errors.video_url') ?>
                                </div>
                                <p><small class="text-muted">Contoh: https://youtu.be/BbkFE_K_t0c</small></p>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>