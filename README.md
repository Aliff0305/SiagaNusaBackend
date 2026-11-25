# SiagaNusa Backend

Gateway API berbasis **Laravel 13** untuk agregasi, caching lokal, dan sinkronisasi latar belakang (background sync) data kebencanaan dari **BMKG**, **InaTEWS**, dan **Sipongi (KLHK)**.

## Fitur Utama
- **Conditional Cache + Background Sync**: Menggunakan `ETag`, `Last-Modified`, dan hash `sha256` agar cache hanya diperbarui saat data berubah.
- **Integrasi BMKG & InaTEWS**: Data gempa real-time (`datagempa`, `live30event`, `last30event`, `last30feltevent`, `last30tsunamievent`, `3mgempaQL`), katalog/histori, sensor seismik, peta patahan aktif (`GeoJSON`), dan daftar stasiun MMI.
- **Integrasi Sipongi (Kebakaran & Hotspot)**: Data titik panas (`indoHotspot`), ringkasan hotspot, sebaran, statistik kebakaran, operasi pemadaman, kualitas udara (`aqms`), dan batas administratif.
- **Dokumentasi & Playbook**:
  - `/` — Halaman informasi sistem
  - `/docs` — Dokumentasi endpoint API
  - `/playbook` — Uji coba API interaktif langsung dari browser

## Endpoint API
- `GET /api/bmkg` — Daftar semua feed BMKG & status sync
- `GET /api/bmkg/realtime` — Feed gempa real-time
- `GET /api/bmkg/catalog` — Histori & katalog gempa
- `GET /api/bmkg/sensors` — Sensor seismik nasional & global
- `GET /api/bmkg/spatial` — Data geospasial patahan aktif
- `GET /api/bmkg/events/mmi` — Daftar stasiun & intensitas MMI
- `GET /api/bmkg/{feed}` — Feed BMKG spesifik
- `GET /api/sipongi` — Daftar semua feed Sipongi & status sync
- `GET /api/sipongi/{feed}` — Feed Sipongi spesifik

## Menjalankan Sync
Manual lewat Artisan atau jalankan `sync-all.cmd`:
```sh
php artisan bmkg:sync
php artisan sipongi:sync
```

Untuk background sync otomatis:
```sh
php artisan queue:work
php artisan schedule:work
```
