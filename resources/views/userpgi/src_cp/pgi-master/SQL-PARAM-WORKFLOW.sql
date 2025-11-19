INSERT INTO `etat_workflows` (`id`, `workflow_id`, `type_notification_id`, `etat_suivant_id`, `etat_rejet_id`, `position`, `code`, `libelle`, `description`, `bouton_suivant`, `bouton_rejet`, `est_rejetable`, `libelle_rejet`, `est_fin`, `created_at`, `updated_at`, `status`) VALUES
(1, 1, 1, 2, NULL, 1, 'DEB', 'Brouillon', 'L\'état brouillon', 'Soumis', NULL, 0, NULL, 0, '2024-03-14 05:21:51', '2024-03-14 10:06:09', 'brouillon'),
(2, 1, 2, 3, 1, 2, 'soum', 'Soumis', 'Etat Soumis', 'Valider la conformité', 'Rejeté la demande', 1, NULL, 0, '2024-03-14 05:28:16', '2024-03-14 10:24:10', 'cours'),
(3, 1, 5, 5, 4, 3, 'complet_1', 'Complet', 'Validation au niveau MCFP/MTC', 'Valider la demande', 'Rejeter la demande', 1, NULL, 0, '2024-03-14 05:48:09', '2024-03-14 10:42:22', 'brouillon'),
(4, 1, NULL, NULL, NULL, 4, 'incomplet_1', 'Incomplet', 'Etat obtenu après une invalidation', NULL, NULL, 0, NULL, 1, '2024-03-14 05:50:52', '2024-03-14 10:45:46', 'brouillon'),
(5, 1, 8, NULL, NULL, 5, 'conforme_1', 'Conforme', 'Conforme', NULL, NULL, 0, NULL, 1, '2024-03-14 06:07:57', '2024-03-14 10:50:35', 'valide'),
(6, 1, NULL, NULL, NULL, 6, 'non_conforme_1', 'Non conforme', 'Le Ministère vient de rejeter la demande', NULL, NULL, 0, NULL, 0, '2024-03-14 06:55:17', '2024-03-14 06:55:17', 'brouillon');



INSERT INTO `etat_workflows` (`id`, `workflow_id`, `type_notification_id`, `etat_suivant_id`, `etat_rejet_id`, `position`, `code`, `libelle`, `description`, `bouton_suivant`, `bouton_rejet`, `est_rejetable`, `libelle_rejet`, `est_fin`, `created_at`, `updated_at`, `status`) VALUES
(7, 2, 1, 2, NULL, 1, 'DEB', 'Brouillon', 'L\'état brouillon', 'Soumis', NULL, 0, NULL, 0, '2024-03-14 05:21:51', '2024-03-14 10:06:09', 'brouillon'),
(8, 2, 2, 3, 1, 2, 'soum', 'Soumis', 'Etat Soumis', 'Valider la conformité', 'Rejeté la demande', 1, NULL, 0, '2024-03-14 05:28:16', '2024-03-14 10:24:10', 'cours'),
(9, 2, 5, 5, 4, 3, 'complet_1', 'Complet', 'Validation au niveau MCFP/MTC', 'Valider la demande', 'Rejeter la demande', 1, NULL, 0, '2024-03-14 05:48:09', '2024-03-14 10:42:22', 'brouillon'),
(10, 2, NULL, NULL, NULL, 4, 'incomplet_1', 'Incomplet', 'Etat obtenu après une invalidation', NULL, NULL, 0, NULL, 1, '2024-03-14 05:50:52', '2024-03-14 10:45:46', 'brouillon'),
(11, 2, 8, NULL, NULL, 5, 'conforme_1', 'Conforme', 'Conforme', NULL, NULL, 0, NULL, 1, '2024-03-14 06:07:57', '2024-03-14 10:50:35', 'valide'),
(12, 2, NULL, NULL, NULL, 6, 'non_conforme_1', 'Non conforme', 'Le Ministère vient de rejeter la demande', NULL, NULL, 0, NULL, 0, '2024-03-14 06:55:17', '2024-03-14 06:55:17', 'brouillon');



