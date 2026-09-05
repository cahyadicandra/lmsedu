# 📋 Feature Breakdown — Asalink Academy

> **Legend:**
> - ✅ **UI Done, Wiring Done** — Fungsi berjalan penuh
> - 🔶 **UI Done, Belum Wiring** — Tampilan ada, tapi data masih dummy/static
> - 🔴 **Belum Ada** — Halaman/fitur belum dibuat sama sekali
> - 🗄️ **DB Schema Ada** — Tabel di database sudah dirancang

---

## 🌐 Publik (Tanpa Login)

| Fitur | Status | Catatan |
|-------|--------|---------|
| Landing Page | ✅ | Static, tidak butuh DB |
| Halaman Kursus (`/kursus`) | 🔶 | Konten static hardcoded, belum dari DB |
| Detail Kursus (`/kursus/[id]`) | 🔶 | Ada route-nya, data belum dari DB |
| Login (Real Auth) | 🔶 | Form sudah ada, Supabase Auth sudah dipanggil, tapi butuh project Supabase aktif |
| Login Demo Mode | ✅ | Berjalan via localStorage, tidak butuh DB |
| Register / Daftar Akun | 🔴 | Belum ada halaman register sama sekali |

---

## 🔐 Sistem Autentikasi & Proteksi Route

| Fitur | Status | Catatan |
|-------|--------|---------|
| Supabase Auth (email + password) | 🔶 | Kode sudah ada, butuh project Supabase aktif |
| Auth Guard per Role | 🔶 | Berjalan via `useEffect` di client (ada flash sebelum redirect) |
| Middleware Auth (Server-level) | 🔴 | Belum ada `middleware.js`, proteksi masih di client |
| Token Management | 🔶 | Disimpan di `localStorage`, bukan httpOnly cookie |
| Auto-logout saat token expired | 🔴 | Belum ada mekanisme refresh token |
| Profile auto-create saat signup | 🔶 | Sudah ada DB trigger-nya, tapi register form belum ada |

---

## 👑 Admin

### Dashboard
| Fitur | Status | Catatan |
|-------|--------|---------|
| Dashboard Admin | 🔶 | UI ada, angka (127 peserta, dll.) masih hardcoded |
| Stat cards (peserta, modul, batch, challenges) | 🔶 | Tampilan ada, belum dari DB |
| Tabel peserta terbaru | 🔶 | Data dummy |

### Manajemen Peserta (`/admin/peserta`)
| Fitur | Status | Catatan |
|-------|--------|---------|
| Tabel daftar peserta | 🔶 | UI lengkap, data dummy |
| Search peserta | 🔶 | Filter berjalan di client, tapi data masih dummy |
| Tambah peserta (modal form) | 🔶 | Form ada, tapi simpan hanya ke state lokal, tidak ke DB |
| Edit peserta | 🔶 | Form ada, tidak ke DB |
| Hapus peserta | 🔶 | Konfirmasi ada, hanya hapus dari state lokal |
| Filter by level/batch | 🔶 | UI ada, tidak terhubung ke DB |
| 🗄️ Tabel `profiles` | ✅ | Schema & trigger auto-create sudah ada |

### Manajemen Tutor (`/admin/tutor`)
| Fitur | Status | Catatan |
|-------|--------|---------|
| Halaman Tutor | 🔴 | **Belum ada** `page.js` di folder tutor admin |
| CRUD Tutor | 🔴 | Belum ada |

### Manajemen Batch (`/admin/batch`)
| Fitur | Status | Catatan |
|-------|--------|---------|
| Tabel daftar batch | 🔶 | UI ada, data dummy |
| Tambah batch | 🔶 | Form ada, tidak ke DB |
| Hapus batch | 🔶 | Tidak ke DB |
| Progress bar kapasitas | 🔶 | UI ada, data dummy |
| Assign tutor ke batch | 🔴 | Belum ada di UI |
| 🗄️ Tabel `batch` | ✅ | Schema sudah ada |

### Kurikulum Materi (`/admin/materi`)
| Fitur | Status | Catatan |
|-------|--------|---------|
| Tampilan materi per level/tingkatan | 🔶 | UI **sangat lengkap** (483 baris kode), tapi data dari file `lib/materi.js` (70KB static) |
| Switch tab antar level (SD, SMP, dll.) | 🔶 | Berjalan, tapi data static |
| Filter per fase | 🔶 | Berjalan di client |
| Tambah sesi baru | 🔶 | Form ada, tidak ke DB |
| Edit sesi | 🔶 | Form ada, tidak ke DB |
| Hapus sesi | 🔶 | Tidak ke DB |
| Import dari file static `materi.js` | 🔶 | Berjalan, tapi artinya data tidak persistent |
| 🗄️ Tabel `fase` & `sesi` | ✅ | Schema ada, seed data 32 sesi sudah disiapkan |

