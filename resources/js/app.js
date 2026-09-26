
import Alpine from 'alpinejs';
import { ansafeEducationFilter, ansafeMfsForm } from './ansafe/morse-fall-scale';
import { ansafePatientTable } from './ansafe/patient-table';
import { angsmartHandover } from './angsmart/handover';
import { angsmartNursingCareForm } from './angsmart/nursing-care';
import { angsmartPatientTable } from './angsmart/patient-table';
import { angsmartReportFilters } from './angsmart/reports';
import { surgicareChecklistForm } from './surgicare/checklist-form';
import { integrationPatientCrud } from './integration/patient-management';
import { surgicarePatientTable } from './surgicare/patient-table';
import { siapOperasiEducationChecklist } from './siap-operasi/education-checklist';
import { siapOperasiQuiz } from './siap-operasi/siap-check-quiz';

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

Alpine.data('integrationPatientCrud', (patients, phaseOptions, genderOptions) =>
    integrationPatientCrud(patients, phaseOptions, genderOptions),
);

Alpine.data('surgicarePatientTable', (patients) => surgicarePatientTable(patients));
Alpine.data('surgicareChecklistForm', (sections) => surgicareChecklistForm(sections));

Alpine.data('siapOperasiEducationChecklist', (config) => siapOperasiEducationChecklist(config));
Alpine.data('siapOperasiQuiz', (questions, submitUrl, finalMessages) =>
    siapOperasiQuiz(questions, submitUrl, finalMessages),
);

Alpine.start();
