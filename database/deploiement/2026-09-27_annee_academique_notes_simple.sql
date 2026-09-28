-- =====================================================================================
--  AMIE-FPT — Année académique sur les notes, absences et ressources (version simple)
--  À exécuter EN UNE SEULE FOIS (même session) : phpMyAdmin > onglet SQL, ou « mysql base < fichier ».
--  FAITES UNE SAUVEGARDE DE LA BASE AVANT.
--  À lancer UNE SEULE FOIS (une seconde exécution échouerait sur « colonne déjà existante » :
--  c'est sans danger, mais utilisez alors le script protégé 2026-09-27_annee_academique_notes.sql).
--  Prérequis : migrations du 11/09 et du 17/09 déjà passées.
-- =====================================================================================

-- 0. Identifiants d'années. @ancienne NE DOIT PAS être NULL (sinon créez l'année 2025-2026 avant).
SET @ancienne     := (SELECT id FROM annee_academiques WHERE code = '2025-2026' LIMIT 1);
SET @nouvelle     := COALESCE((SELECT id FROM annee_academiques WHERE code = '2026-2027' LIMIT 1), @ancienne);
SET @fin_ancienne := CONCAT(COALESCE((SELECT dateFin FROM annee_academiques WHERE id = @ancienne), '2026-07-31'), ' 23:59:59');
SELECT @ancienne AS id_2025_2026, @nouvelle AS id_2026_2027, @fin_ancienne AS fin_2025_2026;

-- 1. Nouvelles colonnes
ALTER TABLE evaluations ADD COLUMN annee_academique_id BIGINT UNSIGNED NULL;
ALTER TABLE evalutes    ADD COLUMN annee_academique_id BIGINT UNSIGNED NULL;
ALTER TABLE sommations  ADD COLUMN annee_academique_id BIGINT UNSIGNED NULL;   -- table MyISAM : pas de clé étrangère
ALTER TABLE absences    ADD COLUMN annee_academique_id BIGINT UNSIGNED NULL;
ALTER TABLE ressources  ADD COLUMN annee_academique_id BIGINT UNSIGNED NULL;

ALTER TABLE evaluations ADD CONSTRAINT evaluations_annee_academique_id_foreign FOREIGN KEY (annee_academique_id) REFERENCES annee_academiques (id) ON DELETE SET NULL;
ALTER TABLE evalutes    ADD CONSTRAINT evalutes_annee_academique_id_foreign    FOREIGN KEY (annee_academique_id) REFERENCES annee_academiques (id) ON DELETE SET NULL;
ALTER TABLE absences    ADD CONSTRAINT absences_annee_academique_id_foreign    FOREIGN KEY (annee_academique_id) REFERENCES annee_academiques (id) ON DELETE SET NULL;
ALTER TABLE ressources  ADD CONSTRAINT ressources_annee_academique_id_foreign  FOREIGN KEY (annee_academique_id) REFERENCES annee_academiques (id) ON DELETE SET NULL;

-- 2. Notes existantes (évaluations PPO, compositions APC, notes sommatives) : année 2025-2026 ...
UPDATE evaluations SET annee_academique_id = @ancienne WHERE annee_academique_id IS NULL;
UPDATE evalutes    SET annee_academique_id = @ancienne WHERE annee_academique_id IS NULL;
UPDATE sommations  SET annee_academique_id = @ancienne WHERE annee_academique_id IS NULL;

--    ... sauf celles des inscriptions d'une année plus récente (déjà saisies pour 2026-2027) : année de l'inscription
UPDATE evaluations n JOIN inscriptions i ON i.id = n.inscription_id JOIN annee_academiques a ON a.id = i.annee_academique_id
   SET n.annee_academique_id = i.annee_academique_id
 WHERE CAST(a.annee1 AS UNSIGNED) > (SELECT CAST(annee1 AS UNSIGNED) FROM annee_academiques WHERE id = @ancienne);
UPDATE evalutes n JOIN inscriptions i ON i.id = n.inscription_id JOIN annee_academiques a ON a.id = i.annee_academique_id
   SET n.annee_academique_id = i.annee_academique_id
 WHERE CAST(a.annee1 AS UNSIGNED) > (SELECT CAST(annee1 AS UNSIGNED) FROM annee_academiques WHERE id = @ancienne);
