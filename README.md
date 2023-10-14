<h1 align="center">MagangHub</h1>
Dibangun untuk memenuhi tugas akhir pendamping skripsi pendidikan jenjang Sarjana.

## Installing on Ubuntu
- Run: git clone https://github.com/tedohac/maganghub.git
- Run: composer install
- Create .env file
- Run: php artisan key:generate
- Restore DB (maganghub_restored_db.sql) on PHPMyAdmin or run: php artisan migrate

## Role Access (from restored DB)
- Admin Perusahaan 
    - email: mayoraindah001@gmail.com
    - pass : mayora001

- Universitas
    - email: admin@ui.co.id
    - pass : 12345

- DOSPEM
    - email: bambang@ui.co.id
    - pass : 12345

- Admin
    - email: admin@admin.com
    - pass : polman
