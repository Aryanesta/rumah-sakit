---
viewport: width=device-width,initial-scale=1,viewport-fit=cover
---

# Rancangan Struktur Database

## Ekosistem Surgicon, Angsmart, ANSafe & Landing Page

**Versi:** 1.1 --- Penamaan tabel & kolom dalam Bahasa Inggris
(snake_case) **Prinsip desain:** Master Data Pasien tunggal, normalisasi
hingga 3NF pada entitas transaksional, audit trail penuh, JSON dipakai
seminimal mungkin (hanya untuk snapshot, bukan sumber kebenaran utama).

------------------------------------------------------------------------

## 1. Asumsi & Keputusan Desain

Beberapa hal di PRD ditulis ringkas (mis. `items_checked (JSON)`); untuk
kebutuhan produksi, JSON tersebut dinormalisasi menjadi tabel master +
detail agar bisa diaudit per-item, dicari, dan dilaporkan. Keputusan
lain:

1.  **Satu tabel `users`** untuk semua staf (perawat Surgicon, perawat
    ruangan, kepala ruangan, admin/IT), dibedakan lewat `role_id`.
    Pasien **tidak** disimpan di `users` --- punya jalur otentikasi
    sendiri (No. RM + token/tanggal lahir).
2.  **RBAC** dimodelkan granular per modul (`role_module_access`) agar
    matriks RBAC (Full Akses / Lihat saja / Lihat & isi / ---) bisa
    diatur tanpa ubah kode.
3.  **Checklist perawat** (Pre-OP & Post-OP) dipecah menjadi tabel
    *master item* + *transaksi header* + *detail jawaban*, bukan satu
    kolom JSON.
4.  **Asesmen MFS** dinormalisasi ke indikator standar Morse Fall Scale
    (6 indikator baku) agar skor otomatis dihitung dari data
    terstruktur, bukan dipercaya dari input klien.
5.  **`nursing_cares` dibuat otomatis** saat pasien baru ditambahkan
    (trigger aplikasi/DB).
6.  Semua tabel transaksi punya `created_at`; tabel yang butuh audit
    (checklist, guide log, handover) juga punya `created_by`/pihak yang
    bertanggung jawab mengarah ke `users.id`.
7.  Tabel bertanda **(Fase 2)** tidak wajib ada di rilis MVP tapi
    disertakan agar skema tidak perlu migrasi besar nanti.

Konvensi penamaan: nama tabel plural, `snake_case`, PK selalu `id`, FK
selalu `<singular_entity>_id` (mis. `patient_id`, `nurse_id`).

------------------------------------------------------------------------

## 2. Diagram ERD (Mermaid)

``` mermaid
erDiagram
    ROLES ||--o{ USERS : "has"
    ROLES ||--o{ ROLE_MODULE_ACCESS : "governs"

    USERS ||--o{ PATIENTS : "registers"
    USERS ||--o{ PREOP_VERIFICATIONS : "verifies"
    USERS ||--o{ POSTOP_VERIFICATIONS : "verifies"
    USERS ||--o{ NURSING_CARES : "records"
    USERS ||--o{ HANDOVER_LOGS : "performs"
    USERS ||--o{ NURSING_CARE_PLANS : "prepares"
    USERS ||--o{ MFS_ASSESSMENTS : "assesses"
    USERS ||--o{ PATIENT_GUIDE_LOGS : "confirms on behalf of"
    USERS ||--o{ AUDIT_LOGS : "performs action"
    USERS ||--o{ NOTIFICATIONS : "receives"

    PATIENTS ||--o{ PATIENT_GUIDE_LOGS : "has read log"
    PATIENTS ||--o{ PREOP_VERIFICATIONS : "is verified"
    PATIENTS ||--o{ POSTOP_VERIFICATIONS : "is verified"
    PATIENTS ||--|| NURSING_CARES : "has (1 active)"
    PATIENTS ||--o{ HANDOVER_LOGS : "is handed over"
    PATIENTS ||--o{ NURSING_CARE_PLANS : "has plan"
    PATIENTS ||--o{ MFS_ASSESSMENTS : "is fall-risk assessed"
    PATIENTS ||--o{ PATIENT_ACCESS_TOKENS : "has access token"
    PATIENTS ||--o{ NOTIFICATIONS : "triggers"

    GUIDE_CONTENTS ||--o{ PATIENT_GUIDE_LOGS : "is read via"

    VERIFICATION_ITEM_MASTER ||--o{ PREOP_VERIFICATION_DETAILS : "referenced by"
    VERIFICATION_ITEM_MASTER ||--o{ POSTOP_VERIFICATION_DETAILS : "referenced by"
    PREOP_VERIFICATIONS ||--o{ PREOP_VERIFICATION_DETAILS : "consists of"
    POSTOP_VERIFICATIONS ||--o{ POSTOP_VERIFICATION_DETAILS : "consists of"

    NURSING_DIAGNOSIS_MASTER ||--o{ NURSING_CARE_PLANS : "referenced by"

    MFS_INDICATOR_MASTER ||--o{ MFS_INDICATOR_OPTIONS : "has"
    MFS_INDICATOR_OPTIONS ||--o{ MFS_ASSESSMENT_DETAILS : "chosen in"
    MFS_ASSESSMENTS ||--o{ MFS_ASSESSMENT_DETAILS : "consists of"

    EDUCATION_VIDEOS {
        int id PK
    }
    DOCTORS {
        int id PK
    }
    TESTIMONIALS {
        int id PK
    }
    LANDING_CONTENTS {
        int id PK
    }
```

