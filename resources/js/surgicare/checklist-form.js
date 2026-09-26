export function surgicareChecklistForm(initialSections) {
    return {
        sections: structuredClone(initialSections),
        message: '',

        toggleCheckbox(sectionIndex, itemId, checked) {
            const section = this.sections[sectionIndex];
            if (!section?.items) {
                return;
            }

            const item = section.items.find((entry) => entry.id === itemId);
            if (item) {
                item.checked = checked;
            }
        },

        saveDraft() {
            this.message = 'Draft tersimpan (mode demo).';
        },

        complete() {
            this.message = 'Checklist ditandai selesai (mode demo).';
        },
    };
}