UPDATE sommations n JOIN inscriptions i ON i.id = n.inscription_id JOIN annee_academiques a ON a.id = i.annee_academique_id
   SET n.annee_academique_id = i.annee_academique_id
 WHERE CAST(a.annee1 AS UNSIGNED) > (SELECT CAST(annee1 AS UNSIGNED) FROM annee_academiques WHERE id = @ancienne);

-- 3. Absences : année de leur inscription (à défaut 2025-2026)
UPDATE absences a JOIN inscriptions i ON i.id = a.inscription_id
   SET a.annee_academique_id = i.annee_academique_id
 WHERE a.annee_academique_id IS NULL AND i.annee_academique_id IS NOT NULL;
UPDATE absences SET annee_academique_id = @ancienne WHERE annee_academique_id IS NULL;

-- 4. Ressources : année de leurs devoirs APC ; sinon selon la date de création (jusqu'au 31/07/2026 : 2025-2026, après : 2026-2027)
UPDATE ressources r
  JOIN (SELECT ressource_id, MIN(annee_academique_id) AS annee
          FROM devoirapc WHERE annee_academique_id IS NOT NULL GROUP BY ressource_id) d
    ON d.ressource_id = r.id
   SET r.annee_academique_id = d.annee
 WHERE r.annee_academique_id IS NULL;
UPDATE ressources SET annee_academique_id = @ancienne WHERE annee_academique_id IS NULL AND created_at <= @fin_ancienne;
UPDATE ressources SET annee_academique_id = @nouvelle WHERE annee_academique_id IS NULL;

-- 5. Affectations PPO : supprime l'ancien index (classe, formateur, matière) qui ignorait l'année et le semestre.
--    L'unicité reste garantie par cfm_unique_par_annee_semestre (classe, formateur, matière, année, semestre).
ALTER TABLE classe_formateur_matiere DROP INDEX unique_assignment;

-- 6. Enregistre les migrations (pour que « php artisan migrate » ne les rejoue pas)
SET @batch := (SELECT COALESCE(MAX(batch), 0) + 1 FROM migrations);
INSERT INTO migrations (migration, batch) VALUES
  ('2026_09_26_000001_add_annee_academique_id_to_evaluation_tables', @batch),
  ('2026_09_26_000002_add_annee_academique_id_to_absences_and_ressources', @batch),
  ('2026_09_26_000003_drop_legacy_unique_assignment_on_classe_formateur_matiere', @batch);

-- =====================================================================================
--  VÉRIFICATIONS
-- =====================================================================================
-- Aucune ligne ne doit rester sans année : toutes les valeurs à 0
SELECT 'evaluations' AS tbl, COUNT(*) AS sans_annee FROM evaluations WHERE annee_academique_id IS NULL
UNION ALL SELECT 'evalutes',   COUNT(*) FROM evalutes   WHERE annee_academique_id IS NULL
UNION ALL SELECT 'sommations', COUNT(*) FROM sommations WHERE annee_academique_id IS NULL
UNION ALL SELECT 'absences',   COUNT(*) FROM absences   WHERE annee_academique_id IS NULL
UNION ALL SELECT 'ressources', COUNT(*) FROM ressources WHERE annee_academique_id IS NULL
UNION ALL SELECT 'devoirs',    COUNT(*) FROM devoirs    WHERE annee_academique_id IS NULL
UNION ALL SELECT 'devoirapc',  COUNT(*) FROM devoirapc  WHERE annee_academique_id IS NULL;

-- Répartition par année
SELECT 'evaluations' AS tbl, a.code, COUNT(*) AS n FROM evaluations x JOIN annee_academiques a ON a.id = x.annee_academique_id GROUP BY a.code
UNION ALL SELECT 'absences',   a.code, COUNT(*) FROM absences x   JOIN annee_academiques a ON a.id = x.annee_academique_id GROUP BY a.code
UNION ALL SELECT 'ressources', a.code, COUNT(*) FROM ressources x JOIN annee_academiques a ON a.id = x.annee_academique_id GROUP BY a.code;

-- L'ancien index doit avoir disparu (plus de « unique_assignment »)
SHOW INDEX FROM classe_formateur_matiere;