INSERT INTO `etat_workflows` (`id`, `workflow_id`, `type_notification_id`, `etat_suivant_id`, `etat_rejet_id`, `position`, `code`, `libelle`, `description`, `bouton_suivant`, `bouton_rejet`, `est_rejetable`, `libelle_rejet`, `est_fin`, `created_at`, `updated_at`, `status`) VALUES
(13, 3, 1, 2, NULL, 1, 'DEB', 'Brouillon', 'L\'état brouillon', 'Soumis', NULL, 0, NULL, 0, '2024-03-14 05:21:51', '2024-03-14 10:06:09', 'brouillon'),
(14, 3, 2, 3, 1, 2, 'soum', 'Soumis', 'Etat Soumis', 'Valider la conformité', 'Rejeté la demande', 1, NULL, 0, '2024-03-14 05:28:16', '2024-03-14 10:24:10', 'cours'),
(15, 3, 5, 5, 4, 3, 'complet_1', 'Complet', 'Validation au niveau MCFP/MTC', 'Valider la demande', 'Rejeter la demande', 1, NULL, 0, '2024-03-14 05:48:09', '2024-03-14 10:42:22', 'brouillon'),
(16, 3, NULL, NULL, NULL, 4, 'incomplet_1', 'Incomplet', 'Etat obtenu après une invalidation', NULL, NULL, 0, NULL, 1, '2024-03-14 05:50:52', '2024-03-14 10:45:46', 'brouillon'),
(17, 3, 8, NULL, NULL, 5, 'conforme_1', 'Conforme', 'Conforme', NULL, NULL, 0, NULL, 1, '2024-03-14 06:07:57', '2024-03-14 10:50:35', 'valide'),
(18, 3, NULL, NULL, NULL, 6, 'non_conforme_1', 'Non conforme', 'Le Ministère vient de rejeter la demande', NULL, NULL, 0, NULL, 0, '2024-03-14 06:55:17', '2024-03-14 06:55:17', 'brouillon');


INSERT INTO `etat_workflows` (`id`, `workflow_id`, `type_notification_id`, `etat_suivant_id`, `etat_rejet_id`, `position`, `code`, `libelle`, `description`, `bouton_suivant`, `bouton_rejet`, `est_rejetable`, `libelle_rejet`, `est_fin`, `created_at`, `updated_at`, `status`) VALUES
(19, 4, 1, 2, NULL, 1, 'DEB', 'Brouillon', 'L\'état brouillon', 'Soumis', NULL, 0, NULL, 0, '2024-03-14 05:21:51', '2024-03-14 10:06:09', 'brouillon'),
(20, 4, 2, 3, 1, 2, 'soum', 'Soumis', 'Etat Soumis', 'Valider la conformité', 'Rejeté la demande', 1, NULL, 0, '2024-03-14 05:28:16', '2024-03-14 10:24:10', 'cours'),
(21, 4, 5, 5, 4, 3, 'complet_1', 'Complet', 'Validation au niveau MCFP/MTC', 'Valider la demande', 'Rejeter la demande', 1, NULL, 0, '2024-03-14 05:48:09', '2024-03-14 10:42:22', 'brouillon'),
(22, 4, NULL, NULL, NULL, 4, 'incomplet_1', 'Incomplet', 'Etat obtenu après une invalidation', NULL, NULL, 0, NULL, 1, '2024-03-14 05:50:52', '2024-03-14 10:45:46', 'brouillon'),
(23, 4, 8, NULL, NULL, 5, 'conforme_1', 'Conforme', 'Conforme', NULL, NULL, 0, NULL, 1, '2024-03-14 06:07:57', '2024-03-14 10:50:35', 'valide'),
(24, 4, NULL, NULL, NULL, 6, 'non_conforme_1', 'Non conforme', 'Le Ministère vient de rejeter la demande', NULL, NULL, 0, NULL, 0, '2024-03-14 06:55:17', '2024-03-14 06:55:17', 'brouillon');


INSERT INTO `etat_workflows` (`id`, `workflow_id`, `type_notification_id`, `etat_suivant_id`, `etat_rejet_id`, `position`, `code`, `libelle`, `description`, `bouton_suivant`, `bouton_rejet`, `est_rejetable`, `libelle_rejet`, `est_fin`, `created_at`, `updated_at`, `status`) VALUES
(25, 5, 1, 2, NULL, 1, 'DEB', 'Brouillon', 'L\'état brouillon', 'Soumis', NULL, 0, NULL, 0, '2024-03-14 05:21:51', '2024-03-14 10:06:09', 'brouillon'),
(26, 5, 2, 3, 1, 2, 'soum', 'Soumis', 'Etat Soumis', 'Valider la conformité', 'Rejeté la demande', 1, NULL, 0, '2024-03-14 05:28:16', '2024-03-14 10:24:10', 'cours'),
(27, 5, 5, 5, 4, 3, 'complet_1', 'Complet', 'Validation au niveau MCFP/MTC', 'Valider la demande', 'Rejeter la demande', 1, NULL, 0, '2024-03-14 05:48:09', '2024-03-14 10:42:22', 'brouillon'),
(28, 5, NULL, NULL, NULL, 4, 'incomplet_1', 'Incomplet', 'Etat obtenu après une invalidation', NULL, NULL, 0, NULL, 1, '2024-03-14 05:50:52', '2024-03-14 10:45:46', 'brouillon'),
(29, 5, 8, NULL, NULL, 5, 'conforme_1', 'Conforme', 'Conforme', NULL, NULL, 0, NULL, 1, '2024-03-14 06:07:57', '2024-03-14 10:50:35', 'valide'),
(30, 5, NULL, NULL, NULL, 6, 'non_conforme_1', 'Non conforme', 'Le Ministère vient de rejeter la demande', NULL, NULL, 0, NULL, 0, '2024-03-14 06:55:17', '2024-03-14 06:55:17', 'brouillon');


