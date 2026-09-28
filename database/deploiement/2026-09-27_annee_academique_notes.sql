-- =====================================================================================
--  AMIE-FPT — Rattachement des notes, absences et ressources à une année académique
--  Équivalent SQL des migrations :
--    2026_09_26_000001_add_annee_academique_id_to_evaluation_tables
--    2026_09_26_000002_add_annee_academique_id_to_absences_and_ressources
--    2026_09_26_000003_drop_legacy_unique_assignment_on_classe_formateur_matiere
--
--  À utiliser SEULEMENT si vous ne lancez pas « php artisan migrate » sur le serveur.
--  Le script est rejouable : chaque étape vérifie si elle est déjà faite.
--  FAITES UNE SAUVEGARDE DE LA BASE AVANT.
--
--  Prérequis (migrations déjà passées) :
--    2026_09_11_000001 (année sur les affectations), 2026_09_17_003419 (index
--    cfm_unique_par_annee_semestre), 2026_09_17_010234 (année sur les devoirs).
-- =====================================================================================

-- ---- 0. Garde-fou : l'année 2025-2026 doit exister ------------------------------------
-- Si elle est absente, la requête suivante échoue volontairement (« Subquery returns more
-- than 1 row ») et le script s'arrête : créez l'année avant de continuer.
SET @ancienne := (SELECT id FROM annee_academiques WHERE code = '2025-2026' LIMIT 1);
SELECT IF(@ancienne IS NULL, (SELECT 1 UNION SELECT 2), @ancienne) AS id_annee_2025_2026;

-- 2026-2027 sert aux ressources créées après la fin de 2025-2026 (à défaut : 2025-2026).
SET @nouvelle := COALESCE((SELECT id FROM annee_academiques WHERE code = '2026-2027' LIMIT 1), @ancienne);
SET @fin_ancienne := CONCAT(COALESCE((SELECT dateFin FROM annee_academiques WHERE id = @ancienne), '2026-07-31'), ' 23:59:59');

-- =====================================================================================
--  MIGRATION 1 — évaluations PPO, compositions APC, sommations APC
--  Toutes les notes déjà en base sont de l'année 2025-2026.
-- =====================================================================================

-- ---- Colonne annee_academique_id sur `evaluations` 
SET @c := (SELECT COUNT(*) FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'evaluations' AND column_name = 'annee_academique_id');
SET @q := IF(@c = 0, 'ALTER TABLE `evaluations` ADD COLUMN `annee_academique_id` BIGINT UNSIGNED NULL', 'SELECT ''colonne déjà présente''');
PREPARE s FROM @q; EXECUTE s; DEALLOCATE PREPARE s;
-- clé étrangère : uniquement sur les tables InnoDB (MyISAM ne les gère pas)
SET @e := (SELECT engine FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = 'evaluations');
SET @f := (SELECT COUNT(*) FROM information_schema.table_constraints WHERE table_schema = DATABASE() AND table_name = 'evaluations' AND constraint_name = 'evaluations_annee_academique_id_foreign');
SET @q := IF(@e = 'InnoDB' AND @f = 0, 'ALTER TABLE `evaluations` ADD CONSTRAINT `evaluations_annee_academique_id_foreign` FOREIGN KEY (`annee_academique_id`) REFERENCES `annee_academiques` (`id`) ON DELETE SET NULL', 'SELECT ''clé étrangère ignorée ou déjà présente''');
PREPARE s FROM @q; EXECUTE s; DEALLOCATE PREPARE s;

