
import Alpine from 'alpinejs';
import { ansafeEducationFilter, ansafeMfsForm } from './ansafe/morse-fall-scale';
import { ansafePatientTable } from './ansafe/patient-table';

window.Alpine = Alpine;

Alpine.data('ansafePatientTable', (patients) => ansafePatientTable(patients));
Alpine.data('ansafeMfsForm', (dimensions, selections) =>
    ansafeMfsForm(dimensions, selections),
);
Alpine.data('ansafeEducationFilter', (videos) => ansafeEducationFilter(videos));

Alpine.start();
