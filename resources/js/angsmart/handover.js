export function angsmartHandover(detailsBySlug, defaultSlug) {
    return {
        detailsBySlug,
        selectedSlug: defaultSlug,
        message: '',
        attachments: {
            plan: false,
            exam: false,
            photo: false,
        },
        submitted: false,

        get detail() {
            return this.detailsBySlug[this.selectedSlug] ?? {
                diagnosis: '-',
                procedure: '-',
                phase: '-',
                dpjp: '-',
                allergy: '-',
                summary: [],
            };
        },

        submit() {
            this.submitted = true;
        },

        finalize() {
            this.submitted = true;
        },
    };
}
