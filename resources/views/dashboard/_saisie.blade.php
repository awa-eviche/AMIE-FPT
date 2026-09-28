@php
  $r = $saisie['resume'];
  $pct = fn ($v) => rtrim(rtrim(number_format($v, 1, ',', ''), '0'), ',');
@endphp
<h3>Saisie des devoirs et des notes de composition par établissement</h3>
<p class="sub">
  Un établissement est complet quand chaque inscrit de toutes ses classes a ses notes pour chaque élément attendu.
  <strong>PPO</strong> : matières affectées à la classe pour l'année (à défaut, celles de son niveau).
  <strong>APC</strong> : ressources des compétences générales de la classe (compétences affectées pour l'année, à défaut toutes).
  Devoirs : au moins un devoir noté. Composition : une note de composition. Les notes prises en compte sont celles de l'année académique sélectionnée.
</p>

<div class="dbx-sum">
  <div><b>{{ $r['composition_les_deux'] }} / {{ $r['etablissements'] }}</b><span>composition complète S1 + S2</span></div>
  <div><b>{{ $r['composition_s1'] }} / {{ $r['etablissements'] }}</b><span>composition complète S1</span></div>
  <div><b>{{ $r['composition_s2'] }} / {{ $r['etablissements'] }}</b><span>composition complète S2</span></div>
  <div><b>{{ $r['devoirs_s1'] }} / {{ $r['etablissements'] }}</b><span>devoirs complets S1</span></div>
  <div><b>{{ $r['devoirs_s2'] }} / {{ $r['etablissements'] }}</b><span>devoirs complets S2</span></div>
</div>

<div class="dbx-tabs" role="group" aria-label="Filtrer les établissements">
  <button type="button" data-f="all" aria-pressed="true">Tous ({{ $r['etablissements'] }})</button>
  <button type="button" data-f="both" aria-pressed="false">Composition complète S1 et S2 ({{ $r['composition_les_deux'] }})</button>
  <button type="button" data-f="s1" aria-pressed="false">Composition S1 ({{ $r['composition_s1'] }})</button>
  <button type="button" data-f="s2" aria-pressed="false">Composition S2 ({{ $r['composition_s2'] }})</button>
</div>

<div style="overflow-x:auto">
  <table class="dbx-st">
    <thead>
      <tr>
        <th rowspan="2">Établissement</th><th rowspan="2">Classes</th>
        <th colspan="2">Devoirs</th><th colspan="2">Composition</th><th rowspan="2">Statut</th>
      </tr>
      <tr><th>Semestre 1</th><th>Semestre 2</th><th>Semestre 1</th><th>Semestre 2</th></tr>
    </thead>
    <tbody>
      @foreach($saisie['lignes'] as $l)
        <tr data-s1="{{ $l['composition']['s1']['complet'] ? 1 : 0 }}" data-s2="{{ $l['composition']['s2']['complet'] ? 1 : 0 }}">
          <td>{{ $l['nom'] }}</td>
          <td>{{ $l['classes'] }}<br><small>{{ $l['ppo'] }} PPO · {{ $l['apc'] }} APC</small>
            @if($l['sans_attendu'])<br><small title="Aucune matière ni ressource attendue pour ces classes : elles ne peuvent pas être validées">dont {{ $l['sans_attendu'] }} sans élément attendu</small>@endif
          </td>
          @foreach(['devoirs', 'composition'] as $type)
            @foreach(['s1', 's2'] as $sem)
              @php $c = $l[$type][$sem]; @endphp
              <td class="prog">
                {{ $pct($c['pct']) }} % <small>· {{ $c['ok'] }}/{{ $l['classes'] }} cl.</small>
                <div class="dbx-bar" role="img" aria-label="{{ $c['pct'] }} % saisi"><i class="{{ $c['complet'] ? 'ok' : '' }}" style="width:{{ min(100, $c['pct']) }}%"></i></div>
              </td>
            @endforeach
          @endforeach
          <td>
            @if($l['composition']['s1']['complet'] && $l['composition']['s2']['complet'])<span class="dbx-badge ok">Composition complète</span>
            @elseif($l['composition']['s1']['complet'])<span class="dbx-badge ok">Composition S1 complète</span>
            @elseif($l['composition']['s2']['complet'])<span class="dbx-badge ok">Composition S2 complète</span>
            @else<span class="dbx-badge">Incomplet</span>@endif
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
<p class="dbx-none">Aucun établissement n'a complètement saisi les notes de composition pour ce filtre. Choisissez « Tous » pour voir l'avancement de chacun.</p>

<div class="dbx-pager">
  <span class="dbx-range" aria-live="polite"></span>
  <span class="btns">
    <button type="button" class="dbx-prev">‹ Précédent</button>
    <span class="dbx-pageno"></span>
    <button type="button" class="dbx-next">Suivant ›</button>
  </span>
</div>
