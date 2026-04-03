<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>MEFPT-GOFOP - Dashboard</title>

  <!-- Fonts & styles -->
  <link href="{{ asset('asset/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet" />
  <link href="{{ asset('asset/css/sb-admin-2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('asset/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />

  <!-- Export libs -->
  <script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js" defer></script>

  <!-- Chart.js + datalabels -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2" defer></script>

  <style>
    .chart-container {
      position: relative;
      width: 100%;
      background: #fff;
      border-radius: 6px;
    }
    .card-chart {
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 20px rgba(0,0,0,.08);
      transition: transform .3s ease, box-shadow .3s ease;
    }
    .card-chart:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 28px rgba(0,0,0,.12);
    }
    .card-chart .card-header {
      border-radius: 10px 10px 0 0 !important;
      background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
      border-bottom: 1px solid rgba(0,0,0,.06);
    }
    .kpi-card {
      border: none;
      border-radius: 8px;
      box-shadow: 0 2px 15px rgba(0,0,0,.05);
      transition: all .25s ease;
    }
    .kpi-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 22px rgba(0,0,0,.09);
    }
    .chart-export-options {
      position: absolute;
      top: 12px;
      right: 12px;
      z-index: 20;
      display: flex;
      gap: 6px;
    }
    .chart-export-btn {
      background: rgba(255,255,255,.98);
      border: 1px solid #d1d5db;
      border-radius: 6px;
      padding: 5px 9px;
      font-size: 12px;
      cursor: pointer;
      transition: all .2s ease;
      box-shadow: 0 1px 3px rgba(0,0,0,.1);
    }
    .chart-export-btn:hover {
      background: #f8f9fa;
      border-color: #9ca3af;
      transform: translateY(-1px);
      box-shadow: 0 2px 5px rgba(0,0,0,.15);
    }
    .card-header h6 {
      font-weight: 700;
      color: #1f2937;
      font-size: 1.05rem;
    }
    canvas {
      image-rendering: -webkit-optimize-contrast;
      image-rendering: crisp-edges;
      image-rendering: pixelated;
    }

    /* Améliorations responsive */
    @media (max-width: 768px) {
      .chart-container {
        margin: 0 -15px;
        width: calc(100% + 30px);
      }
      .card-chart .card-body {
        padding: 1rem;
      }
      .chart-export-options {
        top: 8px;
        right: 8px;
      }
    }

    /* Amélioration de l'accessibilité */
    .chart-export-btn:focus {
      outline: 2px solid #3b82f6;
      outline-offset: 2px;
    }
  </style>
</head>

