<?php if (session()->has('message')) : ?>
    <div class="alert alert-light-success alert-dismissible fade show mb-4" role="alert">
        <?= '<i class="bi bi-check-circle me-2"></i>' . session('message'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->has('error')) : ?>
    <div class="alert alert-light-danger alert-dismissible fade show mb-4" role="alert">
        <?= '<i class="bi bi-exclamation-circle me-2"></i>' . session('error'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>