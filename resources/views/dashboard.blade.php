@php
  // Icônes des indicateurs (Heroicons outline, viewBox 24)
  $icones = [
    'building'     => 'M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z',
    'academic-cap' => 'M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5',
    'collection'   => 'M6 6.878V6a2.25 2.25 0 012.25-2.25h7.5A2.25 2.25 0 0118 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 004.5 9v.878m13.5-3A2.25 2.25 0 0119.5 9v.878m0 0a2.246 2.246 0 00-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0121 12v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6c0-.98.626-1.813 1.5-2.122',
    'briefcase'    => 'M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0',
    'wrench'       => 'M21.75 6.75a4.5 4.5 0 01-4.884 4.484c-1.076-.091-2.264.071-2.95.904l-7.152 8.684a2.548 2.548 0 11-3.586-3.586l8.684-7.152c.833-.686.995-1.874.904-2.95a4.5 4.5 0 016.336-4.486l-3.276 3.276a3.004 3.004 0 002.25 2.25l3.276-3.276c.256.565.398 1.192.398 1.852z',
    'users'        => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z',
    'book'         => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25',
    'chart'        => 'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z',
    'clock'        => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z',
  ];
  $charts = $dashboard['charts'];
@endphp

<x-app-layout>
  <x-slot name="header"></x-slot>

  <style>
    .dbx { --dbx-surface:#fff; --dbx-ink:#0b0b0b; --dbx-ink2:#52514e; --dbx-muted:#8a8984; --dbx-line:#e6e5e1; --dbx-grid:#efeeeb;
           --dbx-orange:#E38E18; --dbx-green:#068F7D;
           --dbx-s1:#E38E18; --dbx-s2:#068F7D; --dbx-s3:#2a78d6; --dbx-s4:#e87ba4; --dbx-s5:#4a3aa7; --dbx-s6:#e34948;
           padding:1rem; color:var(--dbx-ink); }
    .dark .dbx { --dbx-surface:#1a1a19; --dbx-ink:#fff; --dbx-ink2:#c3c2b7; --dbx-muted:#8f8e86; --dbx-line:#33332f; --dbx-grid:#2a2a28;
                 --dbx-s1:#E38E18; --dbx-s2:#068F7D; --dbx-s3:#3987e5; --dbx-s4:#d55181; --dbx-s5:#9085e9; --dbx-s6:#e66767; }
    .dbx-head { display:flex; flex-wrap:wrap; gap:.75rem 1.5rem; align-items:flex-end; justify-content:space-between; margin-bottom:1rem; }
    .dbx-head h2 { font-size:1.35rem; font-weight:700; line-height:1.2; margin:0; }
    .dbx-head p { color:var(--dbx-ink2); font-size:.875rem; margin:.15rem 0 0; }
    .dbx-year { display:flex; align-items:center; gap:.5rem; font-size:.875rem; color:var(--dbx-ink2); }
    .dbx-year select { background:var(--dbx-surface); color:var(--dbx-ink); border:1px solid var(--dbx-line); border-radius:.5rem; padding:.4rem 2rem .4rem .75rem; font-size:.875rem; }
    .dbx-kpis { display:grid; gap:1rem; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); margin-bottom:1rem; }
    .dbx-card { background:var(--dbx-surface); border:1px solid var(--dbx-line); border-radius:.75rem; }
    .dbx-kpi { display:flex; align-items:center; gap:.9rem; padding:1rem 1.1rem; text-decoration:none; color:inherit; transition:box-shadow .15s, border-color .15s; }
    a.dbx-kpi:hover { box-shadow:0 2px 10px rgba(0,0,0,.08); border-color:var(--dbx-muted); }
    .dbx-kpi .chip { width:2.75rem; height:2.75rem; border-radius:.75rem; display:grid; place-items:center; flex:none; color:#fff; }
    .dbx-kpi .chip svg { width:1.4rem; height:1.4rem; }
    .dbx-kpi .lbl { font-size:.8rem; color:var(--dbx-ink2); line-height:1.25; }
    .dbx-kpi .val { font-size:1.6rem; font-weight:700; line-height:1.15; font-variant-numeric:tabular-nums; }
    .dbx-kpi .more { font-size:.7rem; color:var(--dbx-muted); }
    .dbx-grid { display:grid; gap:1rem; grid-template-columns:1fr; }
    @media (min-width:1024px){ .dbx-grid { grid-template-columns:repeat(2,minmax(0,1fr)); } .dbx-span2 { grid-column:span 2; } }
    .dbx-chart { padding:1rem 1.1rem 1.1rem; min-width:0; }
    .dbx-chart header { display:flex; justify-content:space-between; align-items:center; gap:.5rem; margin-bottom:.75rem; }
    .dbx-chart h3 { font-size:.95rem; font-weight:600; margin:0; }
    .dbx-toggle { font-size:.75rem; color:var(--dbx-ink2); background:transparent; border:1px solid var(--dbx-line); border-radius:.4rem; padding:.2rem .55rem; cursor:pointer; white-space:nowrap; }
    .dbx-toggle:hover { color:var(--dbx-ink); border-color:var(--dbx-muted); }
    .dbx-canvas { position:relative; }
    .dbx-table { width:100%; border-collapse:collapse; font-size:.85rem; display:none; }
    .dbx-table th, .dbx-table td { text-align:left; padding:.35rem .5rem; border-bottom:1px solid var(--dbx-line); }
    .dbx-table td:not(:first-child), .dbx-table th:not(:first-child) { text-align:right; font-variant-numeric:tabular-nums; }
    .dbx-table th { color:var(--dbx-ink2); font-weight:600; }
    .dbx-chart.as-table .dbx-canvas { display:none; }
    .dbx-chart.as-table .dbx-table { display:table; }
    .dbx-scroll { display:none; }
    .dbx-chart.as-table .dbx-scroll { display:block; }
    .dbx-pager { display:flex; align-items:center; justify-content:space-between; gap:.75rem; margin-top:.75rem; font-size:.8rem; color:var(--dbx-ink2); }
    .dbx-pager .btns { display:flex; align-items:center; gap:.4rem; }
    .dbx-pager button { font-size:.8rem; color:var(--dbx-ink2); background:transparent; border:1px solid var(--dbx-line); border-radius:.4rem; padding:.25rem .65rem; cursor:pointer; }
    .dbx-pager button:hover:not(:disabled) { color:var(--dbx-ink); border-color:var(--dbx-muted); }
    .dbx-pager button:disabled { opacity:.4; cursor:default; }
    .dbx-chart.as-table .dbx-pager { display:none; }
    .dbx-scroll { max-height:26rem; overflow:auto; }
    .dbx-saisie { margin-top:1rem; padding:1rem 1.1rem 1.1rem; }
    .dbx-saisie h3 { font-size:.95rem; font-weight:600; margin:0 0 .15rem; }
    .dbx-saisie .sub { font-size:.8rem; color:var(--dbx-ink2); margin:0 0 .85rem; }
    .dbx-sum { display:grid; gap:.75rem; grid-template-columns:repeat(auto-fit,minmax(150px,1fr)); margin-bottom:.9rem; }
    .dbx-sum div { border:1px solid var(--dbx-line); border-radius:.6rem; padding:.55rem .8rem; }
    .dbx-sum b { display:block; font-size:1.3rem; font-variant-numeric:tabular-nums; }
    .dbx-sum span { font-size:.75rem; color:var(--dbx-ink2); }
    .dbx-tabs { display:flex; flex-wrap:wrap; gap:.4rem; margin-bottom:.75rem; }
    .dbx-tabs button { font-size:.8rem; color:var(--dbx-ink2); background:transparent; border:1px solid var(--dbx-line); border-radius:999px; padding:.25rem .8rem; cursor:pointer; }
    .dbx-tabs button[aria-pressed=true] { color:#fff; background:var(--dbx-green); border-color:var(--dbx-green); }
    .dbx-st { width:100%; border-collapse:collapse; font-size:.85rem; }
    .dbx-st th, .dbx-st td { text-align:left; padding:.5rem .5rem; border-bottom:1px solid var(--dbx-line); vertical-align:middle; }
    .dbx-st th { color:var(--dbx-ink2); font-weight:600; font-size:.78rem; }
    .dbx-st .prog { min-width:150px; }
    .dbx-bar { height:.45rem; border-radius:999px; background:var(--dbx-grid); overflow:hidden; margin-top:.25rem; }
    .dbx-bar i { display:block; height:100%; background:var(--dbx-orange); border-radius:999px; }
    .dbx-bar i.ok { background:var(--dbx-green); }
    .dbx-st small { color:var(--dbx-ink2); }
    .dbx-badge { display:inline-block; font-size:.72rem; font-weight:600; padding:.1rem .55rem; border-radius:999px; border:1px solid var(--dbx-line); color:var(--dbx-ink2); white-space:nowrap; }
    .dbx-badge.ok { color:#fff; background:var(--dbx-green); border-color:var(--dbx-green); }
    .dbx-saisie .dbx-none { display:none; padding:1.2rem; text-align:center; color:var(--dbx-ink2); }
    .dbx-empty { padding:2rem; text-align:center; color:var(--dbx-ink2); }
  </style>

  <div class="dbx">
    <div class="dbx-head">
      <div>
        <h2>{{ $dashboard['titre'] }}</h2>
        @if($dashboard['sous_titre'])<p>{{ $dashboard['sous_titre'] }}</p>@endif
      </div>
      @if(count($dashboard['annees']) > 0)
        <form method="GET" action="{{ route('dashboard') }}" class="dbx-year">
          <label for="dbx-annee">Année académique</label>
          <select id="dbx-annee" name="annee" onchange="this.form.submit()">
            @foreach($dashboard['annees'] as $a)
              <option value="{{ $a['id'] }}" @selected($a['id'] == $dashboard['annee_id'])>{{ $a['code'] }}</option>
            @endforeach
          </select>
        </form>
      @endif
    </div>

    @if(empty($dashboard['kpis']) && empty($charts))
      <div class="dbx-card dbx-empty">Aucune statistique n'est disponible pour votre profil pour le moment.</div>
    @endif

    {{-- Indicateurs clés --}}
    <div class="dbx-kpis">
      @foreach($dashboard['kpis'] as $i => $kpi)
        @php $couleur = $kpi['couleur'] === 'green' ? 'var(--dbx-green)' : 'var(--dbx-orange)'; @endphp
        @if($kpi['modal'])
          <a href="#" class="dbx-card dbx-kpi" data-modal-target="dbx-modal-{{ $i }}" data-modal-toggle="dbx-modal-{{ $i }}">
        @else
          <div class="dbx-card dbx-kpi">
        @endif
            <span class="chip" style="background:{{ $couleur }}">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $icones[$kpi['icone']] ?? $icones['chart'] }}"/></svg>
            </span>
            <span>
              <span class="lbl" style="display:block">{{ $kpi['label'] }}</span>
              <span class="val" style="display:block">{{ $kpi['valeur'] }}</span>
              @if($kpi['modal'])<span class="more">Voir le détail</span>@endif
            </span>
        @if($kpi['modal'])
          </a>
        @else
          </div>
        @endif
      @endforeach
    </div>

    @if(!empty($dashboard['kpis']) && empty($charts))
      <div class="dbx-card dbx-empty">Pas encore assez de données pour afficher des graphiques{{ $dashboard['annee_id'] ? ' sur cette année académique' : '' }}.</div>
    @endif

    {{-- Graphiques --}}
    <div class="dbx-grid">
      @foreach($charts as $chart)
        <section class="dbx-card dbx-chart {{ ($chart['span'] ?? 1) === 2 ? 'dbx-span2' : '' }}" data-chart="{{ $chart['id'] }}">
          <header>
            <h3>{{ $chart['titre'] }}</h3>
            <button type="button" class="dbx-toggle" aria-pressed="false">Voir en tableau</button>
          </header>
          <div class="dbx-canvas"><canvas role="img" aria-label="{{ $chart['titre'] }}"></canvas></div>
          @if(!empty($chart['par_page']) && count($chart['labels']) > $chart['par_page'])
            <div class="dbx-pager">
              <span class="dbx-range" aria-live="polite"></span>
              <span class="btns">
                <button type="button" class="dbx-prev">‹ Précédent</button>
                <span class="dbx-pageno"></span>
                <button type="button" class="dbx-next">Suivant ›</button>
              </span>
            </div>
          @endif
          <div class="dbx-scroll"><table class="dbx-table"></table></div>
        </section>
      @endforeach
    </div>

    {{-- Saisie des devoirs et des compositions (national / IA) : chargée après l'affichage de la page --}}
    @if(!empty($dashboard['saisie_url']))
      <section class="dbx-card dbx-saisie" id="dbx-saisie" data-url="{{ $dashboard['saisie_url'] }}">
        <h3>Saisie des devoirs et des notes de composition par établissement</h3>
        <p class="sub" data-etat>Chargement en cours…</p>
      </section>
    @endif
  </div>

  {{-- Fenêtres de détail (listes Livewire chargées à l'ouverture) --}}
  @foreach($dashboard['kpis'] as $i => $kpi)
    @if($kpi['modal'])
      <div id="dbx-modal-{{ $i }}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
           class="bg-slate-800 bg-opacity-70 hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-2 w-11/12 md:w-3/4 mx-auto max-h-full">
          <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
              <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $kpi['modal']['titre'] }}</h3>
              <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="dbx-modal-{{ $i }}">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                <span class="sr-only">Fermer</span>
              </button>
            </div>
            <div class="p-4 md:p-5 space-y-4">
              @if($kpi['modal']['globale'])
                <p class="text-sm text-gray-500 dark:text-gray-400">Liste complète, indépendante de l'année académique sélectionnée sur le tableau de bord.</p>
              @endif
              @livewire($kpi['modal']['component'], ['lazy' => true], key('dbx-livewire-' . $i))
            </div>
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
              <button data-modal-hide="dbx-modal-{{ $i }}" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Fermer</button>
            </div>
          </div>
        </div>
      </div>
    @endif
  @endforeach

  @push('myJS')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
      (function () {
        const CHARTS = @json($charts);
        const fmt = (v, f) => v == null ? '—' : Number(v).toLocaleString('fr-FR', f === 'note' ? { minimumFractionDigits: 0, maximumFractionDigits: 2 } : f === 'pct' ? { maximumFractionDigits: 1 } : { maximumFractionDigits: 0 }) + (f === 'pct' ? ' %' : '');
        const flat = l => Array.isArray(l) ? l.join(' ') : l;
        const short = (s, n = 30) => Array.isArray(s) ? s : ((s || '').length > n ? s.slice(0, n - 1) + '…' : s);
        const instances = [];

        function tokens(el) {
          const cs = getComputedStyle(el), g = n => cs.getPropertyValue(n).trim();
          return {
            surface: g('--dbx-surface'), ink: g('--dbx-ink'), ink2: g('--dbx-ink2'), grid: g('--dbx-grid'), line: g('--dbx-line'),
            series: [1, 2, 3, 4, 5, 6].map(i => g('--dbx-s' + i)),
          };
        }

        // Total au centre des diagrammes circulaires
        const centerTotal = {
          id: 'centerTotal',
          afterDraw(chart, _a, opts) {
            if (chart.config.type !== 'doughnut') return;
            const meta = chart.getDatasetMeta(0); if (!meta.data.length) return;
            const { x, y } = meta.data[0], ctx = chart.ctx;
            const total = chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
            ctx.save(); ctx.textAlign = 'center'; ctx.textBaseline = 'middle';
            ctx.fillStyle = opts.ink; ctx.font = '700 22px sans-serif'; ctx.fillText(fmt(total), x, y - 8);
            ctx.fillStyle = opts.ink2; ctx.font = '12px sans-serif'; ctx.fillText('Total', x, y + 14);
            ctx.restore();
          },
        };

        // Tranche de données affichée (pagination des graphiques à nombreuses lignes)
        function pageView(def) {
          if (!def.par_page) return { labels: def.labels, data: def.datasets.map(d => d.data) };
          const a = (def._page || 0) * def.par_page, b = a + def.par_page;
          return { labels: def.labels.slice(a, b), data: def.datasets.map(d => d.data.slice(a, b)) };
        }

        function build(section, def) {
          const view = pageView(def);
          const t = tokens(section);
          const canvas = section.querySelector('canvas'), wrap = section.querySelector('.dbx-canvas');
          const isDonut = def.type === 'doughnut', isH = def.type === 'hbar', multi = def.datasets.length > 1;
          const isNote = def.format === 'note';

          const rows = def.par_page ? Math.min(def.par_page, def.labels.length) : def.labels.length;
          wrap.style.height = isDonut ? '280px' : isH ? Math.max(220, rows * 30 + 50) + 'px' : '280px';

          const datasets = def.datasets.map((d, i) => isDonut ? {
            label: d.label, data: view.data[i],
            backgroundColor: view.data[i].map((_, k) => t.series[k % 6]),
            borderColor: t.surface, borderWidth: 2, hoverOffset: 6,
          } : {
            label: d.label, data: view.data[i], backgroundColor: t.series[i % 6],
            borderRadius: isH ? { topRight: 4, bottomRight: 4 } : { topLeft: 4, topRight: 4 },
            borderSkipped: false, maxBarThickness: isH ? 18 : 40,
          });

          const cfg = {
            type: isDonut ? 'doughnut' : 'bar',
            data: { labels: view.labels, datasets },
            plugins: isDonut ? [centerTotal] : [],
            options: {
              responsive: true, maintainAspectRatio: false, animation: { duration: 400 },
              indexAxis: isH ? 'y' : 'x',
              cutout: isDonut ? '62%' : undefined,
              layout: { padding: isDonut ? 4 : 0 },
              plugins: {
                centerTotal: { ink: t.ink, ink2: t.ink2 },
                legend: { display: isDonut || multi || !!def.legende, position: isDonut ? 'right' : 'bottom',
                  labels: { color: t.ink2, usePointStyle: true, pointStyle: 'rectRounded', boxWidth: 10, padding: 14 } },
                tooltip: {
                  callbacks: {
                    label(c) {
                      const v = c.parsed.y !== undefined && !isH ? c.parsed.y : (isH ? c.parsed.x : c.parsed);
                      if (isDonut) {
                        const tot = c.dataset.data.reduce((a, b) => a + b, 0);
                        return ` ${c.label} : ${fmt(v)} (${Math.round(v * 100 / tot)} %)`;
                      }
                      const n = def.datasets[c.datasetIndex].counts;
                      return ` ${c.dataset.label} : ${fmt(v, def.format)}` + (n ? ` (${fmt(n[(def._page || 0) * (def.par_page || 0) + c.dataIndex])} apprenants)` : '');
                    },
                  },
                },
              },
              scales: isDonut ? {} : {
                [isH ? 'y' : 'x']: { grid: { display: false }, border: { color: t.line },
                  ticks: { color: t.ink2, callback(v) { return short(this.getLabelForValue(v), isH ? 34 : 18); } } },
                [isH ? 'x' : 'y']: { beginAtZero: true, max: isNote ? 20 : (def.format === 'pct' && def.par_page ? 100 : undefined), border: { display: false },
                  grid: { color: t.grid }, ticks: { color: t.ink2, precision: 0, callback: v => fmt(v, def.format) } },
              },
            },
          };
          canvas.getContext('2d');
          instances.push({ chart: new Chart(canvas, cfg), section, def });
        }

        function table(section, def) {
          const tbl = section.querySelector('.dbx-table');
          const head = '<tr><th></th>' + def.datasets.map(d => `<th>${d.label}</th>`).join('') + '</tr>';
          const rows = def.labels.map((l, i) => `<tr><td>${flat(l)}</td>` + def.datasets.map(d => `<td>${fmt(d.data[i], def.format)}</td>`).join('') + '</tr>').join('');
          tbl.innerHTML = head + rows;
        }

        function pager(section, def) {
          const bar = section.querySelector('.dbx-pager');
          if (!bar) return;
          const pages = Math.ceil(def.labels.length / def.par_page);
          const prev = bar.querySelector('.dbx-prev'), next = bar.querySelector('.dbx-next');
          const refresh = () => {
            const p = def._page || 0, a = p * def.par_page;
            bar.querySelector('.dbx-range').textContent = `${a + 1}–${Math.min(a + def.par_page, def.labels.length)} sur ${def.labels.length}`;
            bar.querySelector('.dbx-pageno').textContent = `Page ${p + 1} / ${pages}`;
            prev.disabled = p === 0; next.disabled = p >= pages - 1;
          };
          const go = d => {
            def._page = Math.min(pages - 1, Math.max(0, (def._page || 0) + d));
            const inst = instances.find(i => i.def === def), view = pageView(def);
            inst.chart.data.labels = view.labels;
            inst.chart.data.datasets.forEach((ds, i) => ds.data = view.data[i]);
            inst.chart.update();
            refresh();
          };
          prev.addEventListener('click', () => go(-1));
          next.addEventListener('click', () => go(1));
          refresh();
        }

        // Tableau de saisie : filtre (complets S1 / S2 / les deux) et pagination
        function chargerSaisie() {
          const box = document.getElementById('dbx-saisie');
          if (!box) return;
          fetch(box.dataset.url, { headers: { Accept: 'application/json' }, credentials: 'same-origin' })
            .then(r => r.ok ? r.json() : Promise.reject(r.status))
            .then(d => {
              if (!d.html) { box.remove(); return; }
              box.innerHTML = d.html;
              saisie();
            })
            .catch(() => { const e = box.querySelector('[data-etat]'); if (e) e.textContent = 'Impossible de charger cet indicateur pour le moment. Rechargez la page pour réessayer.'; });
        }

        function saisie() {
          const box = document.getElementById('dbx-saisie');
          if (!box) return;
          const rows = [...box.querySelectorAll('tbody tr')], PER = 10;
          let filtre = 'all', page = 0;
          const match = r => filtre === 'all' || (filtre === 'both' ? r.dataset.s1 === '1' && r.dataset.s2 === '1' : r.dataset[filtre] === '1');
          const render = () => {
            const ok = rows.filter(match), pages = Math.max(1, Math.ceil(ok.length / PER));
            page = Math.min(page, pages - 1);
            rows.forEach(r => r.hidden = true);
            ok.slice(page * PER, page * PER + PER).forEach(r => r.hidden = false);
            box.querySelector('.dbx-none').style.display = ok.length ? 'none' : 'block';
            box.querySelector('.dbx-range').textContent = ok.length ? `${page * PER + 1}–${Math.min((page + 1) * PER, ok.length)} sur ${ok.length}` : '';
            box.querySelector('.dbx-pageno').textContent = `Page ${page + 1} / ${pages}`;
            box.querySelector('.dbx-prev').disabled = page === 0;
            box.querySelector('.dbx-next').disabled = page >= pages - 1;
            box.querySelector('.dbx-pager').style.display = ok.length > PER ? 'flex' : 'none';
          };
          box.querySelectorAll('.dbx-tabs button').forEach(b => b.addEventListener('click', () => {
            filtre = b.dataset.f; page = 0;
            box.querySelectorAll('.dbx-tabs button').forEach(x => x.setAttribute('aria-pressed', x === b));
            render();
          }));
          box.querySelector('.dbx-prev').addEventListener('click', () => { page--; render(); });
          box.querySelector('.dbx-next').addEventListener('click', () => { page++; render(); });
          render();
        }

        function init() {
          chargerSaisie();
          if (!window.Chart) return;
          CHARTS.forEach(def => {
            const section = document.querySelector('.dbx-chart[data-chart="' + def.id + '"]');
            if (!section) return;
            build(section, def); table(section, def); pager(section, def);
            const btn = section.querySelector('.dbx-toggle');
            btn.addEventListener('click', () => {
              const on = section.classList.toggle('as-table');
              btn.textContent = on ? 'Voir le graphique' : 'Voir en tableau';
              btn.setAttribute('aria-pressed', on);
            });
          });

          // Rebuild quand le thème clair/sombre change (les couleurs viennent des variables CSS)
          let last = tokens(document.querySelector('.dbx')).ink, timer;
          new MutationObserver(() => {
            clearTimeout(timer);
            timer = setTimeout(() => {
              const now = tokens(document.querySelector('.dbx')).ink;
              if (now === last) return; last = now;
              instances.splice(0).forEach(i => { i.chart.destroy(); build(i.section, i.def); });
            }, 100);
          }).observe(document.documentElement, { attributes: true, subtree: true, attributeFilter: ['class'] });
        }

        document.readyState === 'loading' ? document.addEventListener('DOMContentLoaded', init) : init();
      })();
    </script>
  @endpush
</x-app-layout>
