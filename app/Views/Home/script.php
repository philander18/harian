<script>
    function data_utama() {
        return {
            log: [],
            tanggal: '<?= date('20y-m-d'); ?>',
            kategori: [],
            subkategori: [],
            tahun: [],
            selectedKategori: 'Operasional',
            selectedSubkategori: '',
            selectedSemester: '',
            selectedTahun: '',
            keterangan: '',
            durasi: '',
            totalDurasi: 0,
            summary: [],
            today: new Date(),

            loadData() {
                fetch('<?= base_url(); ?>home/get_log', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            tanggal: this.tanggal,
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        this.log = data;
                        this.totalDurasi = data.reduce((sum, item) => {
                            return sum + (parseFloat(item.durasi) || 0);
                        }, 0);
                    })
                    .catch(error => console.error('Gagal memuat data:', error));
            },
            refreshData() {
                fetch('<?= base_url(); ?>home/get_log', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            tanggal: this.tanggal,
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        this.totalDurasi = data.reduce((sum, item) => {
                            return sum + (parseFloat(item.durasi) || 0);
                        }, 0);
                    })
                    .catch(error => console.error('Gagal memuat data:', error));
            },
            getKategori() {
                fetch('<?= base_url(); ?>home/get_kategori')
                    .then(response => response.json())
                    .then(data => {
                        this.kategori = data;
                    })
                    .catch(error => console.error('Gagal memuat data:', error));
            },
            getSubkategori() {
                fetch('<?= base_url(); ?>home/get_subkategori', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            tanggal: this.tanggal,
                            kategori: this.selectedKategori,
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        this.subkategori = data;
                        this.selectedSubkategori = data[0].subkategori
                    })
                    .catch(error => console.error('Gagal memuat data:', error));
            },

            getSummary() {
                fetch('<?= base_url(); ?>home/get_summary', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            semester: this.selectedSemester,
                            tahun: this.selectedTahun,
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        this.summary = data;

                    })
                    .catch(error => console.error('Gagal memuat data:', error));
            },
            getTahun() {
                fetch('<?= base_url(); ?>home/get_tahun')
                    .then(response => response.json())
                    .then(data => {
                        this.tahun = data;
                    })
                    .catch(error => console.error('Gagal memuat data:', error));
            },
            isFormValid() {
                return this.tanggal !== '' &&
                    this.selectedKategori !== '' &&
                    this.selectedSubkategori !== '' &&
                    this.keterangan.trim() !== '' &&
                    this.durasi.trim() !== '';
            },
            formTambah() {
                this.selectedKategori = "Operasional";
                this.getSubkategori();
                this.keterangan = '';
                this.durasi = '';
            },
            async tambahTask() {
                try {
                    const response = await fetch('<?= base_url(); ?>home/tambah_task', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            tanggal: this.tanggal,
                            kategori: this.selectedKategori,
                            subkategori: this.selectedSubkategori,
                            keterangan: this.keterangan,
                            durasi: this.durasi
                        })
                    });
                    const result = await response.json();
                    if (result.success) {
                        alert('Data berhasil ditambahkan!');
                        // Reset form
                        this.selectedKategori = 'Operasional';
                        this.selectedSubkategori = '';
                        this.keterangan = '';
                        this.durasi = '';
                    } else {
                        alert('Gagal menambah data!');
                    }
                    window.dispatchEvent(new CustomEvent('refresh-data'));
                } catch (error) {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan.');
                }
            },
            async updateData(id, keterangan, durasi) {
                try {
                    const response = await fetch('<?= base_url(); ?>home/update_data', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            id: id,
                            keterangan: keterangan,
                            durasi: durasi,
                        })
                    });
                    const data = await response.json();
                    return data;
                } catch (error) {
                    console.error('Gagal update data:', error);
                    return {
                        success: false
                    };
                }
            },

            hasOperasional() {
                return this.log.some(item => item.kategori === 'Operasional');
            },
            hasImprovement() {
                return this.log.some(item => item.kategori === 'Improvement');
            },
            hasSkill() {
                return this.log.some(item => item.kategori === 'Upgrade Skill');
            },
            hasProject() {
                return this.log.some(item => item.kategori === 'Project');
            },

            init() {
                this.selectedSemester = '<?= date('n'); ?>' < 7 ? 1 : 2;
                this.selectedTahun = '<?= date('20y'); ?>';
                this.loadData();
                this.getTahun();
                this.getKategori();
                this.getSubkategori();
                this.getSummary();
            }
        }
    }
    // $(document).ready(function() {
    $(document).on('click', '#generate', function() {
        const tanggal = $('#tanggal').val();
        $.ajax({
            url: method_url('home', 'generate'),
            data: {
                tanggal: tanggal,
            },
            method: 'post',
            dataType: 'html',
            success: function(data) {
                window.dispatchEvent(new CustomEvent('refresh-data'));
            }
        });
    });

    $(document).on('click', '#tambah', function() {
        // console.log('tambah');
    });
    // });
</script>