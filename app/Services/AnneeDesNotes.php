<?php

namespace App\Services;

use App\Models\AnneeAcademique;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Année académique des notes (évaluations PPO, compositions et sommations APC).
 *
 * Ces tables portent une colonne annee_academique_id (migration
 * 2026_09_26_000001). Tant que la migration n'est pas passée, toutes les notes en
 * base sont considérées de l'année « annee_notes » (constants.php) : le tableau de
 * bord et la saisie fonctionnent donc avant comme après la migration.
 */
class AnneeDesNotes
{
    /** @var array<string, bool> */
    private static array $colonnes = [];

    private static int|null|false $anneeParDefaut = false;

    public static function aUneColonne(string $table): bool
    {
        return self::$colonnes[$table] ??= Schema::hasColumn($table, 'annee_academique_id');
    }

    /**
     * Année des notes sans colonne d'année, et année utilisée par défaut tant qu'aucune n'est
     * choisie (constants.annee_notes = 2025-2026).
     */
    public static function anneeParDefaut(): ?int
    {
        if (self::$anneeParDefaut === false) {
            self::$anneeParDefaut = AnneeAcademique::where('code', config('constants.annee_notes'))->value('id');
        }

        return self::$anneeParDefaut;
    }

    /**
     * Restreint une requête sur une table de notes à l'année demandée.
     * Retourne false quand il n'existe aucune note pour cette année (la requête
     * est alors inutile) ; à appeler avant d'exécuter la requête.
     *
     * @param \Illuminate\Database\Query\Builder $requete
     */
    public static function restreindre($requete, string $table, string $alias, int $anneeId): bool
    {
        if (self::aUneColonne($table)) {
            $requete->where("$alias.annee_academique_id", $anneeId);

            return true;
        }

        return self::anneeParDefaut() === $anneeId;
    }

    /**
     * Attributs à ajouter à l'enregistrement pour y inscrire son année (vide avant la
     * migration). La clé est toujours présente quand la colonne existe : indispensable
     * pour les insertions groupées.
     */
    public static function attributs(string $table, ?int $anneeId): array
    {
        return self::aUneColonne($table) ? ['annee_academique_id' => $anneeId ?: null] : [];
    }

    /**
     * Année académique courante : celle de la requête ou de la session (partagée avec
     * les pages d'assignation et de saisie), à défaut l'année ouverte.
     */
    public static function courante(?\Illuminate\Http\Request $request = null): ?int
    {
        $id = $request?->filled('annee_academique_id')
            ? $request->input('annee_academique_id')
            : session('annee_academique_id');

        // Tant qu'aucune année n'est choisie : 2025-2026 (constants.annee_notes), et non l'année ouverte.
        return $id ? (int) $id : (self::anneeParDefaut()
            ?? AnneeAcademique::where('is_open', true)->value('id')
            ?? AnneeAcademique::orderByDesc('annee1')->value('id'));
    }

    /** Année choisie en session ; à défaut, l'année par défaut (2025-2026). Pour les écrans à sélecteur d'année. */
    public static function choisie(): string
    {
        return (string) (session('annee_academique_id') ?: self::anneeParDefaut());
    }

    /**
     * Année dont on imprime les bulletins d'une classe. Une classe est réutilisée d'une
     * année à l'autre : on retient l'année demandée ou sélectionnée si la classe y a des
     * inscrits, sinon la plus récente. On n'utilise pas aveuglément l'année ouverte, qui
     * viderait les bulletins d'une année déjà terminée.
     */
    public static function pourClasse(int $classeId, ?\Illuminate\Http\Request $request = null): ?int
    {
        $annees = DB::table('inscriptions')->where('classe_id', $classeId)
            ->whereNotNull('annee_academique_id')->distinct()->pluck('annee_academique_id')->map(fn ($a) => (int) $a)->all();
        $demandee = $request?->input('annee_academique_id') ?? session('annee_academique_id');

        if ($demandee && in_array((int) $demandee, $annees, true)) {
            return (int) $demandee;
        }

        return $annees ? max($annees) : self::courante($request);
    }
}
