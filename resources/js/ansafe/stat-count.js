/**
 * @param {number} target
 */
export function ansafeStatCount(target) {
    const goal = Number(target) || 0;

    return {
        displayValue: 0,

        init() {
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                this.displayValue = goal;

                return;
            }

            const durationMs = 900;
            const startAt = performance.now();

            const tick = (now) => {
                const progress = Math.min((now - startAt) / durationMs, 1);
                const eased = 1 - Math.pow(1 - progress, 3);
                this.displayValue = Math.round(goal * eased);

                if (progress < 1) {
                    requestAnimationFrame(tick);
                } else {
                    this.displayValue = goal;
                }
            };

            requestAnimationFrame(tick);
        },
    };
}