-- ---- Colonne annee_academique_id sur `evalutes` 
SET @c := (SELECT COUNT(*) FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'evalutes' AND column_name = 'annee_academique_id');
SET @q := IF(@c = 0, 'ALTER TABLE `evalutes` ADD COLUMN `annee_academique_id` BIGINT UNSIGNED NULL', 'SELECT ''colonne déjà présente''');
PREPARE s FROM @q; EXECUTE s; DEALLOCATE PREPARE s;
-- clé étrangère : uniquement sur les tables InnoDB (MyISAM ne les gère pas)
SET @e := (SELECT engine FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = 'evalutes');
SET @f := (SELECT COUNT(*) FROM information_schema.table_constraints WHERE table_schema = DATABASE() AND table_name = 'evalutes' AND constraint_name = 'evalutes_annee_academique_id_foreign');
SET @q := IF(@e = 'InnoDB' AND @f = 0, 'ALTER TABLE `evalutes` ADD CONSTRAINT `evalutes_annee_academique_id_foreign` FOREIGN KEY (`annee_academique_id`) REFERENCES `annee_academiques` (`id`) ON DELETE SET NULL', 'SELECT ''clé étrangère ignorée ou déjà présente''');
PREPARE s FROM @q; EXECUTE s; DEALLOCATE PREPARE s;

-- ---- Colonne annee_academique_id sur `sommations` (MyISAM : pas de clé étrangère)
SET @c := (SELECT COUNT(*) FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'sommations' AND column_name = 'annee_academique_id');
SET @q := IF(@c = 0, 'ALTER TABLE `sommations` ADD COLUMN `annee_academique_id` BIGINT UNSIGNED NULL', 'SELECT ''colonne déjà présente''');
PREPARE s FROM @q; EXECUTE s; DEALLOCATE PREPARE s;
-- clé étrangère : uniquement sur les tables InnoDB (MyISAM ne les gère pas)
SET @e := (SELECT engine FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = 'sommations');
SET @f := (SELECT COUNT(*) FROM information_schema.table_constraints WHERE table_schema = DATABASE() AND table_name = 'sommations' AND constraint_name = 'sommations_annee_academique_id_foreign');
SET @q := IF(@e = 'InnoDB' AND @f = 0, 'ALTER TABLE `sommations` ADD CONSTRAINT `sommations_annee_academique_id_foreign` FOREIGN KEY (`annee_academique_id`) REFERENCES `annee_academiques` (`id`) ON DELETE SET NULL', 'SELECT ''clé étrangère ignorée ou déjà présente''');
PREPARE s FROM @q; EXECUTE s; DEALLOCATE PREPARE s;

-- Rattrapage des notes existantes : année 2025-2026
UPDATE evaluations SET annee_academique_id = @ancienne WHERE annee_academique_id IS NULL;
UPDATE evalutes    SET annee_academique_id = @ancienne WHERE annee_academique_id IS NULL;
UPDATE sommations  SET annee_academique_id = @ancienne WHERE annee_academique_id IS NULL;

-- Notes déjà saisies pour une année plus récente que 2025-2026 (ex. 2026-2027) : année de leur inscription
UPDATE evaluations n JOIN inscriptions i ON i.id = n.inscription_id JOIN annee_academiques a ON a.id = i.annee_academique_id
   SET n.annee_academique_id = i.annee_academique_id
 WHERE CAST(a.annee1 AS UNSIGNED) > (SELECT CAST(annee1 AS UNSIGNED) FROM annee_academiques WHERE id = @ancienne);
UPDATE evalutes n JOIN inscriptions i ON i.id = n.inscription_id JOIN annee_academiques a ON a.id = i.annee_academique_id
   SET n.annee_academique_id = i.annee_academique_id
 WHERE CAST(a.annee1 AS UNSIGNED) > (SELECT CAST(annee1 AS UNSIGNED) FROM annee_academiques WHERE id = @ancienne);
UPDATE sommations n JOIN inscriptions i ON i.id = n.inscription_id JOIN annee_academiques a ON a.id = i.annee_academique_id
   SET n.annee_academique_id = i.annee_academique_id
 WHERE CAST(a.annee1 AS UNSIGNED) > (SELECT CAST(annee1 AS UNSIGNED) FROM annee_academiques WHERE id = @ancienne);

-- =====================================================================================
--  MIGRATION 2 — absences et ressources (disciplines APC)
-- =====================================================================================

