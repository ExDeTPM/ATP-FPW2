CREATE DATABASE registro_pets;

USE registro_pets;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    nome VARCHAR(255) NOT NULL,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE animais (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    especie ENUM('Ave', 'Réptil', 'Canino', 'Felino', 'Roedor') NOT NULL,
    idade ENUM('filhote', 'jovem', 'adulto', 'idoso') NOT NULL,
    personalidade TEXT NOT NULL,
    motivo_resgate TEXT NOT NULL,
    estado_saude ENUM('Saudável', 'doente', 'em tratamento', 'terminal') NOT NULL
);