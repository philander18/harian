<?= $this->extend('Templates/index'); ?>
<?= $this->section('page-content'); ?>
<?= $this->include('Templates/nav'); ?>
<div class="container-phil" id="area-kerja" x-data="data_utama()" x-init="init()" @refresh-data.window="loadData()">
    <div class="judul-1">Input Pekerjaan Harian</div>
    <section class="section-2">
        <div class="konten-phil filter-harian">
            <div class="judul-4">Tanggal :</div>
            <input class="form-control form-control-sm" type="date" x-model="tanggal" id="tanggal" @change="loadData()">
            <button x-show="log.length" type="button" class="btn btn-sm btn-dark fw-bold" id="tambah" data-bs-toggle="modal" data-bs-target="#form-harian" @click="formTambah()">Tambah</button>
            <button x-show="!log.length" type="button" class="btn btn-sm btn-dark fw-bold" id="generate">Generate</button>
        </div>
        <div class="konten-phil">
            <div class="judul-3 text-decoration-underline" style="text-align: start;">Total Waktu : <span x-text="log.length ? totalDurasi : '0'"></span></div>
        </div>
    </section>
    <template x-if="hasOperasional()">
        <section class="section-2" style="padding: 0; gap: 0;">
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
                            <textarea class="form-control mr-4" :data-id="item.id" :placeholder="item.subkategori" rows="3" x-model="item.keterangan" @keyup.debounce.3000="updateData(item.id, item.keterangan, item.durasi)"></textarea>
                            <div class="card-durasi">
                                <input class="form-control form-control-sm mt-2 durasi-harian d-inline" type="text" placeholder="Durasi" aria-label="default input example" style="width: 70px; margin-right:8px" :data-id="item.id" x-model="item.durasi" @keyup.debounce.1000="await updateData(item.id, item.keterangan, item.durasi);refreshData()">
                                Menit
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </section>
    </template>
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
                            <textarea class="form-control mr-4" :data-id="item.id" :placeholder="item.subkategori" rows="3" x-model="item.keterangan" @keyup.debounce.3000="updateData(item.id, item.keterangan, item.durasi)"></textarea>
                            <div class="card-durasi">
                                <input class="form-control form-control-sm mt-2 durasi-harian d-inline" type="text" placeholder="Durasi" aria-label="default input example" style="width: 70px; margin-right:8px" :data-id="item.id" x-model="item.durasi" @keyup.debounce.3000="updateData(item.id, item.keterangan, item.durasi);refreshData()">
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
                            <textarea class="form-control mr-4" :data-id="item.id" :placeholder="item.subkategori" rows="3" x-model="item.keterangan" @keyup.debounce.3000="updateData(item.id, item.keterangan, item.durasi)"></textarea>
                            <div class="card-durasi">
                                <input class="form-control form-control-sm mt-2 durasi-harian d-inline" type="text" placeholder="Durasi" aria-label="default input example" style="width: 70px; margin-right:8px" :data-id="item.id" x-model="item.durasi" @keyup.debounce.3000="updateData(item.id, item.keterangan, item.durasi);refreshData()">
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
                            <textarea class="form-control mr-4" :data-id="item.id" :placeholder="item.subkategori" rows="3" x-model="item.keterangan" @keyup.debounce.3000="updateData(item.id, item.keterangan, item.durasi)"></textarea>
                            <div class="card-durasi">
                                <input class="form-control form-control-sm mt-2 durasi-harian d-inline" type="text" placeholder="Durasi" aria-label="default input example" style="width: 70px; margin-right:8px" :data-id="item.id" x-model="item.durasi" @keyup.debounce.3000="updateData(item.id, item.keterangan, item.durasi);refreshData()">
                                Menit
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </section>
    </template>
    <div class="modal fade" id="form-harian" tabindex="-1" aria-labelledby="Form Input" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="judul_tambah_harian">Tambah Task</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-modal">
                        <label for="tanggal-harian" class="form-label">Tanggal</label>
                        <input class="form-control form-control-sm" type="date" x-model="tanggal" id="tanggal-harian" disabled>
                    </div>
                    <div class="form-modal">
                        <label for="kategori-harian" class="form-label">Kategori</label>
                        <select class="form-select" id="kategori-harian" aria-label="kategori" style="margin-left: 12px;" x-model="selectedKategori" @change="getSubkategori()">
                            <template x-for="(option,index) in kategori" :key="index">
                                <option :value="option.kategori" x-text="option.kategori" :selected="option.kategori === selectedKategori"></option>
                            </template>
                        </select>
                    </div>
                    <div class="form-modal">
                        <label for="subkategori-harian" class="form-label">Subkategori</label>
                        <select class="form-select" id="subkategori-harian" aria-label="subkategori" style="margin-left: 12px;" x-model="selectedSubkategori">
                            <template x-for="(option,index) in subkategori" :key="index">
                                <option :value="option.subkategori" x-text="option.subkategori"></option>
                            </template>
                        </select>
                    </div>
                    <div class="form-modal">
                        <label for="keterangan-harian" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan-harian" placeholder="Keterangan" rows="3" x-model="keterangan"></textarea>
                    </div>
                    <div class="form-modal">
                        <label for="input-durasi-harian" class="form-label">Durasi</label>
                        <input class="form-control form-control-sm" type="text" placeholder="Durasi" id="input-durasi-harian" x-model="durasi">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" :disabled="!isFormValid()" @click="tambahTask()">Tambah</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>