# lms_sekolah
Kode ini untuk magang

# Backend LMS API

## Base URL

```
http://localhost:8000/api
```

> Semua endpoint API menggunakan base URL di atas.

---

## Authentication (Login)

| Role  | Method | Endpoint       | Description         |
| ----- | ------ | -------------- | ------------------- |
| Admin | POST   | `/admin/login` | Login sebagai admin |
| Guru  | POST   | `/guru/login`  | Login sebagai guru  |
| Siswa | POST   | `/siswa/login` | Login sebagai siswa |

---

Password udah di hash ke database
