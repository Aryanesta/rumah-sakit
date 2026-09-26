const baseUrl = '/apps/surgicare/patients';

export function surgicarePatientTable(initialPatients) {
    const perPage = 8;

    return {
        patients: initialPatients,
        search: '',
        phase: 'Semua Fase',
        page: 1,

        filteredPatients() {
            const term = this.search.trim().toLowerCase();

            return this.patients.filter((patient) => {
                const matchesSearch =
                    term === '' ||
                    patient.name.toLowerCase().includes(term) ||
                    patient.medical_record.includes(term) ||
                    patient.diagnosis.toLowerCase().includes(term) ||
                    patient.procedure.toLowerCase().includes(term);

                const matchesPhase =
                    this.phase === 'Semua Fase' ||
                    (this.phase === 'Pre-Op' && patient.phase === 'pre_op') ||
                    (this.phase === 'Post-Op' && patient.phase === 'post_op');

                return matchesSearch && matchesPhase;
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

        statusBadgeClass(tone) {
            const map = {
                success: 'bg-rs-success/20 text-rs-accent-dark border-rs-success/40',
                warning: 'bg-rs-warning/20 text-rs-warning border-rs-warning/40',
                info: 'bg-rs-primary-light/40 text-rs-primary-dark border-rs-primary/30',
                emergency: 'bg-rs-emergency-light text-rs-emergency-dark border-rs-emergency/30',
            };

            return map[tone] ?? map.info;
        },

        checklistUrl(patient) {
            const segment =
                patient.phase === 'pre_op' ? 'pre-op-checklist' : 'post-op-checklist';

            return `${baseUrl}/${patient.slug}/${segment}`;
        },
    };
}
