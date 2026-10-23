-- Older installations may still require these fields from the previous account schema.
SET @ddl := IF(
    (SELECT COUNT(*)
     FROM information_schema.COLUMNS
     WHERE TABLE_SCHEMA = DATABASE()
       AND TABLE_NAME = 'akun_pengguna'
       AND COLUMN_NAME = 'nama_siswa') > 0,
    'ALTER TABLE akun_pengguna MODIFY nama_siswa VARCHAR(100) NULL',
    'SELECT 1'
);
PREPARE migration_stmt FROM @ddl;
EXECUTE migration_stmt;
DEALLOCATE PREPARE migration_stmt;

SET @ddl := IF(
    (SELECT COUNT(*)
     FROM information_schema.COLUMNS
     WHERE TABLE_SCHEMA = DATABASE()
       AND TABLE_NAME = 'akun_pengguna'
       AND COLUMN_NAME = 'kelas') > 0,
    'ALTER TABLE akun_pengguna MODIFY kelas VARCHAR(50) NULL',
    'SELECT 1'
);
PREPARE migration_stmt FROM @ddl;
EXECUTE migration_stmt;
DEALLOCATE PREPARE migration_stmt;

SET @ddl := IF(
    (SELECT COUNT(*)
     FROM information_schema.STATISTICS
     WHERE TABLE_SCHEMA = DATABASE()
       AND TABLE_NAME = 'akun_pengguna'
       AND INDEX_NAME = 'uq_akun_pengguna_username') = 0,
    'ALTER TABLE akun_pengguna ADD UNIQUE KEY uq_akun_pengguna_username (username)',
    'SELECT 1'
);
PREPARE migration_stmt FROM @ddl;
EXECUTE migration_stmt;
DEALLOCATE PREPARE migration_stmt;

SET @ddl := IF(
    (SELECT COUNT(*)
     FROM information_schema.STATISTICS
     WHERE TABLE_SCHEMA = DATABASE()
       AND TABLE_NAME = 'akun_pengguna'
       AND INDEX_NAME = 'uq_akun_pengguna_siswa') = 0,
    'ALTER TABLE akun_pengguna ADD UNIQUE KEY uq_akun_pengguna_siswa (id_siswa)',
    'SELECT 1'
);
PREPARE migration_stmt FROM @ddl;
EXECUTE migration_stmt;
DEALLOCATE PREPARE migration_stmt;
