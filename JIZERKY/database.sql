CREATE DATABASE IF NOT EXISTS jizerky
CHARACTER SET utf8mb4
COLLATE utf8mb4_czech_ci;

USE jizerky;

CREATE TABLE IF NOT EXISTS uzivatele (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(100),
    last_name VARCHAR(100),
    nickname VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS mista (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nazev VARCHAR(255) NOT NULL,
    lokalita VARCHAR(255),
    kategorie VARCHAR(100),
    popis TEXT,
    obrazek VARCHAR(255),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES uzivatele(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS komentare (
    id INT AUTO_INCREMENT PRIMARY KEY,
    misto_id INT NOT NULL,
    uzivatel_id INT,
    obsah TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (misto_id) REFERENCES mista(id) ON DELETE CASCADE,
    FOREIGN KEY (uzivatel_id) REFERENCES uzivatele(id) ON DELETE SET NULL
);