### Modul Guru (`/admin/modul`)
| Fitur | Status | Catatan |
|-------|--------|---------|
| Halaman Modul Guru | 🔴 | **Belum ada** `page.js` |

### Dokumentasi Pertemuan (`/admin/dokumentasi`)
| Fitur | Status | Catatan |
|-------|--------|---------|
| Halaman Dokumentasi | 🔴 | **Belum ada** `page.js` |
| Upload/embed link video rekaman | 🔴 | Belum ada |
| 🗄️ Tabel `dokumentasi` | ✅ | Schema sudah ada di migration |

### Challenges (`/admin/challenges`)
| Fitur | Status | Catatan |
|-------|--------|---------|
| Daftar challenges | 🔶 | UI ada, data dummy |
| Tambah challenge manual | 🔶 | Form ada, tidak ke DB |
| Generate challenge via AI (mockup) | 🔶 | UI ada (form prompt + loading state), tapi logikanya hanya `setTimeout` — **belum ada integrasi AI nyata** |
| Hapus challenge | 🔶 | Tidak ke DB |
| Statistik peserta/selesai per challenge | 🔶 | Angka dummy |
| Penilaian submission peserta | 🔴 | Belum ada halaman/fitur review submission |
| 🗄️ Tabel `challenges` & `submissions` | ✅ | Schema sudah ada |

### Leaderboard (`/admin/leaderboard`)
| Fitur | Status | Catatan |
|-------|--------|---------|
| Tampilan leaderboard | 🔶 | UI ada, data dummy |
| Filter per batch/level | 🔶 | UI ada, tidak dari DB |
| 🗄️ Leaderboard dari poin challenges | ✅ | Bisa di-query dari tabel `submissions` |

### Monitor Project (`/admin/project`)
| Fitur | Status | Catatan |
|-------|--------|---------|
| Daftar project | 🔶 | UI ada, data dummy |
| Status project (planning → deployed) | 🔶 | UI ada, tidak ke DB |
| 🗄️ Tabel `projects` | ✅ | Schema sudah ada |

### Kelompok Guru (`/admin/kelompok`)
| Fitur | Status | Catatan |
|-------|--------|---------|
| Daftar kelompok | 🔶 | UI ada, data dummy |
| Assign peran (Sistem Analis, Frontend, Backend) | 🔶 | UI ada, tidak ke DB |
| 🗄️ Tabel `kelompok` & `anggota_kelompok` | ✅ | Schema ada (termasuk enum `peran_kelompok`) |

---

## 🎓 Tutor

| Fitur | Status | Catatan |
|-------|--------|---------|
| Dashboard Tutor | 🔶 | UI ada (stat cards, progress peserta), data dummy |
| Materi Kelas (`/tutor/materi`) | 🔶 | Ada, belum wiring |
| Kurikulum Sesi (`/tutor/kurikulum`) | 🔶 | Ada, belum wiring |
| Daftar Peserta Saya (`/tutor/peserta`) | 🔶 | Ada, belum wiring |
| Progress Belajar Peserta (`/tutor/progress`) | 🔶 | Ada, belum wiring |
| Absensi (`/tutor/absensi`) | 🔶 | Ada, belum wiring |
| Kelompok (`/tutor/kelompok`) | 🔶 | Ada, belum wiring |
| Project Peserta (`/tutor/project`) | 🔶 | Ada, belum wiring |
| Input nilai/penilaian challenge | 🔴 | Belum ada fitur penilaian submission |
| Upload dokumentasi pertemuan | 🔴 | Belum ada |
| 🗄️ Tabel `absensi` | ✅ | Schema ada |

---

## 👩‍🎓 Peserta

| Fitur | Status | Catatan |
|-------|--------|---------|
| Dashboard Peserta | 🔶 | UI ada (progress bar, modul terbaru), data dummy |
| Materi per Level (`/peserta/materi/[level]`) | 🔶 | UI ada, data dari `lib/materi.js` (static) |
| Katalog Materi | 🔶 | UI ada, data static |
| Modul Sesi (khusus Guru) | 🔶 | Ada, belum wiring |
| Progress Belajar (`/peserta/progress`) | 🔶 | UI ada (timeline 12 modul), data dummy |
| Tandai modul selesai | 🔴 | **Belum ada tombol/aksi** yang menyimpan progress ke DB |
| Challenges (`/peserta/challenges`) | 🔶 | UI ada (daftar + status), data dummy |
| Submit jawaban challenge | 🔴 | **Belum ada form submit** di halaman peserta |
| Leaderboard (`/peserta/leaderboard`) | 🔶 | UI ada (ranking + poin), data dummy |
| Project Kelompok (`/peserta/project`) | 🔶 | Ada, belum wiring |
| Update status project | 🔴 | Belum ada aksi yang ke DB |
| 🗄️ Tabel `progress` | ✅ | Schema ada (`belum`, `aktif`, `selesai`) |

