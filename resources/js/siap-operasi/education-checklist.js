export function siapOperasiEducationChecklist(config) {
    return {
        track: config.track,
        saveUrl: config.saveUrl,
        items: { ...config.initialItems },
        masterIds: config.masterIds,
        feedbackPartial: config.feedbackPartial,
        feedbackComplete: config.feedbackComplete,
        message: '',
        saving: false,

        isChecked(itemId) {
            return Boolean(this.items[itemId]);
        },

        async toggle(itemId, event) {
            const checked = event.target.checked;
            this.items[itemId] = checked;
            this.saving = true;

            try {
                const response = await fetch(this.saveUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        Accept: 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({
                        track: this.track,
                        item_id: itemId,
                        checked,
                    }),
                });

                if (!response.ok) {
                    throw new Error('save failed');
                }

                this.updateFeedback();
            } catch {
                this.items[itemId] = !checked;
                event.target.checked = !checked;
                this.message = 'Gagal menyimpan (mode demo). Coba lagi.';
            } finally {
                this.saving = false;
            }
        },

        masterProgress() {
            const total = this.masterIds.length;
            if (total === 0) {
                return { checked: 0, total: 0 };
            }

            let checked = 0;
            this.masterIds.forEach((id) => {
                if (this.items[id]) {
                    checked++;
                }
            });

            return { checked, total };
        },

        updateFeedback() {
            const { checked, total } = this.masterProgress();

            if (total === 0) {
                this.message = '';

                return;
            }

            if (checked === total) {
                this.message = this.feedbackComplete;

                return;
            }

            this.message = `${checked}/${total} — ${this.feedbackPartial}`;
        },
    };
}