-- ---- Colonne annee_academique_id sur `absences` 
SET @c := (SELECT COUNT(*) FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'absences' AND column_name = 'annee_academique_id');
SET @q := IF(@c = 0, 'ALTER TABLE `absences` ADD COLUMN `annee_academique_id` BIGINT UNSIGNED NULL', 'SELECT ''colonne déjà présente''');
PREPARE s FROM @q; EXECUTE s; DEALLOCATE PREPARE s;
-- clé étrangère : uniquement sur les tables InnoDB (MyISAM ne les gère pas)
SET @e := (SELECT engine FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = 'absences');
SET @f := (SELECT COUNT(*) FROM information_schema.table_constraints WHERE table_schema = DATABASE() AND table_name = 'absences' AND constraint_name = 'absences_annee_academique_id_foreign');
SET @q := IF(@e = 'InnoDB' AND @f = 0, 'ALTER TABLE `absences` ADD CONSTRAINT `absences_annee_academique_id_foreign` FOREIGN KEY (`annee_academique_id`) REFERENCES `annee_academiques` (`id`) ON DELETE SET NULL', 'SELECT ''clé étrangère ignorée ou déjà présente''');
PREPARE s FROM @q; EXECUTE s; DEALLOCATE PREPARE s;

-- ---- Colonne annee_academique_id sur `ressources` 
SET @c := (SELECT COUNT(*) FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'ressources' AND column_name = 'annee_academique_id');
SET @q := IF(@c = 0, 'ALTER TABLE `ressources` ADD COLUMN `annee_academique_id` BIGINT UNSIGNED NULL', 'SELECT ''colonne déjà présente''');
PREPARE s FROM @q; EXECUTE s; DEALLOCATE PREPARE s;
-- clé étrangère : uniquement sur les tables InnoDB (MyISAM ne les gère pas)
SET @e := (SELECT engine FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = 'ressources');
SET @f := (SELECT COUNT(*) FROM information_schema.table_constraints WHERE table_schema = DATABASE() AND table_name = 'ressources' AND constraint_name = 'ressources_annee_academique_id_foreign');
SET @q := IF(@e = 'InnoDB' AND @f = 0, 'ALTER TABLE `ressources` ADD CONSTRAINT `ressources_annee_academique_id_foreign` FOREIGN KEY (`annee_academique_id`) REFERENCES `annee_academiques` (`id`) ON DELETE SET NULL', 'SELECT ''clé étrangère ignorée ou déjà présente''');
PREPARE s FROM @q; EXECUTE s; DEALLOCATE PREPARE s;

-- Absences : année de l'inscription concernée ; à défaut (inscription supprimée) 2025-2026
UPDATE absences a JOIN inscriptions i ON i.id = a.inscription_id
   SET a.annee_academique_id = i.annee_academique_id
 WHERE a.annee_academique_id IS NULL AND i.annee_academique_id IS NOT NULL;
UPDATE absences SET annee_academique_id = @ancienne WHERE annee_academique_id IS NULL;

