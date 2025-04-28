<?= $this->extend('Templates/index'); ?>
<?= $this->section('page-content'); ?>
<?= $this->include('Templates/nav'); ?>
<div class="container-phil" x-data="data_utama()">
    <div class="judul-1">Input Pekerjaan Harian</div>
    <section class="section-2" style="padding: 0; gap: 0;">
        <div class="konten-phil filter-harian">
            <div class="judul-4">Tanggal :</div>
            <input class="form-control form-control-sm" type="date" value="<?= date('20y-m-d'); ?>" id="tanggal">
            <button type="button" class="btn btn-sm btn-dark fw-bold" id="tambah">Tambah</button>
        </div>
        <div class="konten-phil">
        </div>
        <div class="konten-phil">
            <div class="judul-3 text-decoration-underline" style="text-align: start;">Operasional</div>
        </div>
        <div class="konten-phil">
        </div>
        <template x-for="item in log.filter(i => i.kategori === 'Operasional')" :key="item.id">
            <div class="konten-phil">
                <div class="card-phil">
                    <div class="judul-4 bg-dark text-light m-0 card-judul" x-text="item.subkategori"></div>
                    <div class="card-body">
                        <textarea class="form-control mr-4" data-id="" data-kategori="Operasional" data-subkategori="" placeholder="Keterangan" rows="3" x-model="item.keterangan"></textarea>
                        <div class="card-durasi">
                            <input class="form-control form-control-sm mt-2 durasi-harian d-inline" type="text" placeholder="Durasi" aria-label="default input example" style="width: 70px; margin-right:8px" data-id="" data-kategori="Operasional" data-subkategori="" x-model="item.durasi">
                            Menit
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </section>
    <template x-if="hasProject()">
        <section class="section-2" style="padding: 0; gap: 0;">
            <div class="konten-phil">
                <div class="judul-3 text-decoration-underline" style="text-align: start;">Project</div>
            </div>
            <div class="konten-phil">
            </div>
            <template x-for="item in log.filter(i => i.kategori === 'Project')" :key="item.id">
                <div class="konten-phil">
                    <div class="card-phil">
                        <div class="judul-4 bg-dark text-light m-0 card-judul" x-text="item.subkategori"></div>
                        <div class="card-body">
                            <textarea class="form-control mr-4" data-id="" data-kategori="Operasional" data-subkategori="" placeholder="Keterangan" rows="3" x-model="item.keterangan"></textarea>
                            <div class="card-durasi">
                                <input class="form-control form-control-sm mt-2 durasi-harian d-inline" type="text" placeholder="Durasi" aria-label="default input example" style="width: 70px; margin-right:8px" data-id="" data-kategori="Operasional" data-subkategori="" x-model="item.durasi">
                                Menit
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </section>
    </template>
    <template x-if="hasSkill()">
        <section class="section-2" style="padding: 0; gap: 0;">
            <div class="konten-phil">
                <div class="judul-3 text-decoration-underline" style="text-align: start;">Upgrade Skill</div>
            </div>
            <div class="konten-phil">
            </div>
            <template x-for="item in log.filter(i => i.kategori === 'Upgrade Skill')" :key="item.id">
                <div class="konten-phil">
                    <div class="card-phil">
                        <div class="judul-4 bg-dark text-light m-0 card-judul" x-text="item.subkategori"></div>
                        <div class="card-body">
                            <textarea class="form-control mr-4" data-id="" data-kategori="Operasional" data-subkategori="" placeholder="Keterangan" rows="3" x-model="item.keterangan"></textarea>
                            <div class="card-durasi">
                                <input class="form-control form-control-sm mt-2 durasi-harian d-inline" type="text" placeholder="Durasi" aria-label="default input example" style="width: 70px; margin-right:8px" data-id="" data-kategori="Operasional" data-subkategori="" x-model="item.durasi">
                                Menit
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </section>
    </template>
    <template x-if="hasImprovement()">
        <section class="section-2" style="padding: 0; gap: 0;">
            <div class="konten-phil">
                <div class="judul-3 text-decoration-underline" style="text-align: start;">Improvement</div>
            </div>
            <div class="konten-phil">
            </div>
            <template x-for="item in log.filter(i => i.kategori === 'Improvement')" :key="item.id">
                <div class="konten-phil">
                    <div class="card-phil">
                        <div class="judul-4 bg-dark text-light m-0 card-judul" x-text="item.subkategori"></div>
                        <div class="card-body">
                            <textarea class="form-control mr-4" data-id="" data-kategori="Operasional" data-subkategori="" placeholder="Keterangan" rows="3" x-model="item.keterangan"></textarea>
                            <div class="card-durasi">
                                <input class="form-control form-control-sm mt-2 durasi-harian d-inline" type="text" placeholder="Durasi" aria-label="default input example" style="width: 70px; margin-right:8px" data-id="" data-kategori="Operasional" data-subkategori="" x-model="item.durasi">
                                Menit
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </section>
    </template>
</div>
<?= $this->endSection(); ?>