<?= $this->extend('pages/errors/layout'); ?>

<?= $this->section('content'); ?>

<div class="col-md-8 col-12 offset-md-2">
    <div class="text-center">
        <img class="img-error w-100" src="<?= base_url('assets/img/error-404.svg'); ?>" alt="Not Found">
        <h1 class="error-title">Tidak ditemukan</h1>
        <p class='fs-5 text-gray-600'>Halaman yang Anda cari tidak ditemukan.</p>
        <a href="javascript:history.go(-1);" class="btn btn-lg btn-outline-primary mt-3">Kembali</a>
    </div>
</div>

<?= $this->endSection(); ?>