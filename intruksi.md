Technical Test: Sistem Distribusi Produk
● Tujuan
Menguji kemampuan kandidat dalam membangun mini sistem transaksi
distribusi produk berbasis Laravel + AJAX + DataTables Server-side.
Catatan Penting:
● Buat repository public di GitHub.
● Invite username berikut: vetencode dan WildanMZaki ke repository tersebut.
● Flow / User Story
1. Halaman Index (distributions.index)
Tujuan: Melihat daftar distribusi produk yang sudah pernah dilakukan.
Fitur:
● Menggunakan AJAX + DataTables server-side.
● Kolom:
○ Tanggal Distribusi
○ Barista (yang menerima distribusi)
○ Total Quantity
○ Estimasi Penjualan (dihitung dari total semua produk × harga)
○ Notes / Catatan
○ Tombol Aksi (Detail, Hapus)
● Modal Detail akan muncul ketika klik tombol detail (lihat produk yang
didistribusikan)
2. Halaman Form Tambah Distribusi (distributions.create)
Tujuan: Menambah transaksi distribusi baru.
Flow User:
1. Pilih barista dari dropdown (daftar user dengan role 'barista')
2. Di bawahnya, ada form AJAX:
○ Pilih produk dari dropdown (produk yang belum terdaftar dalam
distribusi sementara oleh user ini)
○ Masukkan jumlah (qty)
○ Tekan tombol submit untuk menambah produk ke tabel bawah
3. Tabel produk sementara akan terisi dengan data produk, harga, dan qty
4. Di bawah tabel akan otomatis menampilkan:
○ Total qty (dari semua produk sementara)
○ Estimasi hasil penjualan (qty × harga)
5. Submit utama form distribusi:
○ Akan menyimpan header distribusi
○ Mengaitkan semua detail produk (sementara) ke distribusi tersebut
○ Kembali ke halaman index setelah berhasil
● Struktur Tabel
a. users
● id
● name
● email
● password
● active (boolean)
b. products
● id
● name
● price
● active (boolean)
c. distributions
● id
● barista_id (FK users)
● total_qty
● estimated_result
● notes
● created_by (admin id)
d. distribution_details
● id
● distribution_id (nullable saat masih sementara)
● product_id
● qty
● price
● total
● created_by
● AJAX Endpoints
○ GET /distributions (DataTable list)
○ POST /distributions (simpan distribusi)
○ GET /distribution-products (DataTable produk sementara)
○ POST /distribution-products (Tambah produk sementara)
○ DELETE /distribution-products/{id} (hapus produk dari list sementara)
● Minimum Seeder
UserSeeder:
● 1 admin aktif (buat login)
● 1 barista aktif (digunakan pada distribusi)
ProductSeeder:
● 5 produk aktif, masing-masing punya harga acak
● Rangkuman Tujuan Teknis
○ Relasi FK antar tabel (distribution, user, detail, produk)
○ Validasi Laravel dasar (numeric, required, exists)
○ Interaksi AJAX + Datatable
○ Form interaktif real-time (qty + estimasi total)
○ Penyimpanan transactional (store distribusi + attach details)