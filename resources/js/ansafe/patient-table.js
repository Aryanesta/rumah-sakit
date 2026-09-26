export function ansafePatientTable(initialPatients) {
    return {
        patients: initialPatients,
        search: '',
        room: 'Semua Kamar',
        risk: 'semua',

        filteredPatients() {
            const term = this.search.trim().toLowerCase();

            return this.patients.filter((patient) => {
                const matchesSearch =
                    term === '' ||
                    patient.name.toLowerCase().includes(term) ||
                    patient.medical_record.includes(term) ||
                    patient.bed.toLowerCase().includes(term) ||
                    patient.diagnosis.toLowerCase().includes(term);

                const matchesRoom =
                    this.room === 'Semua Kamar' || patient.room === this.room;

                const matchesRisk =
                    this.risk === 'semua' || patient.risk === this.risk;

                return matchesSearch && matchesRoom && matchesRisk;
            });
        },

        resetFilters() {
            this.search = '';
            this.room = 'Semua Kamar';
            this.risk = 'semua';
        },
    };
}
