<?= $this->extend('pages/errors/layout'); ?>

<?= $this->section('content'); ?>

<div class="col-md-8 col-12 offset-md-2">
    <div class="text-center">
        <img class="img-error w-100" src="<?= base_url('assets/img/error-403.svg'); ?>" alt="Not Found">
        <h1 class="error-title">Terlarang</h1>
        <p class='fs-5 text-gray-600'>Anda tidak sah untuk melihat halaman ini.</p>
        <a href="javascript:history.go(-1);" class="btn btn-lg btn-outline-primary mt-3">Kembali</a>
    </div>
</div>

<?= $this->endSection(); ?>