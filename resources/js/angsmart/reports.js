export function angsmartReportFilters(initialRows) {
    return {
        period: 'today',
        shift: 'pagi',
        rows: initialRows.map((row) => ({
            ...row,
            status: row.status,
        })),
        visibleRows: initialRows,
        generated: false,

        generate() {
            this.visibleRows = this.rows.filter((_, index) => {
                if (this.period === 'week') {
                    return index < 2;
                }

                if (this.period === 'month') {
                    return true;
                }

                return true;
            });

            this.generated = true;
        },
    };
}
