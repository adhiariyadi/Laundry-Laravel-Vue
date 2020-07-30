<h1 align="center">Selamat datang di Laundry! 👋</h1>

## Apa itu Laundry?

Web Laundry yang dibuat oleh <a href="https://github.com/adhiariyadi"> Adhi Ariyadi </a>. **Laundry adalah aplikasi manajemen laundry melalui website dengan mudah.**

## Fitur apa saja yang tersedia di Laundry?

-   Dalam Proses Pembuatan

## Release Date

**Release date : 30 Jul 2020**

> Laundry merupakan project open source yang dibuat oleh Adhi Ariyadi. Kalian dapat download/fork/clone. Cukup beri stars di project ini agar memberiku semangat. Terima kasih!

---

## Default Account for testing

**Admin Default Account**

-   Username: admin
-   Password: admin

**Operator Default Account**

-   Username: operator
-   Password: operator

---

## Install

1. **Clone Repository**

```bash
git clone https://github.com/adhiariyadi/Laundry-Laravel-Vue.git
cd Laundry-Laravel-Vue
composer install
npm install
cp .env.example .env
```

2. **Buka `.env` lalu ubah baris berikut sesuai dengan databasemu yang ingin dipakai**

```bash
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

3. **Instalasi website**

```bash
php artisan key:generate
php artisan migrate --seed
php artisan jwt:secret
php artisan config:cache
```

4. **Jalankan website**

```bash
php artisan serve
```

## Author

-   Facebook : <a href="https://web.facebook.com/adhiariyadi.me/"> Adhi Ariyadi</a>
-   LinkedIn : <a href="https://www.linkedin.com/in/adhiariyadi/"> Adhi Ariyadi</a>

## Contributing

Contributions, issues and feature requests di persilahkan.
Jangan ragu untuk memeriksa halaman masalah jika Anda ingin berkontribusi. **Berhubung Project ini saya sudah selesaikan sendiri, namun banyak fitur yang kalian dapat tambahkan silahkan berkontribusi yaa!**

## License

-   Copyright © 2020 Adhi Ariyadi.
-   **Laundry is open-sourced software licensed under the MIT license.**
