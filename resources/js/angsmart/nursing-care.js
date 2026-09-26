export function angsmartNursingCareForm(actionTypes) {
    return {
        actionTypes,
        actionType: actionTypes[0] ?? 'Mobilisasi dini',
        actionDate: '2026-09-23',
        shift: 'pagi',
        status: 'selesai',
        notes: '',
        saved: false,

        save() {
            this.saved = true;
        },
    };
}
