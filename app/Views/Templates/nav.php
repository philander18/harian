<div class="header-nav-phil" x-data>
    <nav class="navbar-phil" x-data="{isActive: false, shop: false }">
        <a href="#" class="navbar-logo-phil"><img src="<?= base_url(); ?>public/images/philandmind_logo_nav.png" alt="Logo Philandmind"></a>
        <div x-bind:class="isActive ? 'active' : ''" @click.stop class="navbar-nav-phil">
            <a href="<?= base_url(); ?>">Harian</a>
            <a href="<?= base_url(); ?>shop">Vicon</a>
        </div>
        <div class="navbar-extra-phil">
            <?php if (is_null($akses)) { ?>
                <a href="<?= base_url(); ?>home/portal" id="log-in" class="text-decoration-none">Login <i class="fa-solid fa-right-to-bracket"></i></a>
            <?php } else { ?>
                <span class="nama-akses"><?= strtoupper($akses); ?></span><a href="<?= base_url(); ?>home/keluar" id="log-out"><i class="fa-solid fa-right-from-bracket"></i></a>
            <?php } ?>
            <a href="#" @click="isActive = !isActive" @click.outside="isActive = false" @click.prevent id="hamburger-menu"><i class="fa-solid fa-bars"></i></a>
        </div>
    </nav>
</div>