> Catatan: `EDUCATION_VIDEOS`, `DOCTORS`, `TESTIMONIALS`,
> `LANDING_CONTENTS` sengaja berdiri sendiri (tidak ber-FK ke
> Patients/Users) karena sifatnya konten publik landing page yang
> dikelola Admin/IT, bukan data klinis.

------------------------------------------------------------------------

## 3. Kamus Tabel Lengkap

### 3.1 Identitas, RBAC & Master Data

**`roles`**

  Kolom         Tipe                  Keterangan
  ------------- --------------------- ---------------------------------------------------------------------------------------
  id            INT, PK               
  role_name     VARCHAR(50), UNIQUE   Surgicon Nurse, Ward Nurse, Fall-Risk Assessor Nurse, Head Nurse/Supervisor, Admin/IT
  description   TEXT                  
  created_at    TIMESTAMP             

**`users`** (seluruh staf)

  Kolom                    Tipe                     Keterangan
  ------------------------ ------------------------ ----------------------------
  id                       INT, PK                  
  role_id                  INT, FK → roles.id       
  name                     VARCHAR(150)             
  email                    VARCHAR(150), UNIQUE     
  username                 VARCHAR(50), UNIQUE      
  password_hash            VARCHAR(255)             
  license_number           VARCHAR(50), NULLABLE    No. STR/SIP tenaga medis
  work_unit                VARCHAR(100), NULLABLE   OK, Ruang Rawat Inap, dst.
  is_active                BOOLEAN, DEFAULT true    
  created_at, updated_at   TIMESTAMP                

