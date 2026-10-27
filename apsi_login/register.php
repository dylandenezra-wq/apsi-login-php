<?php
require "config.php";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama  = trim($_POST["nama"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $pass  = $_POST["password"] ?? "";
    $pass2 = $_POST["password2"] ?? "";

    // 1) Validasi input
    if ($nama === "" || $email === "" || $pass === "") {
        $error = "Semua kolom wajib diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid.";
    } elseif (strlen($pass) < 6) {
        $error = "Password minimal 6 karakter.";
    } elseif ($pass !== $pass2) {
        $error = "Konfirmasi password tidak sama.";
    } else {
        // 2) Simpan ke database (password di-HASH, tidak disimpan asli)
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO users (nama, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nama, $email, $hash);

        if ($stmt->execute()) {
            header("Location: login.php?daftar=1");
            exit;
        }
        $error = ($stmt->errno === 1062)
            ? "Email sudah terdaftar. Silakan login."
            : "Terjadi kesalahan, coba lagi.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Daftar – APSI Minggu 1</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="card">
    <h1>Buat Akun</h1>
    <?php if ($error): ?><p class="msg error"><?= e($error) ?></p><?php endif; ?>

    <form method="post">
      <label for="nama">Nama</label>
      <input type="text" id="nama" name="nama" value="<?= e($_POST['nama'] ?? '') ?>" required>

      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="<?= e($_POST['email'] ?? '') ?>" required>

      <label for="password">Password (min. 6 karakter)</label>
      <input type="password" id="password" name="password" required>

      <label for="password2">Ulangi Password</label>
      <input type="password" id="password2" name="password2" required>

      <button type="submit">Daftar</button>
    </form>
    <p class="link">Sudah punya akun? <a href="login.php">Login</a></p>
  </div>
</body>
</html>