INSERT INTO `etat_workflows` (`id`, `workflow_id`, `type_notification_id`, `etat_suivant_id`, `etat_rejet_id`, `position`, `code`, `libelle`, `description`, `bouton_suivant`, `bouton_rejet`, `est_rejetable`, `libelle_rejet`, `est_fin`, `created_at`, `updated_at`, `status`) VALUES
(31, 6, 1, 2, NULL, 1, 'DEB', 'Brouillon', 'L\'état brouillon', 'Soumis', NULL, 0, NULL, 0, '2024-03-14 05:21:51', '2024-03-14 10:06:09', 'brouillon'),
(32, 6, 2, 3, 1, 2, 'soum', 'Soumis', 'Etat Soumis', 'Valider la conformité', 'Rejeté la demande', 1, NULL, 0, '2024-03-14 05:28:16', '2024-03-14 10:24:10', 'cours'),
(33, 6, 5, 5, 4, 3, 'complet_1', 'Complet', 'Validation au niveau MCFP/MTC', 'Valider la demande', 'Rejeter la demande', 1, NULL, 0, '2024-03-14 05:48:09', '2024-03-14 10:42:22', 'brouillon'),
(34, 6, NULL, NULL, NULL, 4, 'incomplet_1', 'Incomplet', 'Etat obtenu après une invalidation', NULL, NULL, 0, NULL, 1, '2024-03-14 05:50:52', '2024-03-14 10:45:46', 'brouillon'),
(35, 6, 8, NULL, NULL, 5, 'conforme_1', 'Conforme', 'Conforme', NULL, NULL, 0, NULL, 1, '2024-03-14 06:07:57', '2024-03-14 10:50:35', 'valide'),
(36, 6, NULL, NULL, NULL, 6, 'non_conforme_1', 'Non conforme', 'Le Ministère vient de rejeter la demande', NULL, NULL, 0, NULL, 0, '2024-03-14 06:55:17', '2024-03-14 06:55:17', 'brouillon');


INSERT INTO `etat_workflows` (`id`, `workflow_id`, `type_notification_id`, `etat_suivant_id`, `etat_rejet_id`, `position`, `code`, `libelle`, `description`, `bouton_suivant`, `bouton_rejet`, `est_rejetable`, `libelle_rejet`, `est_fin`, `created_at`, `updated_at`, `status`) VALUES
(37, 7, 1, 2, NULL, 1, 'DEB', 'Brouillon', 'L\'état brouillon', 'Soumis', NULL, 0, NULL, 0, '2024-03-14 05:21:51', '2024-03-14 10:06:09', 'brouillon'),
(38, 7, 2, 3, 1, 2, 'soum', 'Soumis', 'Etat Soumis', 'Valider la conformité', 'Rejeté la demande', 1, NULL, 0, '2024-03-14 05:28:16', '2024-03-14 10:24:10', 'cours'),
(39, 7, 5, 5, 4, 3, 'complet_1', 'Complet', 'Validation au niveau MCFP/MTC', 'Valider la demande', 'Rejeter la demande', 1, NULL, 0, '2024-03-14 05:48:09', '2024-03-14 10:42:22', 'brouillon'),
(40, 7, NULL, NULL, NULL, 4, 'incomplet_1', 'Incomplet', 'Etat obtenu après une invalidation', NULL, NULL, 0, NULL, 1, '2024-03-14 05:50:52', '2024-03-14 10:45:46', 'brouillon'),
(41, 7, 8, NULL, NULL, 5, 'conforme_1', 'Conforme', 'Conforme', NULL, NULL, 0, NULL, 1, '2024-03-14 06:07:57', '2024-03-14 10:50:35', 'valide'),
(42, 7, NULL, NULL, NULL, 6, 'non_conforme_1', 'Non conforme', 'Le Ministère vient de rejeter la demande', NULL, NULL, 0, NULL, 0, '2024-03-14 06:55:17', '2024-03-14 06:55:17', 'brouillon');


