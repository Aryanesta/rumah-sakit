export function angsmartPatientTable(initialPatients) {
    const perPage = 8;

    return {
        patients: initialPatients,
        search: '',
        phase: 'Semua Fase',
        careStatus: 'Semua Status',
        page: 1,

        filteredPatients() {
            const term = this.search.trim().toLowerCase();

            return this.patients.filter((patient) => {
                const matchesSearch =
                    term === '' ||
                    patient.name.toLowerCase().includes(term) ||
                    patient.medical_record.includes(term) ||
                    String(patient.bed).toLowerCase().includes(term) ||
                    patient.diagnosis.toLowerCase().includes(term);

                const matchesPhase =
                    this.phase === 'Semua Fase' ||
                    (this.phase === 'Pre-Op' && patient.phase === 'pre_op') ||
                    (this.phase === 'Post-Op' && patient.phase === 'post_op');

                const matchesStatus =
                    this.careStatus === 'Semua Status' ||
                    (this.careStatus === 'Dalam Asuhan' &&
                        patient.care_status === 'dalam_asuhan') ||
                    (this.careStatus === 'Menunggu Tindakan' &&
                        patient.care_status === 'menunggu_tindakan');

                return matchesSearch && matchesPhase && matchesStatus;
            });
        },

        paginatedPatients() {
            const filtered = this.filteredPatients();
            const start = (this.page - 1) * perPage;

            return filtered.slice(start, start + perPage);
        },

        totalPages() {
            const total = Math.max(1, Math.ceil(this.filteredPatients().length / perPage));

            return Array.from({ length: total }, (_, i) => i + 1);
        },

        rowNumber(index) {
            return (this.page - 1) * perPage + index + 1;
        },

        paginationSummary() {
            const filtered = this.filteredPatients();
            const total = filtered.length;

            if (total === 0) {
                return 'Menampilkan 0 dari 0 pasien';
            }

            const start = (this.page - 1) * perPage + 1;
            const end = Math.min(this.page * perPage, total);

            return `Menampilkan ${start} - ${end} dari ${total} pasien`;
        },

        resetFilters() {
            this.search = '';
            this.phase = 'Semua Fase';
            this.careStatus = 'Semua Status';
            this.page = 1;
        },
    };
}
