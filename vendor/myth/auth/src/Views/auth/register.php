<?= $this->extend('Myth\Auth\Views\auth\layout'); ?>

<?= $this->section('content'); ?>

<div class="card bg-glass rounded-4 mb-0">
    <div class="card-body p-5">
        <div class="d-flex justify-content-between align-items-center gap-2 mb-4">
            <h2 class="my-auto "><?= lang('Auth.register') ?></h2>

            <!-- Theme toggle -->
            <?= view('Myth\Auth\Views\auth\_theme_toggle'); ?>
        </div>

        <?= view('Myth\Auth\Views\auth\_alert_message'); ?>

        <form action="<?= url_to('register') ?>" method="post">
            <?= csrf_field(); ?>

            <div class="form-group mb-4">
                <input type="email" class="form-control form-control-lg <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" name="email" aria-describedby="emailHelp" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>">
                <div class="invalid-feedback">
                    <?= session('errors.email') ?>
                </div>
            </div>

            <div class="form-group mb-4">
                <input type="text" class="form-control form-control-lg <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" name="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>">
                <div class="invalid-feedback">
                    <?= session('errors.username') ?>
                </div>
            </div>

            <div class="row gx-lg-2">
                <div class="col-lg-6">
                    <div class="form-group mb-4">
                        <input type="password" name="password" class="form-control form-control-lg <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>" autocomplete="off">
                        <div class="invalid-feedback">
                            <?= session('errors.password') ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group mb-4">
                        <input type="password" name="pass_confirm" class="form-control form-control-lg <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.repeatPassword') ?>" autocomplete="off">
                        <div class="invalid-feedback">
                            <?= session('errors.pass_confirm') ?>
                        </div>
                    </div>
                </div>
            </div>


            <div class="d-flex flex-column gap-4">
                <button type="submit" class="btn btn-primary"><?= lang('Auth.register') ?></button>

                <div class="d-flex justify-content-center gap-2">
                    <span><?= lang('Auth.alreadyRegistered') ?></span>
                    <a href="<?= base_url('login'); ?>" type="button" class="fw-bold"><?= lang('Auth.signIn') ?></a>
                </div>
            </div>
        </form>

        <?= view('Myth\Auth\Views\auth\_copyright'); ?>
    </div>
</div>

<?= $this->endSection(); ?>