INSERT INTO `etat_workflows` (`id`, `workflow_id`, `type_notification_id`, `etat_suivant_id`, `etat_rejet_id`, `position`, `code`, `libelle`, `description`, `bouton_suivant`, `bouton_rejet`, `est_rejetable`, `libelle_rejet`, `est_fin`, `created_at`, `updated_at`, `status`) VALUES
(43, 8, 1, 2, NULL, 1, 'DEB', 'Brouillon', 'L\'état brouillon', 'Soumis', NULL, 0, NULL, 0, '2024-03-14 05:21:51', '2024-03-14 10:06:09', 'brouillon'),
(44, 8, 2, 3, 1, 2, 'soum', 'Soumis', 'Etat Soumis', 'Valider la conformité', 'Rejeté la demande', 1, NULL, 0, '2024-03-14 05:28:16', '2024-03-14 10:24:10', 'cours'),
(45, 8, 5, 5, 4, 3, 'complet_1', 'Complet', 'Validation au niveau MCFP/MTC', 'Valider la demande', 'Rejeter la demande', 1, NULL, 0, '2024-03-14 05:48:09', '2024-03-14 10:42:22', 'brouillon'),
(46, 8, NULL, NULL, NULL, 4, 'incomplet_1', 'Incomplet', 'Etat obtenu après une invalidation', NULL, NULL, 0, NULL, 1, '2024-03-14 05:50:52', '2024-03-14 10:45:46', 'brouillon'),
(47, 8, 8, NULL, NULL, 5, 'conforme_1', 'Conforme', 'Conforme', NULL, NULL, 0, NULL, 1, '2024-03-14 06:07:57', '2024-03-14 10:50:35', 'valide'),
(48, 8, NULL, NULL, NULL, 6, 'non_conforme_1', 'Non conforme', 'Le Ministère vient de rejeter la demande', NULL, NULL, 0, NULL, 0, '2024-03-14 06:55:17', '2024-03-14 06:55:17', 'brouillon');






INSERT INTO `permission_etat_roles` (`id`, `role_id`, `etat_workflow_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 2, 1, NULL, NULL),
(3, 4, 1, NULL, NULL),
(4, 1, 2, NULL, NULL),
(5, 2, 2, NULL, NULL),
(6, 4, 2, NULL, NULL),
(7, 1, 3, NULL, NULL),
(8, 4, 3, NULL, NULL);





INSERT INTO `role_type_notifications` (`id`, `role_id`, `type_notification_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 2, 1, NULL, NULL),
(3, 1, 2, NULL, NULL),
(4, 2, 2, NULL, NULL),
(6, 4, 2, NULL, NULL),
(7, 1, 3, NULL, NULL),
(8, 2, 3, NULL, NULL),
(9, 4, 3, NULL, NULL),
(10, 1, 4, NULL, NULL),
(11, 2, 4, NULL, NULL),
(12, 4, 4, NULL, NULL),
(13, 1, 5, NULL, NULL),
(14, 2, 5, NULL, NULL),
(15, 4, 5, NULL, NULL),
(16, 1, 6, NULL, NULL),
(17, 2, 6, NULL, NULL),
(18, 4, 6, NULL, NULL),
(19, 4, 1, NULL, NULL),
(20, 10, 2, NULL, NULL),
(21, 10, 5, NULL, NULL),
(22, 1, 7, NULL, NULL),
(23, 2, 7, NULL, NULL),
(24, 4, 7, NULL, NULL),
(25, 10, 7, NULL, NULL),
(26, 10, 8, NULL, NULL),
(27, 1, 8, NULL, NULL),
(28, 2, 8, NULL, NULL),
(29, 4, 8, NULL, NULL);



