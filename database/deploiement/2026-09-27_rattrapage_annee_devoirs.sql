-- Rattrapage : devoirs (PPO) et devoirs APC créés SANS année académique (annee_academique_id NULL)
-- Règle : toutes les notes existantes comptent pour 2025-2026.
-- Sauvegardez la base avant. Rejouable sans risque (ne touche que les lignes NULL).

SET @ancienne := (SELECT id FROM annee_academiques WHERE code = '2025-2026' LIMIT 1);
SELECT @ancienne AS id_2025_2026;   -- ne doit pas être NULL

-- Avant : nombre de lignes sans année
SELECT 'devoirs' AS tbl, COUNT(*) AS sans_annee FROM devoirs WHERE annee_academique_id IS NULL
UNION ALL SELECT 'devoirapc', COUNT(*) FROM devoirapc WHERE annee_academique_id IS NULL;

UPDATE devoirs    SET annee_academique_id = @ancienne WHERE annee_academique_id IS NULL;
UPDATE devoirapc  SET annee_academique_id = @ancienne WHERE annee_academique_id IS NULL;

-- Après : doit afficher 0 et 0
SELECT 'devoirs' AS tbl, COUNT(*) AS sans_annee FROM devoirs WHERE annee_academique_id IS NULL
UNION ALL SELECT 'devoirapc', COUNT(*) FROM devoirapc WHERE annee_academique_id IS NULL;