<body id="page-top">
<div id="wrapper">
  @include('layouts.header')
  <div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
      @include('layouts.navigation')

      <div class="container-fluid">
        @if (auth()->check() && in_array(auth()->user()->role_id, [4,5,7]))
          <!-- Titre -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tableau de bord</h1>
            <span class="badge badge-primary p-2 d-none d-sm-inline-block">Mis à jour: {{ now()->format('d/m/Y H:i') }}</span>
          </div>

          <!-- KPIs -->
          <div class="row">
            <!-- [Vos KPIs existants restent identiques] -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="kpi-card card border-left-primary h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Candidats inscrits</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $inscription }}</div>
                      <div class="mt-2 text-xs text-muted"><i class="fas fa-arrow-up text-success mr-1"></i>Sur la période</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-users fa-2x text-primary opacity-75"></i></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="kpi-card card border-left-success h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Candidats validés</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $valides }}</div>
                      <div class="mt-2 text-xs text-muted">{{ $inscription ? round(($valides/$inscription)*100, 1) : 0 }}% des inscrits</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-check-circle fa-2x text-success opacity-75"></i></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="kpi-card card border-left-danger h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Candidats rejetés</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $rejetes }}</div>
                      <div class="mt-2 text-xs text-muted">{{ $inscription ? round(($rejetes/$inscription)*100, 1) : 0 }}% des inscrits</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-times-circle fa-2x text-danger opacity-75"></i></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="kpi-card card border-left-warning h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Candidats présélectionnés</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $preselectionnes }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-star fa-2x text-warning opacity-75"></i></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Graphiques -->
          <div class="row">
            <!-- Évolution -->
            <div class="col-xl-8 col-lg-7">
              <div class="card-chart card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Évolution des inscriptions (par jour)</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                      <div class="dropdown-header">Options :</div>
                      <a class="dropdown-item export-btn" data-chart="evolutionChart" data-type="pdf">Exporter en PDF</a>
                      <a class="dropdown-item export-btn" data-chart="evolutionChart" data-type="excel">Exporter en Excel</a>
                    </div>
                  </div>
                </div>
                <div class="card-body position-relative">
                  <div class="chart-export-options">
                    <button class="chart-export-btn" data-chart="evolutionChart" data-type="pdf" title="Exporter en PDF"><i class="fas fa-file-pdf text-danger"></i></button>
                    <button class="chart-export-btn" data-chart="evolutionChart" data-type="excel" title="Exporter en Excel"><i class="fas fa-file-excel text-success"></i></button>
                  </div>
                  <div class="chart-container" style="height:300px">
                    <canvas id="evolutionChart"></canvas>
                  </div>
                </div>
              </div>
            </div>

            <!-- Donut sexe -->
            <div class="col-xl-4 col-lg-5">
              <div class="card-chart card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Répartition par sexe (total)</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true, aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                      <div class="dropdown-header">Options :</div>
                      <a class="dropdown-item export-btn" data-chart="sexePieChart" data-type="pdf">Exporter en PDF</a>
                      <a class="dropdown-item export-btn" data-chart="sexePieChart" data-type="excel">Exporter en Excel</a>
                    </div>
                  </div>
                </div>
                <div class="card-body position-relative">
                  <div class="chart-export-options">
                    <button class="chart-export-btn" data-chart="sexePieChart" data-type="pdf" title="Exporter en PDF"><i class="fas fa-file-pdf text-danger"></i></button>
                    <button class="chart-export-btn" data-chart="sexePieChart" data-type="excel" title="Exporter en Excel"><i class="fas fa-file-excel text-success"></i></button>
                  </div>
                  <div class="chart-container" style="height:300px">
                    <canvas id="sexePieChart"></canvas>
                  </div>
                  <div class="mt-3 text-center small">
                    <span class="mr-2"><i class="fas fa-circle text-primary"></i> Hommes</span>
                    <span class="mr-2"><i class="fas fa-circle text-danger"></i> Femmes</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Région -->
          <div class="row">
            <div class="col-12">
              <div class="card-chart card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Nombre de candidats par région</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                      <div class="dropdown-header">Options :</div>
                      <a class="dropdown-item export-btn" data-chart="regionChart" data-type="pdf">Exporter en PDF</a>
                      <a class="dropdown-item export-btn" data-chart="regionChart" data-type="excel">Exporter en Excel</a>
                    </div>
                  </div>
                </div>
                <div class="card-body position-relative">
                  <div class="chart-export-options">
                    <button class="chart-export-btn" data-chart="regionChart" data-type="pdf" title="Exporter en PDF"><i class="fas fa-file-pdf text-danger"></i></button>
                    <button class="chart-export-btn" data-chart="regionChart" data-type="excel" title="Exporter en Excel"><i class="fas fa-file-excel text-success"></i></button>
                  </div>
                  <div class="chart-container" style="height:400px">
                    <canvas id="regionChart"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Spécialités + Départements -->
          <div class="row">
            <div class="col-12">
              <div class="card-chart card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Répartition Hommes / Femmes par spécialité</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                      <div class="dropdown-header">Options :</div>
                      <a class="dropdown-item export-btn" data-chart="genreChart" data-type="pdf">Exporter en PDF</a>
                      <a class="dropdown-item export-btn" data-chart="genreChart" data-type="excel">Exporter en Excel</a>
                    </div>
                  </div>
                </div>
                <div class="card-body position-relative">
                  <div class="chart-export-options">
                    <button class="chart-export-btn" data-chart="genreChart" data-type="pdf" title="Exporter en PDF"><i class="fas fa-file-pdf text-danger"></i></button>
                    <button class="chart-export-btn" data-chart="genreChart" data-type="excel" title="Exporter en Excel"><i class="fas fa-file-excel text-success"></i></button>
                  </div>
                  <div class="chart-container" style="height:500px">
                    <canvas id="genreChart"></canvas>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="card-chart card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Nombre de candidats par département</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                      <div class="dropdown-header">Options :</div>
                      <a class="dropdown-item export-btn" data-chart="departementChart" data-type="pdf">Exporter en PDF</a>
                      <a class="dropdown-item export-btn" data-chart="departementChart" data-type="excel">Exporter en Excel</a>
                    </div>
                  </div>
                </div>
                <div class="card-body position-relative">
                  <div class="chart-export-options">
                    <button class="chart-export-btn" data-chart="departementChart" data-type="pdf" title="Exporter en PDF"><i class="fas fa-file-pdf text-danger"></i></button>
                    <button class="chart-export-btn" data-chart="departementChart" data-type="excel" title="Exporter en Excel"><i class="fas fa-file-excel text-success"></i></button>
                  </div>
                  <div class="chart-container" style="height:500px">
                    <canvas id="departementChart"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endif

        @if (auth()->check() && auth()->user()->role_id == 6)
          <!-- Processus candidat -->
          <section id="process" class="process-section" aria-labelledby="process-title">
            <div class="section-header text-center mb-4">
              <h2 id="process-title" class="section-title h4 text-primary">Comment postuler ?</h2>
              <p class="section-description text-muted">3 étapes simples pour soumettre votre candidature</p>
            </div>
            <div class="row">
              <div class="col-md-4 mb-4">
                <div class="process-card bg-light border-left-success shadow-sm p-4 h-100">
                  <div class="d-flex align-items-center mb-3">
                    <div class="step-number display-6 text-success">1</div>
                    <h5 class="mb-0 ml-3"><i class="fas fa-user-check text-success mr-2"></i>Compte créé <span class="badge badge-success ml-2">✔ Terminée</span></h5>
                  </div>
                  <ul class="list-unstyled pl-3 mb-0">
                    <li class="mb-2"><i class="fas fa-check-circle text-success mr-2"></i> Inscription validée</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success mr-2"></i> Email confirmé</li>
                    <li><i class="fas fa-check-circle text-success mr-2"></i> Connexion réussie</li>
                  </ul>
                </div>
              </div>

              <div class="col-md-4 mb-4">
                <div class="process-card bg-white border-left-warning shadow-sm p-4 h-100">
                  <div class="d-flex align-items-center mb-3">
                    <div class="step-number display-6 text-warning">2</div>
                    <h5 class="mb-0 ml-3"><i class="fas fa-id-card text-warning mr-2"></i>Compléter votre profil <span class="badge badge-warning ml-2">À faire</span></h5>
                  </div>
                  <ul class="list-unstyled pl-3 mb-0">
                    <li class="mb-2"><i class="far fa-circle text-warning mr-2"></i> Informations personnelles</li>
                    <li class="mb-2"><i class="far fa-circle text-warning mr-2"></i> Coordonnées complètes</li>
                    <li class="mb-2"><i class="far fa-circle text-warning mr-2"></i> Choix de la spécialité</li>
                    <li><i class="far fa-circle text-warning mr-2"></i> Sélection du diplôme requis</li>
                  </ul>
                </div>
              </div>

              <div class="col-md-4 mb-4">
                <div class="process-card bg-white border-left-info shadow-sm p-4 h-100">
                  <div class="d-flex align-items-center mb-3">
                    <div class="step-number display-6 text-info">3</div>
                    <h5 class="mb-0 ml-3"><i class="fas fa-paper-plane text-info mr-2"></i>Soumettre candidature <span class="badge badge-info ml-2">En attente</span></h5>
                  </div>
                  <ul class="list-unstyled pl-3 mb-0">
                    <li class="mb-2"><i class="far fa-circle text-info mr-2"></i> Téléversez votre CV</li>
                    <li class="mb-2"><i class="far fa-circle text-info mr-2"></i> Téléversez votre demande manuscrite</li>
                    <li class="mb-2"><i class="far fa-circle text-info mr-2"></i> Téléversez vos diplômes</li>
                    <li><i class="far fa-circle text-info mr-2"></i> Envoyez votre candidature</li>
                  </ul>
                </div>
              </div>
            </div>
          </section>
        @endif
      </div>
    </div>

    <footer class="sticky-footer bg-white">
      <div class="container my-auto">
        <div class="copyright text-center my-auto">
          <span>Copyright &copy; MEFPT-CI {{ now()->year }}</span>
        </div>
      </div>
    </footer>
  </div>
