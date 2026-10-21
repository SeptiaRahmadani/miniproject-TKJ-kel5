ALTER TABLE peminjaman
    ADD COLUMN id_siswa INT NULL AFTER id,
    ADD INDEX idx_peminjaman_id_siswa (id_siswa),
    ADD CONSTRAINT fk_peminjaman_siswa
        FOREIGN KEY (id_siswa) REFERENCES data_siswa (id)
        ON DELETE SET NULL
        ON UPDATE CASCADE;
