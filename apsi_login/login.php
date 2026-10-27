<?php
require "config.php";

// Kalau sudah login, langsung ke dashboard
if (isset($_SESSION["user_id"])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $pass  = $_POST["password"] ?? "";

    // Cari user berdasarkan email (prepared statement = aman dari SQL Injection)
    $stmt = $db->prepare("SELECT id, nama, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    // Cocokkan password dengan hash di database
    if ($user && password_verify($pass, $user["password"])) {
        session_regenerate_id(true);          // cegah session fixation
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["nama"]    = $user["nama"];
        header("Location: dashboard.php");
        exit;
    }
    // Pesan sengaja dibuat umum agar tidak membocorkan email mana yang terdaftar
    $error = "Email atau password salah.";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login – APSI Minggu 1</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="card">
    <h1>Login</h1>
    <?php if (isset($_GET["daftar"])): ?>
      <p class="msg ok">✅ Akun berhasil dibuat. Silakan login.</p>
    <?php endif; ?>
    <?php if (isset($_GET["logout"])): ?>
      <p class="msg ok">Kamu sudah logout.</p>
    <?php endif; ?>
    <?php if ($error): ?><p class="msg error"><?= e($error) ?></p><?php endif; ?>

    <form method="post">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="<?= e($_POST['email'] ?? '') ?>" required>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>

      <button type="submit">Masuk</button>
    </form>
    <p class="link">Belum punya akun? <a href="register.php">Daftar</a></p>
  </div>
</body>
</html>
