-- Import file ini lewat phpMyAdmin (tab "Import")
CREATE DATABASE IF NOT EXISTS apsi_db
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE apsi_db;

CREATE TABLE IF NOT EXISTS users (
  id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nama       VARCHAR(100) NOT NULL,
  email      VARCHAR(150) NOT NULL UNIQUE,   -- UNIQUE: email tidak boleh kembar
  password   VARCHAR(255) NOT NULL,          -- berisi HASH, bukan password asli
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