</div>

<!-- Scroll to top -->
<a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

<!-- Scripts projet -->
@include('layouts.script')

<script>
document.addEventListener('DOMContentLoaded', () => {
  if (window.Chart && window.ChartDataLabels) Chart.register(ChartDataLabels);

  // Helpers
  const frInt = n => (n ?? 0).toLocaleString('fr-FR');
  const headroom = arr => Math.max(5, Math.ceil(Math.max(...(arr || [0])) * 1.15));

  // Fonction pour améliorer la netteté du canvas
  function enhanceCanvasSharpness(canvas) {
    const dpr = window.devicePixelRatio || 1;
    const rect = canvas.getBoundingClientRect();

    // Sauvegarder les dimensions originales pour le style
    canvas.style.width = rect.width + 'px';
    canvas.style.height = rect.height + 'px';

    // Définir la taille réelle du canvas avec le DPR
    canvas.width = rect.width * dpr;
    canvas.height = rect.height * dpr;

    const ctx = canvas.getContext('2d');
    ctx.scale(dpr, dpr);

    return ctx;
  }

  // Recrée un chart proprement avec netteté améliorée
  function createChartOnce(id, config){
    const el = document.getElementById(id);
    if (!el) return null;

    // Améliorer la netteté du canvas
    enhanceCanvasSharpness(el);

    const prev = Chart.getChart(el) || Chart.getChart(id);
    if (prev) prev.destroy();
    return new Chart(el.getContext('2d'), config);
  }

  // Export helpers améliorés
  function titleOf(chartId){
    return document.querySelector(`#${chartId}`)?.closest('.card-chart')?.querySelector('.card-header h6')?.textContent?.trim() || chartId;
  }

  function exportChartToPdf(chartId, title){
    const { jsPDF } = window.jspdf || {};
    if (!jsPDF) { alert('jsPDF introuvable'); return; }
    const canvas = document.getElementById(chartId);
    if (!canvas) return;

    // Sauvegarder l'état original
    const originalWidth = canvas.width;
    const originalHeight = canvas.height;

    // Augmenter la résolution pour l'export
    const dpr = 2; // Double résolution
    canvas.width = originalWidth * dpr;
    canvas.height = originalHeight * dpr;

    const chart = Chart.getChart(chartId);
    if (chart) {
      chart.resize();
      chart.render();
    }

    const img = canvas.toDataURL('image/png', 1.0);

    // Restaurer la taille originale
    canvas.width = originalWidth;
    canvas.height = originalHeight;
    if (chart) {
      chart.resize();
      chart.render();
    }

    const doc = new jsPDF({ orientation: 'landscape', unit: 'pt', format: 'a4' });
    const pw = doc.internal.pageSize.getWidth(), ph = doc.internal.pageSize.getHeight();
    const margin = 28, maxW = pw - margin*2, maxH = ph - margin*2;
    const cw = originalWidth, ch = originalHeight;
    const ratio = Math.min(maxW / cw, maxH / ch);
    const w = cw * ratio, h = ch * ratio;

    doc.setFontSize(16);
    doc.setFont(undefined, 'bold');
    doc.text(title, margin, 32);

    doc.addImage(img, 'PNG', (pw - w)/2, (ph - h)/2 + 10, w, h, undefined, 'MEDIUM');

    doc.setFontSize(10);
    doc.setFont(undefined, 'normal');
    doc.text(`Export: ${new Date().toLocaleString('fr-FR')}`, margin, ph - 12);

    doc.save(`${title.replace(/\s+/g,'_')}.pdf`);
  }

  function exportChartToExcel(chartId, title){
    if (!window.XLSX) { alert('SheetJS introuvable'); return; }
    const chart = Chart.getChart(chartId);
    if (!chart) return;

    const labels = chart.data.labels || [];
    const ds = chart.data.datasets || [];
    let rows = [];

    if (['line','bar'].includes(chart.config.type)){
      if (ds.length <= 1){
        const h = ds[0]?.label || 'Valeur';
        rows = labels.map((lab,i)=>({ 'Catégorie': lab, [h]: ds[0]?.data?.[i] ?? 0 }));
      } else {
        rows = labels.map((lab,i)=>{
          const r = { 'Catégorie': lab };
          ds.forEach((d,j)=> r[d.label || `Dataset ${j+1}`] = d.data[i] ?? 0);
          return r;
        });
      }
    } else if (['doughnut','pie'].includes(chart.config.type)){
      const data = ds[0]?.data || [];
      rows = labels.map((lab,i)=>({ 'Catégorie': lab, 'Valeur': data[i] ?? 0 }));
    }

    const ws = XLSX.utils.json_to_sheet(rows);
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Données');

    // Ajuster la largeur des colonnes
    const colWidths = Object.keys(rows[0] || {}).map(key => ({ wch: key === 'Catégorie' ? 30 : 15 }));
    ws['!cols'] = colWidths;

    XLSX.writeFile(wb, `${title.replace(/\s+/g,'_')}.xlsx`);
  }

  // Gestion des événements d'export
  function setupExportListeners() {
    document.querySelectorAll('.export-btn, .chart-export-btn').forEach(btn => {
      btn.addEventListener('click', e => {
        e.preventDefault();
        const id = btn.getAttribute('data-chart');
        const type = btn.getAttribute('data-type');
        const t = titleOf(id);

        // Feedback visuel
        const originalHtml = btn.innerHTML;
        btn.innerHTML = type === 'pdf' ?
          '<i class="fas fa-spinner fa-spin text-danger"></i>' :
          '<i class="fas fa-spinner fa-spin text-success"></i>';

        setTimeout(() => {
          if (type === 'pdf') exportChartToPdf(id, t);
          if (type === 'excel') exportChartToExcel(id, t);

          // Restaurer le contenu original après un délai
          setTimeout(() => {
            btn.innerHTML = originalHtml;
          }, 1000);
        }, 100);
      });
    });
  }

  setupExportListeners();

  /* ==== Donut sexe (avec total centré) - AMÉLIORÉ ==== */
  (function(){
    const id = 'sexePieChart';
    const labels = @json($sexeLabels ?? ['Hommes','Femmes']);
    const valuesRaw = @json($sexeCounts ?? [0,0]);
    const total = (valuesRaw||[]).reduce((a,b)=>a+(b||0),0);
    const placeholder = total === 0;
    const values = placeholder ? [1,1] : valuesRaw;

    // Plugin centre amélioré
    const CenterText = {
      id: 'centerText',
      afterDraw(chart, args, opts){
        if(!opts?.display) return;
        const arc0 = chart.getDatasetMeta(0)?.data?.[0];
        if(!arc0) return;

        const {ctx} = chart, x = arc0.x, y = arc0.y;
        ctx.save();
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';

        // Titre - taille augmentée
        ctx.font = 'bold 16px Nunito, system-ui';
        ctx.fillStyle = '#374151';
        ctx.fillText(opts.title ?? 'Total', x, y - 12);

        // Valeur - taille augmentée et plus visible
        ctx.font = 'bold 24px Nunito, system-ui';
        ctx.fillStyle = '#111827';
        ctx.fillText(frInt(opts.value ?? 0), x, y + 12);

        // Sous-titre optionnel
        if(opts.subtitle){
          ctx.font = '13px Nunito, system-ui';
          ctx.fillStyle = '#6B7280';
          ctx.fillText(opts.subtitle, x, y + 36);
        }
        ctx.restore();
      }
    };

    Chart.register(CenterText);

    createChartOnce(id, {
      type: 'doughnut',
      data: {
        labels,
        datasets: [{
          data: values,
          label: 'Répartition H/F',
          backgroundColor: ['#4C73DF', '#FF6384'], // Couleurs plus vives
          borderColor: '#fff',
          borderWidth: 3,
          hoverOffset: 15
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '60%',
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              font: {
                size: 13,
                weight: '600'
              },
              padding: 20
            }
          },
          tooltip: {
            backgroundColor: 'rgba(0,0,0,0.9)',
            titleFont: { size: 14 },
            bodyFont: { size: 14 },
            padding: 12,
            callbacks: {
              label: (ctx) => {
                if(placeholder) return `${ctx.label}: 0`;
                const v = ctx.raw ?? 0;
                const p = total ? (v/total*100).toFixed(1).replace('.',',') : 0;
                return `${ctx.label}: ${frInt(v)} (${p}%)`;
              }
            }
          },
          datalabels: {
            color: '#fff',
            textStrokeColor: 'rgba(0,0,0,0.7)',
            textStrokeWidth: 2,
            font: {
              size: 13,
              weight: 'bold',
              family: "'Nunito', 'system-ui'"
            },
            formatter: (v) => {
              if(placeholder) return '';
              const p = total ? v/total*100 : 0;
              return p >= 5 ? `${Math.round(p)}%` : '';
            }
          },
          centerText: {
            display: true,
            title: 'Total',
            value: total,
            subtitle: placeholder ? 'Aucune donnée' : ''
          }
        }
      }
    });
  })();

  /* ==== Évolution des inscriptions - AMÉLIORÉ ==== */
  (function(){
    const id = 'evolutionChart';
    const labels = @json($labels ?? []);
    const values = @json($values ?? []);

    createChartOnce(id, {
      type: 'line',
      data: {
        labels,
        datasets: [{
          label: 'Inscrits / jour',
          data: values,
          borderColor: '#4C73DF',
          backgroundColor: 'rgba(78,115,223,0.15)',
          fill: true,
          tension: 0.2,
          borderWidth: 3,
          pointRadius: 5,
          pointHoverRadius: 8,
          pointBackgroundColor: '#fff',
          pointBorderColor: '#4C73DF',
          pointBorderWidth: 3
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        layout: {
          padding: {
            top: 30,
            right: 20,
            bottom: 15,
            left: 20
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            suggestedMax: headroom(values),
            grace: '10%',
            ticks: {
              callback: frInt,
              font: {
                size: 12,
                weight: '600'
              }
            },
            grid: {
              color: 'rgba(0,0,0,0.08)'
            }
          },
          x: {
            grid: { display: false },
            ticks: {
              maxRotation: 45,
              autoSkip: true,
              maxTicksLimit: 10,
              font: {
                size: 11,
                weight: '500'
              }
            }
          }
        },
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: 'rgba(0,0,0,0.9)',
            titleFont: { size: 13 },
            bodyFont: { size: 13 },
            padding: 10,
            displayColors: false,
            callbacks: {
              label: (c) => ` ${frInt(c.parsed.y)} inscrit(s)`
            }
          },
          datalabels: {
            anchor: 'end',
            align: 'top',
            offset: 8,
            clamp: true,
            clip: false,
            color: '#1F2937',
            backgroundColor: 'rgba(255,255,255,0.97)',
            borderColor: 'rgba(17,24,39,0.2)',
            borderWidth: 1.5,
            borderRadius: 5,
            padding: { left: 6, right: 6, top: 4, bottom: 4 },
            font: {
              size: 11,
              weight: 'bold',
              family: "'Nunito', 'system-ui'"
            },
            formatter: (v) => frInt(v ?? 0)
          }
        }
      }
    });
  })();

  /* ==== Régions - AMÉLIORÉ ==== */
  (function(){
    const id = 'regionChart';
    const labels = @json($regionsLabels ?? []);
    const values = @json($regionsCounts ?? []);
    if(!values.length) return;

    const maxVal = Math.max(...values), minVal = Math.min(...values);
    const maxIdx = values.indexOf(maxVal);
    let minIdx = values.findIndex((v,i) => v === minVal && i !== maxIdx);
    if(minIdx === -1) minIdx = maxIdx;

    const GREEN_BG = 'rgba(34,197,94,.95)', GREEN_BR = 'rgba(34,197,94,1)';
    const RED_BG = 'rgba(239,68,68,.95)', RED_BR = 'rgba(239,68,68,1)';
    const BLUE_BG = 'rgba(54,162,235,.95)', BLUE_BR = 'rgba(54,162,235,1)';

    const bg = values.map((_,i) => i === maxIdx ? GREEN_BG : (i === minIdx ? RED_BG : BLUE_BG));
    const br = values.map((_,i) => i === maxIdx ? GREEN_BR : (i === minIdx ? RED_BR : BLUE_BR));

    createChartOnce(id, {
      type: 'bar',
      data: {
        labels,
        datasets: [{
          label: 'Candidats',
          data: values,
          backgroundColor: bg,
          borderColor: br,
          borderWidth: 1.5,
          borderRadius: 6,
          maxBarThickness: 55
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        layout: {
          padding: {
            top: 25,
            right: 20,
            bottom: 15,
            left: 20
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: n => frInt(n),
              font: {
                size: 12,
                weight: '600'
              }
            },
            grid: {
              color: 'rgba(0,0,0,0.08)'
            }
          },
          x: {
            grid: { display: false },
            ticks: {
              maxRotation: 45,
              minRotation: 30,
              font: {
                size: 11,
                weight: '500'
              }
            }
          }
        },
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: 'rgba(0,0,0,0.9)',
            titleFont: { size: 13 },
            bodyFont: { size: 13 },
            padding: 10,
            displayColors: true,
            callbacks: {
              label: (c) => ` ${frInt(+c.raw||0)} candidat(s)`
            }
          },
          datalabels: {
            display: true,
            anchor: 'end',
            align: 'end',
            offset: 4,
            clamp: true,
            formatter: (v) => frInt(v),
            font: {
              size: 12,
              weight: 'bold',
              family: "'Nunito', 'system-ui'"
            },
            color: (ctx) => {
              const color = ctx.dataset.backgroundColor[ctx.dataIndex];
              return (color.includes('34,197,94') || color.includes('239,68,68')) ? '#000' : '#1f2937';
            },
            textStrokeColor: (ctx) => {
              const color = ctx.dataset.backgroundColor[ctx.dataIndex];
              return (color.includes('54,162,235')) ? 'rgba(255,255,255,0.8)' : 'transparent';
            },
            textStrokeWidth: 1.5
          }
        }
      }
    });
  })();

  /* ==== Spécialités - AMÉLIORÉ ==== */
  (function(){
    const id = 'genreChart';
    const labels = @json($specialites ?? []);
    const g = @json($garcons ?? []);
    const f = @json($filles ?? []);
    const totals = labels.map((_,i) => (g[i]||0) + (f[i]||0));
    const container = document.getElementById(id)?.parentElement;
    if(container) container.style.height = Math.max(400, labels.length * 38) + 'px';

    createChartOnce(id, {
      type: 'bar',
      data: {
        labels,
        datasets: [
          {
            label: 'Hommes',
            data: g,
            backgroundColor: 'rgba(54,162,235,.95)',
            borderColor: 'rgba(54,162,235,1)',
            borderWidth: 1.5,
            borderRadius: 5
          },
          {
            label: 'Femmes',
            data: f,
            backgroundColor: 'rgba(255,99,132,.95)',
            borderColor: 'rgba(255,99,132,1)',
            borderWidth: 1.5,
            borderRadius: 5
          }
        ]
      },
      options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          x: {
            stacked: true,
            beginAtZero: true,
            suggestedMax: headroom(totals),
            ticks: {
              callback: frInt,
              font: {
                size: 12,
                weight: '600'
              }
            },
            grid: {
              color: 'rgba(0,0,0,0.08)'
            }
          },
          y: {
            stacked: true,
            grid: { display: false },
            ticks: {
              font: {
                size: 12,
                weight: '500'
              }
            }
          }
        },
        plugins: {
          tooltip: {
            backgroundColor: 'rgba(0,0,0,0.9)',
            titleFont: { size: 13 },
            bodyFont: { size: 13 },
            padding: 10,
            callbacks: {
              label: (c) => {
                const v = c.raw ?? 0;
                const t = totals[c.dataIndex] || 1;
                const p = (v/t*100).toFixed(1).replace('.',',');
                return `${c.dataset.label}: ${frInt(v)} (${p}%)`;
              }
            }
          },
          datalabels: {
            anchor: 'end',
            align: 'right',
            color: '#000',
            textStrokeColor: 'rgba(0,0,0,0.7)',
            textStrokeWidth: 2,
            font: {
              size: 11,
              weight: 200,
              family: "'Nunito', 'system-ui'"
            },
            formatter: (v, ctx) => {
              const t = totals[ctx.dataIndex] || 1;
              const p = v/t*100;
              return p >= 5 ? `${Math.round(p)}%` : '';
            },
            clip: true
          }
        }
      }
    });
  })();

  /* ==== Départements - AMÉLIORÉ ==== */
  (function(){
    const id = 'departementChart';
    let labels = @json($departementsLabels ?? []);
    let values = @json($departementsCounts ?? []);
    const order = values.map((v,i) => i).sort((a,b) => values[b] - values[a]);
    labels = order.map(i => labels[i]);
    values = order.map(i => values[i]);

    const maxVal = Math.max(...values);
    const bg = values.map(v => {
      const r = v/maxVal || 0;
      const R = Math.floor(78 + (249-78) * (1-r));
      const G = Math.floor(115 + (115-115) * (1-r));
      const B = Math.floor(223 + (22-223) * (1-r));
      return `rgba(${R},${G},${B},0.95)`;
    });
    const br = bg.map(c => c.replace('0.95','1'));

    // Fonction utilitaire pour déterminer la couleur du texte
    function getTextColorForBackground(rgba) {
      if (!rgba) return '#111827';

      const match = rgba.match(/rgba?\((\d+),\s*(\d+),\s*(\d+)/);
      if (!match) return '#111827';

      const r = parseInt(match[1]);
      const g = parseInt(match[2]);
      const b = parseInt(match[3]);

      // Calcul de la luminance relative
      const luminance = (0.299 * r + 0.587 * g + 0.114 * b) / 255;

      // Retourner blanc pour les fonds sombres, noir pour les fonds clairs
      return luminance > 0.6 ? '#111827' : '#00000';
    }

    createChartOnce(id, {
      type: 'bar',
      data: {
        labels,
        datasets: [{
          label: 'Candidats',
          data: values,
          backgroundColor: bg,
          borderColor: br,
          borderWidth: 1.5,
          borderRadius: 6,
          maxBarThickness: 55
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        layout: {
          padding: {
            top: 25,
            right: 20,
            bottom: 15,
            left: 20
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            suggestedMax: headroom(values),
            ticks: {
              callback: frInt,
              font: {
                size: 12,
                weight: '600'
              }
            },
            grid: {
              color: 'rgba(0,0,0,0.08)'
            }
          },
          x: {
            grid: { display: false },
            ticks: {
              maxRotation: 45,
              minRotation: 30,
              font: {
                size: 11,
                weight: '500'
              }
            }
          }
        },
        plugins: {
          tooltip: {
            backgroundColor: 'rgba(0,0,0,0.9)',
            titleFont: { size: 13 },
            bodyFont: { size: 13 },
            padding: 10,
            displayColors: true,
            callbacks: {
              label: (c) => ` ${frInt(c.raw)} candidat(s)`,
              afterLabel: (c) => `Classement: ${values.indexOf(c.raw)+1}/${values.length}`
            }
          },
          datalabels: {
            anchor: 'end',
            align: 'end',
            font: {
              size: 12,
              weight: 'bold',
              family: "'Nunito', 'system-ui'"
            },
            formatter: (v) => frInt(v),
            color: (ctx) => {
              const bgColor = ctx.dataset.backgroundColor[ctx.dataIndex];
              return getTextColorForBackground(bgColor);
            },
            textStrokeColor: (ctx) => {
              const bgColor = ctx.dataset.backgroundColor[ctx.dataIndex];
              const textColor = getTextColorForBackground(bgColor);
              return textColor === '#FFFFFF' ? 'rgba(0,0,0,0.4)' : 'rgba(255,255,255,0.6)';
            },
            textStrokeWidth: 1.5
          }
        }
      }
    });
  })();

  // Améliorer la netteté de tous les canvas après le chargement
  setTimeout(() => {
    document.querySelectorAll('canvas').forEach(canvas => {
      enhanceCanvasSharpness(canvas);
      const chart = Chart.getChart(canvas);
      if (chart) {
        chart.update();
      }
    });
  }, 100);

  // Recalculer la netteté lors du redimensionnement
  let resizeTimer;
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
      document.querySelectorAll('canvas').forEach(canvas => {
        enhanceCanvasSharpness(canvas);
        const chart = Chart.getChart(canvas);
        if (chart) {
          chart.resize();
          chart.update('none');
        }
      });
    }, 250);
  });

});
</script>
</body>
</html>