**`role_module_access`** (matriks RBAC)

  Kolom                     Tipe                                                           Keterangan
  ------------------------- -------------------------------------------------------------- ---------------------
  id                        INT, PK                                                        
  role_id                   INT, FK → roles.id                                             
  module                    ENUM(\'SURGICON\',\'ANGSMART\',\'ANSAFE\',\'LANDING_ADMIN\')   
  access_level              ENUM(\'NONE\',\'VIEW\',\'VIEW_INPUT\',\'FULL\')                
  UNIQUE(role_id, module)                                                                  Constraint komposit

**`patients`** (Master Data --- jantung integrasi ketiga modul)

  Kolom                    Tipe                                                                          Keterangan
  ------------------------ ----------------------------------------------------------------------------- -----------------------------------------------------------
  id                       INT/UUID, PK                                                                  
  medical_record_no        VARCHAR(30), UNIQUE, NOT NULL                                                 No. RM --- validasi unik lintas ekosistem
  name                     VARCHAR(150)                                                                  
  date_of_birth            DATE                                                                          dipakai untuk umur & otentikasi pasien
  gender                   ENUM(\'M\',\'F\')                                                             
  room_bed                 VARCHAR(20), NULLABLE                                                         
  diagnosis                TEXT                                                                          
  procedure_type           VARCHAR(150)                                                                  
  phase_status             ENUM(\'PRE_OP\',\'INTRA_OP\',\'POST_OP\',\'INPATIENT_CARE\',\'DISCHARGED\')   sumber kebenaran status card di Beranda Surgicon/Angsmart
  surgery_schedule         DATETIME, NULLABLE                                                            dipakai logika alert \"\< 2 jam belum baca guide\"
  patient_access_code      VARCHAR(20), UNIQUE                                                           token akses portal pasien
  created_by               INT, FK → users.id                                                            perawat yang mendaftarkan
  created_at, updated_at   TIMESTAMP                                                                     

------------------------------------------------------------------------

### 3.2 Modul Surgicon

**`guide_contents`** (materi Pre-OP/Post-OP Guide)

  Kolom          Tipe                           Keterangan
  -------------- ------------------------------ --------------------------------
  id             INT, PK                        
  guide_type     ENUM(\'PRE_OP\',\'POST_OP\')   
  title          VARCHAR(200)                   
  content        TEXT/JSON                      teks, gambar, atau video embed
  sort_order     INT                            urutan tampil poin panduan
  is_published   BOOLEAN                        
  updated_at     TIMESTAMP                      

**`patient_guide_logs`**

  Kolom                  Tipe                                    Keterangan
  ---------------------- --------------------------------------- ------------------------------------------------------
  id                     INT, PK                                 
  patient_id             INT, FK → patients.id                   
  guide_content_id       INT, FK → guide_contents.id, NULLABLE   versi guide yang dibaca
  guide_type             ENUM(\'PRE_OP\',\'POST_OP\')            
  is_read                BOOLEAN, DEFAULT false                  
  read_at                TIMESTAMP, NULLABLE                     
  checked_by_nurse       BOOLEAN, DEFAULT false                  skenario perawat bantu centang atas konfirmasi lisan
  confirmed_by_user_id   INT, FK → users.id, NULLABLE            wajib diisi jika `checked_by_nurse = true`
  created_at             TIMESTAMP                               

**`verification_item_master`** (daftar poin checklist perawat, dipakai
Pre-OP & Post-OP)

  Kolom        Tipe                           Keterangan
  ------------ ------------------------------ ---------------------------------------------------------------------------
  id           INT, PK                        
  type         ENUM(\'PRE_OP\',\'POST_OP\')   
  item_name    VARCHAR(200)                   mis. \"Identity verified\", \"Fasting status\", \"Surgical site marking\"
  sort_order   INT                            
  is_active    BOOLEAN                        

**`preop_verifications`** (header transaksi)

  Kolom         Tipe                            Keterangan
  ------------- ------------------------------- -------------------------------------------------------------------
  id            INT, PK                         
  patient_id    INT, FK → patients.id           
  nurse_id      INT, FK → users.id              
  status        ENUM(\'DRAFT\',\'COMPLETED\')   \"Completed\" memicu perubahan `patients.phase_status` → INTRA_OP
  notes         TEXT                            
  recorded_at   TIMESTAMP                       

**`preop_verification_details`**

  Kolom                                           Tipe                                    Keterangan
  ----------------------------------------------- --------------------------------------- ------------
  id                                              INT, PK                                 
  preop_verification_id                           INT, FK → preop_verifications.id        
  item_master_id                                  INT, FK → verification_item_master.id   
  is_checked                                      BOOLEAN                                 
  item_note                                       VARCHAR(255), NULLABLE                  
  UNIQUE(preop_verification_id, item_master_id)                                           

**`postop_verifications`** & **`postop_verification_details`** ---
struktur identik dengan pasangan Pre-OP di atas (header + detail),
merujuk `verification_item_master` dengan `type = 'POST_OP'`.
\"Completed\" pada tabel ini memicu `patients.phase_status` →
INPATIENT_CARE.

------------------------------------------------------------------------

### 3.3 Modul Angsmart

**`nursing_cares`**

  Kolom          Tipe                                                                     Keterangan
  -------------- ------------------------------------------------------------------------ ------------------------------------------------------
  id             INT, PK                                                                  
  patient_id     INT, FK → patients.id                                                    dibuat otomatis saat pasien baru diinput di Surgicon
  nurse_id       INT, FK → users.id                                                       
  care_actions   TEXT                                                                     daftar tindakan keperawatan
  shift          ENUM(\'MORNING\',\'AFTERNOON\',\'NIGHT\')                                
  care_status    ENUM(\'IN_CARE\',\'AWAITING_ACTION\',\'NEEDS_HANDOVER\',\'COMPLETED\')   sumber pie chart Dashboard
  notes          TEXT                                                                     
  updated_at     TIMESTAMP                                                                
  created_at     TIMESTAMP                                                                

**`handover_logs`**

  Kolom              Tipe                     Keterangan
  ------------------ ------------------------ ------------------------------------------
  id                 INT, PK                  
  patient_id         INT, FK → patients.id    
  nurse_id           INT, FK → users.id       pelaku handover
  combined_summary   TEXT                     agregasi otomatis Patient + Nursing Care
  shift_notes        TEXT                     
  is_locked          BOOLEAN, DEFAULT false   true = read-only setelah finalisasi
  locked_at          TIMESTAMP, NULLABLE      
  recorded_at        TIMESTAMP                

**`nursing_diagnosis_master`**

  Kolom                    Tipe                    Keterangan
  ------------------------ ----------------------- ------------
  id                       INT, PK                 
  diagnosis_code           VARCHAR(20), NULLABLE   
  diagnosis_name           VARCHAR(255)            
  goal                     TEXT                    
  intervention             TEXT                    
  created_at, updated_at   TIMESTAMP               

**`nursing_care_plans`**

  Kolom          Tipe                                           Keterangan
  -------------- ---------------------------------------------- --------------------------------------
  id             INT, PK                                        
  patient_id     INT, FK → patients.id                          
  diagnosis_id   INT, FK → nursing_diagnosis_master.id          memicu auto-fill goal & intervention
  nurse_id       INT, FK → users.id                             
  status         ENUM(\'ACTIVE\',\'COMPLETED\',\'CANCELLED\')   
  start_date     DATE                                           
  updated_at     TIMESTAMP                                      

------------------------------------------------------------------------

### 3.4 Modul ANSafe

**`mfs_indicator_master`** (6 indikator baku Morse Fall Scale)

  Kolom            Tipe           Keterangan
  ---------------- -------------- -------------------------------------------------------------------------------------------------------
  id               INT, PK        
  indicator_name   VARCHAR(150)   History of falling, Secondary diagnosis, Ambulatory aid, IV/heparin lock therapy, Gait, Mental status
  sort_order       INT            

**`mfs_indicator_options`** (pilihan jawaban + bobot skor per indikator)

  Kolom          Tipe                                Keterangan
  -------------- ----------------------------------- ----------------------
  id             INT, PK                             
  indicator_id   INT, FK → mfs_indicator_master.id   
  option_label   VARCHAR(150)                        mis. \"No\", \"Yes\"
  score          INT                                 

**`mfs_assessments`** (header)

  Kolom           Tipe                                                  Keterangan
  --------------- ----------------------------------------------------- --------------------------------------------
  id              INT, PK                                               
  patient_id      INT, FK → patients.id                                 
  nurse_id        INT, FK → users.id                                    
  total_score     INT                                                   dihitung otomatis dari detail
  risk_category   ENUM(\'LOW\',\'MODERATE\',\'HIGH\')                   0--24 / 25--44 / ≥45, dihitung server-side
  shift           ENUM(\'MORNING\',\'AFTERNOON\',\'NIGHT\'), NULLABLE   untuk KPI \"ter-asesmen tiap shift\"
  recorded_at     TIMESTAMP                                             

**`mfs_assessment_details`**

  Kolom                                     Tipe                                 Keterangan
  ----------------------------------------- ------------------------------------ ----------------------------------------
  id                                        INT, PK                              
  mfs_assessment_id                         INT, FK → mfs_assessments.id         
  indicator_id                              INT, FK → mfs_indicator_master.id    
  option_id                                 INT, FK → mfs_indicator_options.id   
  UNIQUE(mfs_assessment_id, indicator_id)                                        satu jawaban per indikator per asesmen

**`education_videos`**

  Kolom              Tipe                                           Keterangan
  ------------------ ---------------------------------------------- -----------------------------------------
  id                 INT, PK                                        
  title              VARCHAR(200)                                   
  category           ENUM(\'PATIENT\',\'FAMILY\',\'SAFETY_TIPS\')   filter \"Semua\" = tanpa WHERE category
  embed_url          VARCHAR(255)                                   
  duration_seconds   INT                                            
  description        TEXT                                           
  is_published       BOOLEAN                                        
  created_at         TIMESTAMP                                      

------------------------------------------------------------------------

### 3.5 Landing Page & Lintas Modul

**`doctors`**

  Kolom               Tipe           Keterangan
  ------------------- -------------- ------------
  id                  INT, PK        
  name                VARCHAR(150)   
  specialty           VARCHAR(150)   
  practice_schedule   TEXT/JSON      
  photo_url           VARCHAR(255)   
  is_active           BOOLEAN        

**`testimonials`**

  Kolom              Tipe           Keterangan
  ------------------ -------------- ------------
  id                 INT, PK        
  patient_name       VARCHAR(150)   
  testimonial_text   TEXT           
  rating             TINYINT        
  is_published       BOOLEAN        
  created_at         TIMESTAMP      

**`partners`**

  Kolom          Tipe           Keterangan
  -------------- -------------- ------------
  id             INT, PK        
  partner_name   VARCHAR(150)   
  logo_url       VARCHAR(255)   
  description    TEXT           

**`landing_contents`** (CMS ringan: hero, profil, visi-misi)

  Kolom         Tipe                  Keterangan
  ------------- --------------------- -----------------------------------------------------------
  id            INT, PK               
  section_key   VARCHAR(50), UNIQUE   \'hero\', \'profile\', \'vision_mission\', \'facilities\'
  title         VARCHAR(200)          
  content       TEXT                  
  updated_by    INT, FK → users.id    
  updated_at    TIMESTAMP             

**`audit_logs`** (kebutuhan NFR --- Audit Trail)

  Kolom         Tipe                              Keterangan
  ------------- --------------------------------- --------------------------------------------------------------------------------------------------------------------------------------
  id            BIGINT, PK                        
  user_id       INT, FK → users.id, NULLABLE      null jika aksi dari sisi pasien
  patient_id    INT, FK → patients.id, NULLABLE   
  action        VARCHAR(100)                      mis. \"PREOP_VERIFICATION_SUBMIT\"
  entity_name   VARCHAR(100)                      nama tabel terdampak
  entity_id     INT                               
  detail        JSON                              payload perubahan (before/after) --- satu-satunya JSON yang memang tepat dipakai di sini karena sifatnya log, bukan data operasional
  ip_address    VARCHAR(45)                       
  recorded_at   TIMESTAMP                         

**`notifications`** *(Fase 2 --- alert otomatis)*

  Kolom        Tipe                                            Keterangan
  ------------ ----------------------------------------------- --------------------
  id           INT, PK                                         
  user_id      INT, FK → users.id, NULLABLE                    penerima (perawat)
  patient_id   INT, FK → patients.id, NULLABLE                 pemicu
  type         ENUM(\'GUIDE_NOT_READ_ALERT\',\'INFO\', \...)   
  title        VARCHAR(150)                                    
  message      TEXT                                            
  is_read      BOOLEAN                                         
  created_at   TIMESTAMP                                       

------------------------------------------------------------------------

## 4. Ringkasan Relasi & Kardinalitas

  Entitas Induk                                Kardinalitas                           Entitas Anak                                               Catatan
  -------------------------------------------- -------------------------------------- ---------------------------------------------------------- -----------------------------------
  roles                                        1 --- N                                users                                                      satu role dipakai banyak staf
  roles                                        1 --- N                                role_module_access                                         matriks RBAC per modul
  users (nurse)                                1 --- N                                patients                                                   `created_by`
  patients                                     1 --- N                                patient_guide_logs                                         riwayat baca Pre-OP & Post-OP
  guide_contents                               1 --- N                                patient_guide_logs                                         versi konten yang dibaca
  patients                                     1 --- N                                preop_verifications                                        biasanya 1 aktif, histori tetap N
  patients                                     1 --- N                                postop_verifications                                       idem
  verification_item_master                     1 --- N                                preop_verification_details / postop_verification_details   acuan poin checklist
  preop_verifications / postop_verifications   1 --- N                                \*\_details                                                header--detail
  users (nurse)                                1 --- N                                preop_verifications / postop_verifications                 siapa yang memverifikasi
  patients                                     1 --- 1 (aktif) / 1 --- N (historis)   nursing_cares                                              dibuat otomatis saat registrasi
  patients                                     1 --- N                                handover_logs                                              riwayat serah terima tiap shift
  nursing_diagnosis_master                     1 --- N                                nursing_care_plans                                         auto-fill goal/intervention
  patients                                     1 --- N                                nursing_care_plans                                         
  patients                                     1 --- N                                mfs_assessments                                            tiap shift → banyak asesmen
  mfs_assessments                              1 --- N                                mfs_assessment_details                                     6 indikator per asesmen
  mfs_indicator_master                         1 --- N                                mfs_indicator_options                                      opsi jawaban & bobot skor
  mfs_indicator_options                        1 --- N                                mfs_assessment_details                                     jawaban yang dipilih
  patients                                     1 --- N                                patient_access_tokens                                      token bisa berganti (kadaluarsa)
  users                                        1 --- N                                audit_logs, notifications                                  

Semua relasi di atas **N-sisi anak wajib punya FK NOT NULL** ke
`patients.id`, kecuali `audit_logs.patient_id` dan
`notifications.patient_id` yang nullable (bisa berupa aksi non-klinis).

------------------------------------------------------------------------

## 5. Aturan Bisnis yang Mempengaruhi Skema

1.  **Auto-provisioning lintas modul**: trigger aplikasi pada
    `INSERT patients` → otomatis `INSERT nursing_cares` (status awal
    `AWAITING_ACTION`). Slot ANSafe tidak perlu tabel kosong --- cukup
    pasien langsung bisa dinilai kapan saja karena
    `mfs_assessments.patient_id` FK terbuka.
2.  **Validasi No. RM unik**: `UNIQUE` constraint di
    `patients.medical_record_no`, dicek di level DB bukan hanya
    aplikasi.
3.  **Status \"Completed\" checklist** mengunci perubahan fase pasien:
    semua baris `preop_verification_details.is_checked = true` untuk
    `preop_verification_id` tertentu harus true sebelum `status` bisa
    diubah ke `COMPLETED`.
4.  **Badge peringatan real-time**: dihitung on-the-fly dari
    `patients.surgery_schedule` − NOW() \< 2 jam DAN
    `patient_guide_logs.is_read = false` untuk `guide_type = 'PRE_OP'`
    --- tidak perlu kolom tambahan, cukup query terindeks (lihat §6).
5.  **Handover terkunci** (`is_locked = true`): setelah dikunci, baris
    jadi read-only di level aplikasi; DB bisa menambahkan trigger
    `BEFORE UPDATE` yang menolak perubahan bila `is_locked = true`.
6.  **Skor MFS dihitung server-side** dari
    `SUM(mfs_indicator_options.score)` di `mfs_assessment_details`,
    disimpan sebagai *cache* di `mfs_assessments.total_score` agar query
    dashboard cepat, tapi tetap bisa direkalkulasi ulang untuk audit.

------------------------------------------------------------------------

## 6. Rekomendasi Index

  Tabel                                        Index                                                              Alasan
  -------------------------------------------- ------------------------------------------------------------------ -----------------------------------------
  patients                                     `medical_record_no` (UNIQUE), `phase_status`, `surgery_schedule`   pencarian cepat + query alert real-time
  patient_guide_logs                           `(patient_id, guide_type)`                                         fitur Monitoring Akun Pasien
  preop_verifications / postop_verifications   `(patient_id, status)`                                             List Pasien Pre-OP/Post-OP
  nursing_cares                                `(patient_id, care_status)`                                        pie chart Dashboard Angsmart
  mfs_assessments                              `(patient_id, recorded_at DESC)`                                   riwayat asesmen per pasien
  audit_logs                                   `(entity_name, entity_id)`, `recorded_at`                          penelusuran audit
  education_videos                             `category`                                                         filter Education Center tanpa reload

------------------------------------------------------------------------

## 7. Ringkasan Jumlah Entitas

-   **Master & Identitas:** `roles`, `users`, `role_module_access`,
    `patients`, `patient_access_tokens` (5)
-   **Surgicon:** `guide_contents`, `patient_guide_logs`,
    `verification_item_master`, `preop_verifications`,
    `preop_verification_details`, `postop_verifications`,
    `postop_verification_details` (7)
-   **Angsmart:** `nursing_cares`, `handover_logs`,
    `nursing_diagnosis_master`, `nursing_care_plans` (4)
-   **ANSafe:** `mfs_indicator_master`, `mfs_indicator_options`,
    `mfs_assessments`, `mfs_assessment_details`, `education_videos` (5)
-   **Landing & Lintas Modul:** `doctors`, `testimonials`, `partners`,
    `landing_contents`, `audit_logs`, `notifications` (6)

**Total: 27 tabel** --- cukup granular untuk audit penuh & KPI, tapi
tetap bisa disederhanakan (mis. gabungkan
`preop_verifications`/`postop_verifications` jadi satu tabel dengan
kolom `type`) bila tim memilih trade-off skema lebih ramping ketimbang
eksplisit.
