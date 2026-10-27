<?php
// ===== Konfigurasi database + session (di-include oleh semua halaman) =====
session_start();
mysqli_report(MYSQLI_REPORT_OFF);   // error ditangani manual

// Sesuaikan jika memakai hosting online (host, user, password, nama db)
$db = new mysqli("localhost", "root", "", "apsi_db");
if ($db->connect_error) {
    die("Koneksi database gagal. Pastikan MySQL di XAMPP sudah Start dan database sudah di-import.");
}
$db->set_charset("utf8mb4");

// Fungsi pengaman: cegah script jahat (XSS) saat menampilkan teks
function e($teks) {
    return htmlspecialchars($teks, ENT_QUOTES, "UTF-8");
}
