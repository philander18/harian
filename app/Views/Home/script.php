<script>
    function data_utama() {
        return {
            log: [],

            loadData() {
                fetch('<?= base_url(); ?>home/get_log')
                    .then(response => response.json())
                    .then(data => {
                        this.log = data;
                    })
                    .catch(error => console.error('Gagal memuat data:', error));
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
                this.loadData();
            }
        }
    }
</script>