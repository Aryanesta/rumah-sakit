const perPage = 8;

function emptyForm() {
    return {
        id: null,
        name: '',
        medical_record: '',
        room_bed: '',
        date_of_birth: '',
        gender: 'M',
        phase_status: 'PRE_OP',
    };
}

function phaseLabel(phaseOptions, value) {
    const found = phaseOptions.find((option) => option.value === value);

    return found ? found.label : value;
}

function genderLabel(genderOptions, value) {
    const found = genderOptions.find((option) => option.value === value);

    return found ? found.label : value;
}

function formatDateId(isoDate) {
    if (!isoDate) {
        return '—';
    }

    const parts = isoDate.split('-');

    if (parts.length !== 3) {
        return isoDate;
    }

    const date = new Date(Number(parts[0]), Number(parts[1]) - 1, Number(parts[2]));

    return date.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'short',
        year: 'numeric',
    });
}

export function integrationPatientCrud(initialPatients, phaseOptions, genderOptions) {
    return {
        patients: structuredClone(initialPatients),
        phaseOptions,
        genderOptions,
        search: '',
        page: 1,
        formOpen: false,
        formMode: 'create',
        form: emptyForm(),
        formErrors: {},
        deleteOpen: false,
        patientToDelete: null,

        filteredPatients() {
            const term = this.search.trim().toLowerCase();

            return this.patients.filter((patient) => {
                if (term === '') {
                    return true;
                }

                return (
                    patient.name.toLowerCase().includes(term) ||
                    patient.medical_record.toLowerCase().includes(term) ||
                    patient.room_bed.toLowerCase().includes(term)
                );
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

        phaseBadgeClass(phaseStatus) {
            const map = {
                PRE_OP: 'bg-amber-100 text-amber-900 border-amber-200',
                INTRA_OP: 'bg-purple-100 text-purple-900 border-purple-200',
                POST_OP: 'bg-rs-primary-light/40 text-rs-primary-dark border-rs-primary/30',
                INPATIENT_CARE: 'bg-blue-100 text-blue-900 border-blue-200',
                DISCHARGED: 'bg-rs-success/20 text-rs-accent-dark border-rs-success/40',
            };

            return map[phaseStatus] ?? 'bg-rs-background text-rs-text-secondary border-rs-border';
        },

        displayPhase(phaseStatus) {
            return phaseLabel(this.phaseOptions, phaseStatus);
        },

        displayGender(gender) {
            return genderLabel(this.genderOptions, gender);
        },

        displayDateOfBirth(isoDate) {
            return formatDateId(isoDate);
        },

        openCreateForm() {
            this.formMode = 'create';
            this.form = emptyForm();
            this.formErrors = {};
            this.formOpen = true;
        },

        openEditForm(patient) {
            this.formMode = 'edit';
            this.form = { ...patient };
            this.formErrors = {};
            this.formOpen = true;
        },

        closeForm() {
            this.formOpen = false;
            this.formErrors = {};
        },

        validateForm() {
            const errors = {};
            const medicalRecord = this.form.medical_record.trim();

            if (!this.form.name.trim()) {
                errors.name = 'Nama wajib diisi.';
            }

            if (!medicalRecord) {
                errors.medical_record = 'No. RM wajib diisi.';
            } else {
                const duplicate = this.patients.some(
                    (patient) =>
                        patient.medical_record.toLowerCase() === medicalRecord.toLowerCase() &&
                        patient.id !== this.form.id,
                );

                if (duplicate) {
                    errors.medical_record = 'No. RM sudah digunakan.';
                }
            }

            if (!this.form.room_bed.trim()) {
                errors.room_bed = 'Kamar wajib diisi.';
            }

            if (!this.form.date_of_birth) {
                errors.date_of_birth = 'Tanggal lahir wajib diisi.';
            }

            if (!this.form.gender) {
                errors.gender = 'Gender wajib dipilih.';
            }

            if (!this.form.phase_status) {
                errors.phase_status = 'Status fase wajib dipilih.';
            }

            this.formErrors = errors;

            return Object.keys(errors).length === 0;
        },

        submitForm() {
            if (!this.validateForm()) {
                return;
            }

            const payload = {
                id: this.form.id ?? crypto.randomUUID(),
                name: this.form.name.trim(),
                medical_record: this.form.medical_record.trim(),
                room_bed: this.form.room_bed.trim(),
                date_of_birth: this.form.date_of_birth,
                gender: this.form.gender,
                phase_status: this.form.phase_status,
            };

            if (this.formMode === 'create') {
                this.patients.unshift(payload);
                this.page = 1;
            } else {
                const index = this.patients.findIndex((patient) => patient.id === payload.id);

                if (index !== -1) {
                    this.patients.splice(index, 1, payload);
                }
            }

            this.closeForm();
        },

        openDeleteConfirm(patient) {
            this.patientToDelete = patient;
            this.deleteOpen = true;
        },

        closeDeleteConfirm() {
            this.deleteOpen = false;
            this.patientToDelete = null;
        },

        confirmDelete() {
            if (!this.patientToDelete) {
                return;
            }

            const id = this.patientToDelete.id;
            this.patients = this.patients.filter((patient) => patient.id !== id);

            const maxPage = Math.max(1, Math.ceil(this.filteredPatients().length / perPage));

            if (this.page > maxPage) {
                this.page = maxPage;
            }

            this.closeDeleteConfirm();
        },

        formTitle() {
            return this.formMode === 'create' ? 'Tambah Pasien' : 'Ubah Data Pasien';
        },
    };
}
