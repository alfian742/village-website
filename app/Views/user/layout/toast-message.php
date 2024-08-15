<?php if (session('success-message-toast')) : ?>
    <div class="position-fixed bottom-0 end-0 me-4 z-2">
        <div class="toast align-items-center text-bg-success border-0 show mb-4" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body d-flex flex-column">
                    <span>Sukses!</span>
                    <span><?= session('success-message-toast');  ?></span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
<?php endif ?>

<?php if (session()->has('error-message-toast')) : ?>
    <div class="position-fixed bottom-0 end-0 me-4 z-2">
        <?php foreach (session('error-message-toast') as $error) : ?>
            <div class="toast align-items-center text-bg-danger border-0 show mb-4" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body d-flex flex-column">
                        <span>Gagal!</span>
                        <span><?= $error; ?></span>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        <?php endforeach ?>
    </div>
<?php endif ?>