#Sistem Informasi PMK LP3I Makassar 2014

Aplikasi berbasis Web dengan framework Laravel 4, Bootstrap 3 Admin Template, yang dibuat untuk kepentingan PMK LP3I Makassar

## Features

* Bootstrap 3.x
* Halaman Error Custom
	* 403 for forbidden page accesses
	* 404 for not found pages
	* 500 for internal server errors
* Confide for Authentication and Authorization
* Back-end
	* Admin Template using [adminLTE](https://github.com/almasaeed2010/AdminLTE)
	* User and Role management
	* Manage blog posts and comments
	* [WYSIWYG](https://github.com/xing/wysihtml5) editor for post creation and editing.
    * [DataTables](https://github.com/DataTables/DataTables) dynamic table sorting and filtering.
    * [Colorbox](https://github.com/jackmoore/colorbox) Lightbox jQuery modal popup.
    * [Select 2](https://github.com/ivaynberg/select2) jQuery-based replacement for select boxes
    * [Bootstrap Datepicker](http://www.eyecon.ro/bootstrap-datepicker)
* Front-end
	* [Bootflat](https://github.com/flathemes/bootflat) Flat UI KIT Template
	* User login, registration, forgot password
	* User account area
	* Simple Blog functionality
* Mendukung Oracle Database
* Paket Including:
	* [Confide](https://github.com/zizaco/confide)
	* [Entrust](https://github.com/zizaco/entrust)
	* [Laravel 4 Debugbar](https://github.com/barryvdh/laravel-debugbar)
	* [Laravel-OCI8](https://github.com/yajra/laravel-oci8)
	* [Laravel-Datatables-Oracle](https://github.com/yajra/laravel-datatables-oracle)

## Issues
Lihat [github issue list](https://github.com/hansenmakangiras/sim-pmk/issues) untuk melihat daftar issues.

## Rekomendasi
Saya merekomendasi anda untuk menggunakan Grunt untuk mengcompile dan meminimize assets anda. Lihat ini [article](http://blog.elenakolevska.com/using-grunt-with-laravel-and-bootstrap) for details.

Juga saya merekomendasikan menggunakan [Former](http://anahkiasen.github.io/former/) untuk penggunaan forms anda. Ini adalah library yang sangat bagus.

-----

##Requirements

	PHP >= 5.4.0
	MCrypt PHP Extension
	PHP OCI8 Extension (For Oracle Users)

##Instalasi Aplikasi
### Langkah 1: Get the code
#### Pilihan 1: Git Clone

	git clone https://github.com/yajra/laravel-admin-template.git laravel

#### Pilihan 2: Download the repository

    https://github.com/yajra/laravel-admin-template/archive/master.zip

### Langkah 2: Gunakan Composer untuk menginstall dependencies
#### Pilihan 1: Composer tidak terinstall secara global

    cd laravel
	curl -s http://getcomposer.org/installer | php
	php composer.phar install --dev
#### Pilihan 2: Composer telah terinstall secara global

    cd laravel
	composer install --dev

Jika belum, anda mungkin ingin membuat [composer agar terinstall secara global](http://andrewelkins.com/programming/php/setting-up-composer-globally-for-laravel-4/) untuk petunjuk penggunaan ke depan selanjutnya.

Harap dicatat penggunaan `--dev` sintaks.

Beberapa paket yang digunakan untuk preprocess dan mengecilkan assests yang diperlukan pada lingkungan pengembangan.

Ketika Anda menggunakan proyek Anda pada lingkungan produksi Anda akan ingin meng-upload *** composer.lock *** file yang digunakan pada lingkungan pengembangan dan hanya menjalankan `php composer.phar install` pada server produksi.

Ini akan melewatkan paket pengembangan dan memastikan versi paket yang terinstal pada server produksi sudah sesuai dengan yang akan Anda kembangkan nantinya.

JANGAN PERNAH menjalankan `php composer.phar update` saat anda berada pada lingkungan Production.

### Step 3: Mengatur Environments

Buka ***bootstrap/start.php*** dan ubah beberapa baris berikut sesuaikan dengan pengaturan anda. Anda dapat menggunakan nama komputer anda di Windows dan hostname Anda di OS X dan Linux (ketik `hostname` di terminal). Menggunakan nama mesin akan memungkinkan perintah `php artisan` untuk menggunakan file-file konfigurasi yang tepat juga.

    $env = $app->detectEnvironment(array(

        'local' => array('your-local-machine-name'),
        'staging' => array('your-staging-machine-name'),
        'production' => array('your-production-machine-name'),

    ));

Sekarang buatlah folder di dalam *** app / config *** yang sesuai dengan lingkungan pengembangan kode yang anda gunakan. Biasanya ini menjadi *** *** lokal ketika Anda pertama kali memulai sebuah proyek.

Sekarang Anda akan menyalin file konfigurasi awal dalam folder ini sebelum mengeditnya. Mari kita mulai dengan *** app/config/app.php ***. Jadi *** app/config/local/app.php *** mungkin akan terlihat seperti ini, sebagai sisa konfigurasi dapat dibiarkan default dari file konfigurasi awal:

    <?php

    return array(

        'url' => 'http://myproject.local',

        'timezone' => 'UTC',

        'key' => 'YourSecretKey!!!',

        'providers' => array(

        [... Removed ...]

        /* Uncomment for use in development */
    	//'Barryvdh\Debugbar\ServiceProvider', // Debugger
        ),

    );

### Langkah 4: Pengaturan Database

Sekarang Anda memiliki lingkungan pengembangan yang sudah dikonfigurasi, Anda perlu membuat konfigurasi database untuk itu. Salin file *** app / config / database.php *** *** di app / config / local *** dan mengeditnya agar sesuai dengan pengaturan database lokal Anda. Anda dapat menghapus semua bagian yang tidak berubah sebagai file konfigurasi ini akan dimuat setelah di inisialisasi.

### Langkah 5: Mengatur Mailer

Dalam cara yang sama, salin *** app / config / mail.php *** file konfigurasi di *** app / config / local / mail.php ***. Sekarang mengatur `address` dan` name` dari `array yang dari` di *** config / mail.php ***. Mereka akan digunakan untuk mengirim konfirmasi account dan password reset email ke pengguna.
Jika Anda tidak menetapkan konfigurasi akan gagal karena tidak bisa mengirim email konfirmasi.

### Langkah 6: Populasi Database
Jalankan perintah ini untuk membuat dan mengisi tabel Pengguna:

	php artisan migrate
	php artisan db:seed

### Langkah 7: Set Encryption Key
***Dalam app/config/app.php***

```
/*
|--------------------------------------------------------------------------
| Encryption Key
|--------------------------------------------------------------------------
|
| This key is used by the Illuminate encrypter service and should be set
| to a random, long string, otherwise these encrypted values will not
| be safe. Make sure to change it before deploying any application!
|
*/
```

	'key' => 'YourSecretKey!!!',

You can use artisan to do this

    php artisan key:generate --env=local

Opsi `--env` memungkinkan mendefinisikan lingkungan yang Anda ingin menerapkan pembuatan kunci. Dalam kasus kami, tukang menghasilkan kunci Anda di *** app / config / local / app.php *** dan daun *** 'YourSecretKey !!! "*** *** di app / config / app.php * **. Sekarang dapat dihasilkan lagi ketika Anda memindahkan proyek ke lingkungan lain.

### Langkah 8: Pastikan app/storage dapat diakses oleh server web Anda.

Jika pengaksesan diatur dengan benar:

    chmod -R 775 app/storage

Harusnya dapat bekerja, jika tidak, cobalah :

    chmod -R 777 app/storage

### Langkah 9: Halaman Awal (3 Opsi untuk melanjutkan)

### User login dengan izin komentar
Arahkan ke root situs project Anda dan login di / user / login:

    username : user
    password : user

## Membuat Pengguna Baru
Untuk membuat pengguna baru arahkan ke /user/create

### Admin login
Arahkan ke: /admin

    username: admin
    password: admin

-----
## Struktur Aplikasi

Struktur aplikasi ini adalah sama sebagai default Laravel 4 dengan satu pengecualian.
Pada Aplikasi ini menambahkan `folder library`. Yang, menjadi rumah dari file library tertentu.
File-file dalam library juga bisa ditangani dalam paket komposer, tetapi dimasukkan di sini sebagai contoh.

## Deteksi Bahasa

Jika Anda ingin mendeteksi bahasa pada semua halaman Anda akan ingin menambahkan berikut ke routes.php Anda di atas.

    Route::when('*','detectLang');


### Development

Untuk memudahkan pengembangan Anda akan ingin mengaktifkan beberapa paket yang berguna. Hal ini memerlukan mengedit `app / config / berkas app.php`.

```
    'providers' => array(

        [...]

        /* Uncomment untuk digunakan dalam pengembangan */
		// 'Barryvdh\Debugbar\ServiceProvider',
    ),
```
Uncomment Generator dan Pembantu IDE. Kemudian Anda akan ingin menjalankan update komposer dengan flag dev.

```
php composer.phar update
```
Ini menambahkan generator dan pembantu ide.
Untuk membuatnya membangun pembantu ide otomatis Anda akan ingin memodifikasi pasca-update-cmd di `composer.json`

```
		"post-update-cmd": [
			"php artisan ide-helper:generate",
			"php artisan optimize"
		]
```

### Peluncuran Produksi

Dengan debugging default diaktifkan. Sebelum Anda pergi ke produksi Anda harus menonaktifkan debugging di `app / config / app.php`
```
    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => false,
```

## Pemecahan Masalah

## Composer meminta login / password

Coba gunakan ini dengan melakukan instal sebaliknya.

    composer install --dev --prefer-source --no-interaction

## License

This is free software distributed under the terms of the MIT license

## Informasi Tambahan

Terinspirasi oleh dan berdasarkan [Laravel-4-Bootstrap-Starter-Site] (https://github.com/andrewelkins/Laravel-4-Bootstrap-Starter-Site)

Terinspirasi oleh dan berdasarkan [Laravel-4-Admin-Template] (https://github.com/yajra/laravel-admin-template)

Setiap pertanyaan, jangan ragu untuk [menghubungi saya] (mailto: hansenmakangiras@gmail.com).