---

## 👨‍👩‍👧 Orang Tua

| Fitur | Status | Catatan |
|-------|--------|---------|
| Dashboard Orang Tua | 🔶 | UI ada (info anak, progress, absensi), data dummy (nama "A" hardcoded) |
| Progress Belajar Anak (`/orang-tua/progress`) | 🔶 | Ada, belum wiring |
| Absensi Anak (`/orang-tua/absensi`) | 🔶 | Ada, belum wiring |
| Hubungkan akun Orang Tua ke akun Peserta | 🔴 | **Belum ada** mekanisme linking di UI maupun DB |
| Notifikasi / Laporan | 🔴 | Belum ada |
| 🗄️ Relasi orang_tua ↔ peserta | 🔴 | **Kolom ini belum ada di schema** (perlu ditambahkan) |

---

## 🗄️ Database (Supabase)

### Tabel yang sudah ada di Schema
| Tabel | Keterangan |
|-------|-----------|
| `profiles` | User + role + batch_id |
| `batch` | Kelas/angkatan + tutor_id |
| `fase` | Fase kurikulum (1–6) |
| `sesi` | Sesi/pertemuan dalam fase |
| `dokumentasi` | Rekaman video per sesi |
| `challenges` | Soal challenge |
| `submissions` | Jawaban peserta + nilai |
| `progress` | Status modul per peserta |
| `absensi` | Kehadiran per sesi |
| `kelompok` | Grup project |
| `anggota_kelompok` | Anggota + peran |
| `projects` | Project kelompok |
| `kursus` | Produk kursus (terhubung ke kursus publik) |

### Yang belum ada di Schema
| Kebutuhan | Status |
|-----------|--------|
| Relasi `orang_tua_id` → `peserta_id` di `profiles` | 🔴 Belum ada |
| Tabel `tingkatan` / kolom level di peserta | 🔶 Pakai field di `profiles` tapi belum ada kolom `tingkatan` |
| RLS (Row Level Security) Policies | 🔴 **Belum ada** — semua data bisa diakses siapa saja jika tidak diset |

---

## 🔌 Backend Logic yang Masih Harus Dibangun

| Kebutuhan | Prioritas |
|-----------|-----------|
| Sambungkan **Login** ke Supabase project aktif | 🔴 Tinggi |
| Tambah kolom `tingkatan` di tabel `profiles` | 🔴 Tinggi |
| Tambah relasi orang tua ↔ peserta | 🔴 Tinggi |
| CRUD Peserta → Supabase | 🔴 Tinggi |
| CRUD Batch → Supabase | 🔴 Tinggi |
| CRUD Challenges → Supabase | 🔴 Tinggi |
| Simpan progress belajar peserta → Supabase | 🔴 Tinggi |
| Halaman submit challenge (peserta) | 🔴 Tinggi |
| Pindahkan data `materi.js` → seed ke tabel `sesi` Supabase | 🔴 Tinggi |
| Absensi (input & tampil) → Supabase | 🟡 Sedang |
| Dokumentasi pertemuan (upload link video) | 🟡 Sedang |
| Integrasi AI generate challenge (OpenAI/Gemini API) | 🟡 Sedang |
| Halaman Register peserta | 🟡 Sedang |
| RLS Policies (keamanan data per role) | 🟡 Sedang |
| Middleware auth (server-level route protection) | 🟡 Sedang |
| Manajemen Tutor (halaman admin) | 🟡 Sedang |
| Notifikasi untuk orang tua | 🔵 Rendah |
| Dashboard analitik (grafik nyata) | 🔵 Rendah |

---

## 📊 Summary Progress

| Area | UI | Backend/Wiring |
|------|----|----|
| Autentikasi | 90% | 20% |
| Admin — Manajemen Data | 85% | 0% |
| Admin — Kurikulum | 95% | 5% (data masih di file JS) |
| Tutor — Dashboard & Tools | 80% | 0% |
| Peserta — Belajar & Progress | 80% | 0% |
| Orang Tua | 70% | 0% |
| Database Schema | — | 75% |
| Keamanan (RLS, Middleware) | — | 0% |

> **Overall: UI ~83% ✅ | Backend Wiring ~5% 🔶**