INSERT INTO `type_demandes` (`id`, `libelle`, `code`, `description`, `created_at`, `updated_at`, `type_demande_id`) VALUES
(1, 'Demande d\'ouverture d\'établissement', 'D-OUVERTURE-ETABLISSEMENT', 'Demande d\'ouverture d\'établissement', '2024-03-14 00:53:39', '2024-03-14 11:02:04', NULL),
(2, 'Demande d\'autorisation de diriger', 'D-AUTORISATION-DIRIGER', 'Demande d\'autorisation de diriger', '2024-03-14 11:52:29', '2024-03-14 11:52:29', NULL),
(3, 'Demande de qualification de filière', 'D-QUALIFICATION-FILIERE', 'Demande de qualification de filière', '2024-03-14 11:53:32', '2024-03-14 11:53:32', NULL),
(4, 'Demande de changement de dénomination', 'D-CHANGEMENT-DENOMINATION', 'Demande de changement de dénomination', '2024-03-14 11:54:58', '2024-03-14 11:54:58', NULL),
(5, 'Demande de reconnaissance', 'D-RECONNAISSANCE', 'D-RECONNAISSANCE', '2024-03-14 11:55:38', '2024-03-14 11:55:38', NULL),
(6, 'Demande de subvention', 'D-SUBVENTION', 'D-SUBVENTION', '2024-03-14 11:56:23', '2024-03-14 11:56:23', NULL),
(7, 'Demande de transfert d\'un établissement', 'D-TRANSFERT-ETABLISSEMENT', 'Demande de transfert d\'un établissement', '2024-03-14 11:57:33', '2024-03-14 11:57:33', NULL),
(8, 'Demande d\'extension de filières', 'D-EXTENSION-FILIERE', 'D-EXTENSION-FILIERE', '2024-03-14 11:58:18', '2024-03-14 11:58:48', NULL);




INSERT INTO `type_notifications` (`id`, `action`, `message`, `created_at`, `updated_at`) VALUES
(1, 'Nouvelle demande en brouillon', 'Une nouvelle demande vient d\'être ajouté. Elle est à l\'état brouillon.', '2024-03-14 06:10:49', '2024-03-14 06:10:49'),
(2, 'Demande soumise', 'Une demande vient d\'être soumise', '2024-03-14 06:11:43', '2024-03-14 06:11:43'),
(3, 'Rejet des informations fournies', 'Les informations fournies ont été rejetées', '2024-03-14 06:13:26', '2024-03-14 06:47:42'),
(4, 'Validation des informations fournies', 'Les informations fournies n\'ont pas pu être validées', '2024-03-14 06:16:09', '2024-03-14 06:16:09'),
(5, 'Validé par le ministère', 'Le Ministère vient de valider cette demande.', '2024-03-14 06:17:58', '2024-03-14 06:17:58'),
(6, 'Demande de complément', 'Votre demande nécessite des informations supplémentaires', '2024-03-14 06:18:39', '2024-03-14 06:18:39'),
(7, 'Demande rejetée', 'Votre demande après évaluation a été rejetée.', '2024-03-14 06:19:14', '2024-03-14 06:19:14'),
(8, 'Demande acceptée', 'Votre demande a été validée et approuvée.', '2024-03-14 06:20:20', '2024-03-14 06:20:20');



INSERT INTO `workflows` (`id`, `code`, `libelle`, `description`, `estActif`, `type_demande_id`, `created_at`, `updated_at`) VALUES
(1, 'P-OUVERTURE-ETABLISSEMENT', 'Processus demande d\'ouverture d\'tablissement', 'Le processus de demande d\'ouverture consiste à valider un établissement qui souhaite être enregistré', 1, 1, '2024-03-14 05:14:58', '2024-03-14 11:02:47'),
(2, 'P-AUTORISATION-DIRIGER', 'Processus demande d\'autorisation de diriger', 'Processus demande d\'autorisation de diriger', 1, 2, '2024-03-14 12:00:42', '2024-03-14 12:00:42'),
(3, 'P-QUALIFIQUATION-FILIERE', 'Processus demande de qualification de filière', 'Processus demande de qualification de filière', 1, 3, '2024-03-14 12:01:31', '2024-03-14 12:01:31'),
(4, 'P-QUALIFICATION-DENOMINATION', 'Processus demande de changement de dénomination', 'Processus demande de changement de dénomination', 1, 4, '2024-03-14 12:02:12', '2024-03-14 12:02:12'),
(5, 'P-DEMANDE-RECONNAISSANCE', 'Processus de demande de reconnaissance', 'Processus de demande de reconnaissance', 1, 5, '2024-03-14 12:03:28', '2024-03-14 12:03:28'),
(6, 'P-DEMANDE-SUBVENTION', 'Processus de demande de subvention', 'Processus de demande de subvention', 1, 6, '2024-03-14 12:04:16', '2024-03-14 12:04:16'),
(7, 'P-DEMANDE-TRANSFERT-ETABLISSEMENT', 'Processus de demande de transfert d\'un établissement', 'Processus de demande de transfert d\'un établissement', 1, 7, '2024-03-14 12:04:59', '2024-03-14 12:04:59'),
(8, 'P-EXTENSION-FILIERE', 'Processus de demande d\'extension de filières', 'Processus de demande d\'extension de filières', 1, 8, '2024-03-14 12:05:50', '2024-03-14 12:05:50');


