-- =============================================================================
-- Script para corrigir tabela migrations em PRODUÇÃO
-- Executa verificações antes de inserir cada registro
-- Depois de rodar este script, execute: php artisan migrate
-- =============================================================================

DELIMITER $$

DROP PROCEDURE IF EXISTS fix_migrations$$

CREATE PROCEDURE fix_migrations()
BEGIN
    DECLARE current_max_batch INT DEFAULT 0;

    -- Pegar o maior batch atual
    SELECT COALESCE(MAX(batch), 0) INTO current_max_batch FROM migrations;

    -- =========================================================================
    -- BATCH 13: settings_boxes
    -- =========================================================================
    IF NOT EXISTS (SELECT 1 FROM migrations WHERE migration = '2023_11_02_130041_create_settings_boxes_table') THEN
        IF EXISTS (SELECT 1 FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'settings_boxes') THEN
            INSERT INTO migrations (migration, batch) VALUES ('2023_11_02_130041_create_settings_boxes_table', current_max_batch + 1);
            SELECT '[OK] settings_boxes: tabela existe, migration registrada' AS resultado;
        ELSE
            SELECT '[PENDENTE] settings_boxes: tabela NAO existe, sera criada pelo php artisan migrate' AS resultado;
        END IF;
    ELSE
        SELECT '[SKIP] settings_boxes: migration ja registrada' AS resultado;
    END IF;

    -- =========================================================================
    -- BATCH 14: financial_accounts
    -- =========================================================================
    IF NOT EXISTS (SELECT 1 FROM migrations WHERE migration = '2025_10_01_001817_create_financial_accounts_table') THEN
        IF EXISTS (SELECT 1 FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'financial_accounts') THEN
            INSERT INTO migrations (migration, batch) VALUES ('2025_10_01_001817_create_financial_accounts_table', current_max_batch + 2);
            SELECT '[OK] financial_accounts: tabela existe, migration registrada' AS resultado;
        ELSE
            SELECT '[PENDENTE] financial_accounts: tabela NAO existe, sera criada pelo php artisan migrate' AS resultado;
        END IF;
    ELSE
        SELECT '[SKIP] financial_accounts: migration ja registrada' AS resultado;
    END IF;

    -- =========================================================================
    -- BATCH 14: financial_entries
    -- =========================================================================
    IF NOT EXISTS (SELECT 1 FROM migrations WHERE migration = '2025_10_01_002118_create_financial_entries_table') THEN
        IF EXISTS (SELECT 1 FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'financial_entries') THEN
            INSERT INTO migrations (migration, batch) VALUES ('2025_10_01_002118_create_financial_entries_table', current_max_batch + 2);
            SELECT '[OK] financial_entries: tabela existe, migration registrada' AS resultado;
        ELSE
            SELECT '[PENDENTE] financial_entries: tabela NAO existe, sera criada pelo php artisan migrate' AS resultado;
        END IF;
    ELSE
        SELECT '[SKIP] financial_entries: migration ja registrada' AS resultado;
    END IF;

    -- =========================================================================
    -- BATCH 14: transactions (altera tabela existente, verifica coluna uuid)
    -- =========================================================================
    IF NOT EXISTS (SELECT 1 FROM migrations WHERE migration = '2025_10_01_002415_create_transactions') THEN
        IF EXISTS (SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'transactions' AND COLUMN_NAME = 'uuid') THEN
            INSERT INTO migrations (migration, batch) VALUES ('2025_10_01_002415_create_transactions', current_max_batch + 2);
            SELECT '[OK] transactions: coluna uuid existe, migration registrada' AS resultado;
        ELSE
            SELECT '[PENDENTE] transactions: coluna uuid NAO existe, sera alterada pelo php artisan migrate' AS resultado;
        END IF;
    ELSE
        SELECT '[SKIP] transactions: migration ja registrada' AS resultado;
    END IF;

    -- =========================================================================
    -- BATCH 14: transfer_details
    -- =========================================================================
    IF NOT EXISTS (SELECT 1 FROM migrations WHERE migration = '2025_10_01_002511_create_transfer_details_table') THEN
        IF EXISTS (SELECT 1 FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'transfer_details') THEN
            INSERT INTO migrations (migration, batch) VALUES ('2025_10_01_002511_create_transfer_details_table', current_max_batch + 2);
            SELECT '[OK] transfer_details: tabela existe, migration registrada' AS resultado;
        ELSE
            SELECT '[PENDENTE] transfer_details: tabela NAO existe, sera criada pelo php artisan migrate' AS resultado;
        END IF;
    ELSE
        SELECT '[SKIP] transfer_details: migration ja registrada' AS resultado;
    END IF;

    -- =========================================================================
    -- BATCH 15: add_transaction_id_to_file_launches (verifica coluna)
    -- =========================================================================
    IF NOT EXISTS (SELECT 1 FROM migrations WHERE migration = '2026_01_13_212338_add_transaction_id_to_file_launches_table') THEN
        IF EXISTS (SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'file_launches' AND COLUMN_NAME = 'transaction_id') THEN
            INSERT INTO migrations (migration, batch) VALUES ('2026_01_13_212338_add_transaction_id_to_file_launches_table', current_max_batch + 3);
            SELECT '[OK] file_launches.transaction_id: coluna existe, migration registrada' AS resultado;
        ELSE
            SELECT '[PENDENTE] file_launches.transaction_id: coluna NAO existe, sera criada pelo php artisan migrate' AS resultado;
        END IF;
    ELSE
        SELECT '[SKIP] file_launches.transaction_id: migration ja registrada' AS resultado;
    END IF;

    -- =========================================================================
    -- BATCH 15: remove_foreign_key_from_file_launches (verifica se FK ainda existe)
    -- =========================================================================
    IF NOT EXISTS (SELECT 1 FROM migrations WHERE migration = '2026_01_19_180459_remove_foreign_key_from_file_launches_table') THEN
        IF NOT EXISTS (
            SELECT 1 FROM information_schema.TABLE_CONSTRAINTS
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = 'file_launches'
              AND CONSTRAINT_NAME = 'file_launches_file_launches_id_entry_foreign'
              AND CONSTRAINT_TYPE = 'FOREIGN KEY'
        ) THEN
            -- FK ja foi removida, so registrar
            INSERT INTO migrations (migration, batch) VALUES ('2026_01_19_180459_remove_foreign_key_from_file_launches_table', current_max_batch + 3);
            SELECT '[OK] file_launches FK id_entry: FK ja removida, migration registrada' AS resultado;
        ELSE
            SELECT '[PENDENTE] file_launches FK id_entry: FK ainda existe, sera removida pelo php artisan migrate' AS resultado;
        END IF;
    ELSE
        SELECT '[SKIP] file_launches FK id_entry: migration ja registrada' AS resultado;
    END IF;

    -- =========================================================================
    -- Resumo final
    -- =========================================================================
    SELECT '===========================================' AS '';
    SELECT 'Resumo: execute "php artisan migrate" para aplicar as migrations PENDENTES' AS '';
    SELECT '===========================================' AS '';

    SELECT migration, batch, 'registrada' AS status FROM migrations ORDER BY id;

END$$

DELIMITER ;

-- Executar a procedure
CALL fix_migrations();

-- Limpar
DROP PROCEDURE IF EXISTS fix_migrations;
