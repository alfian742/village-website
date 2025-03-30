<?= $this->extend('Myth\Auth\Views\auth\layout'); ?>

<?= $this->section('content'); ?>

<div class="card bg-glass rounded-4 mb-0">
    <div class="card-body p-5">
        <div class="d-flex justify-content-between align-items-center gap-2 mb-4">
            <h2 class="my-auto "><?= lang('Auth.forgotPassword') ?></h2>

            <!-- Theme toggle -->
            <?= view('Myth\Auth\Views\auth\_theme_toggle'); ?>
        </div>

        <?= view('Myth\Auth\Views\auth\_alert_message'); ?>

        <p><?= lang('Auth.enterEmailForInstructions') ?></p>

        <form action="<?= url_to('forgot') ?>" method="post">
            <?= csrf_field(); ?>

            <div class="form-group mb-4">
                <input type="email" class="form-control form-control-lg <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" name="email" aria-describedby="emailHelp" placeholder="<?= lang('Auth.email') ?>">
                <div class="invalid-feedback">
                    <?= session('errors.email') ?>
                </div>
            </div>

            <div class="d-flex flex-column gap-4">
                <button type="submit" class="btn btn-primary"><?= lang('Auth.sendInstructions') ?></button>
            </div>
        </form>

        <?= view('Myth\Auth\Views\auth\_copyright'); ?>
    </div>
</div>

<?= $this->endSection(); ?>