-- Ressources : 1) année de leurs devoirs APC ; 2) sinon la date de création
--   (créées jusqu'à la fin de 2025-2026 -> 2025-2026, après -> 2026-2027)
UPDATE ressources r
  JOIN (SELECT ressource_id, MIN(annee_academique_id) AS annee
          FROM devoirapc WHERE annee_academique_id IS NOT NULL GROUP BY ressource_id) d
    ON d.ressource_id = r.id
   SET r.annee_academique_id = d.annee
 WHERE r.annee_academique_id IS NULL;
UPDATE ressources SET annee_academique_id = @ancienne WHERE annee_academique_id IS NULL AND created_at <= @fin_ancienne;
UPDATE ressources SET annee_academique_id = @nouvelle WHERE annee_academique_id IS NULL;

-- =====================================================================================
--  MIGRATION 3 — supprime l'ancien index d'unicité (classe, formateur, matière)
--  Il ignorait l'année et le semestre : il empêchait de réaffecter la même matière au même
--  formateur pour une nouvelle année ou pour le second semestre.
--  L'unicité reste garantie par cfm_unique_par_annee_semestre.
-- =====================================================================================

-- Garde-fou : le nouvel index doit exister, sinon on s'arrête (même erreur volontaire que plus haut)
SET @actuel := (SELECT COUNT(*) FROM information_schema.statistics WHERE table_schema = DATABASE() AND table_name = 'classe_formateur_matiere' AND index_name = 'cfm_unique_par_annee_semestre');
SELECT IF(@actuel = 0, (SELECT 1 UNION SELECT 2), @actuel) AS index_cfm_unique_par_annee_semestre_present;

SET @ancien := (SELECT COUNT(*) FROM information_schema.statistics WHERE table_schema = DATABASE() AND table_name = 'classe_formateur_matiere' AND index_name = 'unique_assignment');
SET @q := IF(@ancien > 0, 'ALTER TABLE `classe_formateur_matiere` DROP INDEX `unique_assignment`', 'SELECT ''index déjà supprimé''');
PREPARE s FROM @q; EXECUTE s; DEALLOCATE PREPARE s;

-- =====================================================================================
--  ENREGISTREMENT DES MIGRATIONS (pour que « php artisan migrate » ne les rejoue pas ensuite)
-- =====================================================================================

SET @batch := (SELECT COALESCE(MAX(batch), 0) + 1 FROM migrations);
INSERT INTO migrations (migration, batch) SELECT '2026_09_26_000001_add_annee_academique_id_to_evaluation_tables', @batch FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM migrations WHERE migration = '2026_09_26_000001_add_annee_academique_id_to_evaluation_tables');
INSERT INTO migrations (migration, batch) SELECT '2026_09_26_000002_add_annee_academique_id_to_absences_and_ressources', @batch FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM migrations WHERE migration = '2026_09_26_000002_add_annee_academique_id_to_absences_and_ressources');
INSERT INTO migrations (migration, batch) SELECT '2026_09_26_000003_drop_legacy_unique_assignment_on_classe_formateur_matiere', @batch FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM migrations WHERE migration = '2026_09_26_000003_drop_legacy_unique_assignment_on_classe_formateur_matiere');

-- =====================================================================================
--  VÉRIFICATIONS (à lancer après le script)
-- =====================================================================================

-- 1. Aucune ligne ne doit rester sans année (toutes les valeurs « sans_annee » à 0)
SELECT 'evaluations' AS tbl, COUNT(*) AS sans_annee FROM evaluations WHERE annee_academique_id IS NULL
UNION ALL SELECT 'evalutes',    COUNT(*) FROM evalutes    WHERE annee_academique_id IS NULL
UNION ALL SELECT 'sommations',  COUNT(*) FROM sommations  WHERE annee_academique_id IS NULL
UNION ALL SELECT 'absences',    COUNT(*) FROM absences    WHERE annee_academique_id IS NULL
UNION ALL SELECT 'ressources',  COUNT(*) FROM ressources  WHERE annee_academique_id IS NULL
UNION ALL SELECT 'devoirs',     COUNT(*) FROM devoirs     WHERE annee_academique_id IS NULL
UNION ALL SELECT 'devoirapc',   COUNT(*) FROM devoirapc   WHERE annee_academique_id IS NULL;

-- 2. Répartition par année
SELECT 'evaluations' AS tbl, a.code, COUNT(*) AS n FROM evaluations x JOIN annee_academiques a ON a.id = x.annee_academique_id GROUP BY a.code
UNION ALL SELECT 'absences',   a.code, COUNT(*) FROM absences x   JOIN annee_academiques a ON a.id = x.annee_academique_id GROUP BY a.code
UNION ALL SELECT 'ressources', a.code, COUNT(*) FROM ressources x JOIN annee_academiques a ON a.id = x.annee_academique_id GROUP BY a.code;

-- 3. L'ancien index doit avoir disparu, le nouveau rester
SELECT index_name, GROUP_CONCAT(column_name ORDER BY seq_in_index) AS colonnes, IF(non_unique = 0, 'UNIQUE', 'non unique') AS type_index
  FROM information_schema.statistics
 WHERE table_schema = DATABASE() AND table_name = 'classe_formateur_matiere'
 GROUP BY index_name, non_unique;

-- 4. Les trois migrations doivent apparaître comme exécutées
SELECT migration, batch FROM migrations WHERE migration LIKE '2026_09_26_%' ORDER BY migration;
