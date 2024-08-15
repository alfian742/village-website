<?php if (session()->getFlashdata('success-message')) : ?>
    <div class="alert alert-light-success alert-dismissible fade show mb-4" role="alert">
        <?= '<i class="bi bi-check-circle me-2"></i>' . session()->getFlashdata('success-message'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error-message')) : ?>
    <div class="alert alert-light-danger alert-dismissible fade show mb-4" role="alert">
        <?= '<i class="bi bi-exclamation-circle me-2"></i>' . session()->getFlashdata('error-message'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('warning-message')) : ?>
    <div class="alert alert-light-warning alert-dismissible fade show mb-4" role="alert">
        <?= '<i class="bi bi-exclamation-triangle me-2"></i>' . session()->getFlashdata('warning-message'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>