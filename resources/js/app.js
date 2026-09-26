
import Alpine from 'alpinejs';
import { ansafeEducationFilter, ansafeMfsForm } from './ansafe/morse-fall-scale';
import { ansafePatientTable } from './ansafe/patient-table';
import { angsmartHandover } from './angsmart/handover';
import { angsmartNursingCareForm } from './angsmart/nursing-care';
import { angsmartPatientTable } from './angsmart/patient-table';
import { angsmartReportFilters } from './angsmart/reports';

window.Alpine = Alpine;

Alpine.data('ansafePatientTable', (patients) => ansafePatientTable(patients));
Alpine.data('ansafeMfsForm', (dimensions, selections) =>
    ansafeMfsForm(dimensions, selections),
);
Alpine.data('ansafeEducationFilter', (videos) => ansafeEducationFilter(videos));

Alpine.data('angsmartPatientTable', (patients) => angsmartPatientTable(patients));
Alpine.data('angsmartNursingCareForm', (actionTypes) => angsmartNursingCareForm(actionTypes));
Alpine.data('angsmartHandover', (details, defaultSlug) => angsmartHandover(details, defaultSlug));
Alpine.data('angsmartReportFilters', (rows) => angsmartReportFilters(rows));

Alpine.start();
