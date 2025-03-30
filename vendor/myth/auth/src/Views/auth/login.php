<?= $this->extend('Myth\Auth\Views\auth\layout'); ?>

<?= $this->section('content'); ?>

<div class="card bg-glass rounded-4 mb-0">
    <div class="card-body p-5">
        <div class="d-flex justify-content-between align-items-center gap-2 mb-4">
            <h2 class="my-auto "><?= lang('Auth.loginTitle') ?></h2>

            <!-- Theme toggle -->
            <?= view('Myth\Auth\Views\auth\_theme_toggle'); ?>
        </div>

        <?= view('Myth\Auth\Views\auth\_alert_message'); ?>

        <form action="<?= url_to('login') ?>" method="post">
            <?= csrf_field(); ?>

            <?php if ($config->validFields === ['email']) : ?>
                <div class="form-group mb-4">
                    <input type="email" class="form-control form-control-lg <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" name="login" placeholder="<?= lang('Auth.email') ?>">
                    <div class="invalid-feedback">
                        <?= session('errors.login') ?>
                    </div>
                </div>
            <?php else : ?>
                <div class="form-group mb-4">
                    <input type="text" class="form-control form-control-lg <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" name="login" placeholder="<?= lang('Auth.emailOrUsername') ?>">
                    <div class="invalid-feedback">
                        <?= session('errors.login') ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="form-group mb-4">
                <input type="password" name="password" class="form-control form-control-lg  <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>">
                <div class="invalid-feedback">
                    <?= session('errors.password') ?>
                </div>
            </div>

            <div class="d-flex justify-content-between gap-2 mb-4">
                <?php if ($config->allowRemembering) : ?>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" name="remember" class="form-check-input" <?php if (old('remember')) : ?> checked <?php endif ?>>
                            <?= lang('Auth.rememberMe') ?>
                        </label>
                    </div>
                <?php endif; ?>
                <?php if ($config->activeResetter) : ?>
                    <div class="d-none d-lg-inline">
                        <a href="<?= url_to('forgot') ?>"><?= lang('Auth.forgotYourPassword') ?></a>
                    </div>
                <?php endif; ?>
            </div>

            <div class="d-flex flex-column gap-4">
                <button type="submit" class="btn btn-primary"><?= lang('Auth.loginAction') ?></button>

                <?php if ($config->activeResetter) : ?>
                    <div class="d-lg-none text-center fw-bold">
                        <a href="<?= url_to('forgot') ?>"><?= lang('Auth.forgotYourPassword') ?></a>
                    </div>
                <?php endif; ?>

                <?php if ($config->allowRegistration) : ?>
                    <a href="<?= base_url('register'); ?>" type="button" class="text-center fw-bold"><?= lang('Auth.needAnAccount') ?></a>
                <?php endif; ?>

                <a href="<?= base_url(); ?>" type="button" class="text-center fw-bold">Kembali ke Beranda</a>
            </div>
        </form>

        <?= view('Myth\Auth\Views\auth\_copyright'); ?>
    </div>
</div>

<?= $this->endSection(); ?>