# Todo App

Aplikasi Todo sederhana yang memungkinkan pengguna untuk mengelola tugas-tugas mereka dengan mudah. Fitur utama meliputi menambahkan, mengedit, menghapus, serta menandai tugas sebagai selesai atau belum selesai.

## Fitur

-   **Menambahkan Tugas:** Tambah tugas baru dengan judul, tanggal jatuh tempo, prioritas, dan deskripsi.
-   **Mengedit Tugas:** Ubah detail tugas yang ada.
-   **Menghapus Tugas:** Hapus tugas yang tidak diperlukan.
-   **Menandai Tugas sebagai Selesai atau Belum Selesai:** Tandai tugas sebagai selesai atau belum selesai.
-   **Filter Tugas:** Filter tugas berdasarkan status (selesai atau belum selesai).
-   **Pilih Multiple Tasks:** Pilih beberapa tugas sekaligus untuk menghapus atau menandai.

## Teknologi

-   **Backend:** Laravel (PHP)
-   **Frontend:** Blade Templates, Tailwind CSS
-   **JavaScript:** Vanilla JS untuk interaksi dinamis

## Instalasi

1. **Clone Repository**

    ```
    git clone https://github.com/SalmanDMA/technical-test-todoapp-lara.git
    cd <the-app>
    ```

2. **Instal Dependensi**
    ```
    composer install
    npm install
    ```
3. **Konfigurasi Environment**  
   Salin file .env.example menjadi .env dan sesuaikan konfigurasi sesuai kebutuhan:
    ```
    cp .env.example .env
    ```
    Kemudian, generate kunci aplikasi:
    ```
    php artisan key:generate
    ```
4. **Migrasi Database**
   Jalankan migrasi untuk membuat tabel yang diperlukan di database:
    ```
    php artisan migrate
    ```
5. **Jalankan Aplikasi**
    ```
    php artisan serve
    npm run dev
    ```
6. **ENJOY**

## Penggunaan

-   Menambahkan Tugas: Klik tombol "Add Task" untuk membuka modal tambah tugas. Isi detail tugas dan klik "Save Task".
-   Mengedit Tugas: Klik tombol "Edit" di baris tugas yang ingin diubah. Ubah detail tugas di modal dan klik "Save Changes".
-   Menghapus Tugas: Klik tombol "Delete" di baris tugas yang ingin dihapus. Konfirmasi penghapusan di modal.
-   Menandai Tugas: Pilih tugas menggunakan checkbox, kemudian klik "Mark as Completed" atau "Mark as Uncompleted" dari dropdown menu.
-   Menghapus Banyak Tugas: Pilih tugas menggunakan checkbox, kemudian klik "Delete Task".
-   Filter Tugas: Gunakan dropdown filter untuk menampilkan tugas berdasarkan status.

Note: Menghapus banyak tugas dan Menandai Tugas harus memilih dulu task nya, jika tidak ada yang di pilih maka button tersebut akan disabled.

## Kontributor

Proyek ini dikelola oleh [Salman DMA](https://github.com/SALMANDMA).
