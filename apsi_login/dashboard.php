<?php
require "config.php";

// ===== PENJAGA HALAMAN: belum login → tendang ke login.php =====
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard – APSI Minggu 1</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="card">
    <h1>Halo, <?= e($_SESSION["nama"]) ?> 👋</h1>
    <p>Kamu berhasil login.</p>

    <!--
      TEMPEL ISI WEBSITE APSI KAMU DI SINI
      (atau lihat petunjuk mengubah index.html menjadi index.php)
    -->

    <p class="link"><a href="logout.php">Logout</a></p>
  </div>
</body>
</html>
