<?= $this->extend('Templates/index'); ?>
<?= $this->section('page-content'); ?>
<form autocomplete="off" action="<?= base_url(); ?>home/portal" method="POST">
    <div class="container-fluid portal">
        <div class="form-portal">
            <div class="flash">
                <?php if (session()->getFlashdata('notifikasi')) : ?>
                    <div class="alert m-0">
                        <?= session()->getFlashdata('notifikasi'); ?>
                    </div>
                <?php endif; ?>
            </div>
            <input class="form-control" type="password" name="kode" placeholder="Masukkan Kode" aria-label="Kode">
            <button type="Submit" class="btn-submit btn btn-dark fw-bold">Submit</button>
            <a class="btn-back btn btn-dark fw-bold" href="<?= base_url(); ?>" role="button">Back</a>
        </div>
    </div>
</form>
<?= $this->endSection(); ?>