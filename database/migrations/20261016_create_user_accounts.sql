CREATE TABLE akun_pengguna (
    id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('guru', 'siswa') NOT NULL,
    id_siswa INT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_akun_pengguna_username (username),
    UNIQUE KEY uq_akun_pengguna_siswa (id_siswa),
    CONSTRAINT fk_akun_pengguna_siswa
        FOREIGN KEY (id_siswa) REFERENCES data_siswa (id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
