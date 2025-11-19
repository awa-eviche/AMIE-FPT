<!DOCTYPE html>
<html lang="fr">
<head>

    @include('layouts.v1.partials._head')

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Carte des Etablissements du Sénégal</title>

  <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    :root {
      --primary: #2563eb;
      --primary-hover: #1d4ed8;
      --secondary: #64748b;
      --accent: #10b981;
      --danger: #ef4444;
      --warning: #f59e0b;
      --light-bg: #f8fafc;
      --card-bg: #ffffff;
      --border: #e2e8f0;
      --text: #1e293b;
      --text-light: #64748b;
      --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    * { 
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    
    html, body { 
      height: 100%; 
      font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
      color: var(--text);
      background-color: #f1f5f9;
      overflow-x: hidden;
    }
    
    .layout { 
      display: grid; 
      grid-template-columns: 1fr 420px; 
      gap: 20px; 
      padding: 20px;
      height: 100%;
      max-width: 1600px;
      margin: 0 auto;
    }
    
    @media (max-width: 1024px) { 
      .layout { 
        grid-template-columns: 1fr;
        grid-template-rows: auto 1fr;
        gap: 16px;
        padding: 16px;
      } 
    }
    
    @media (max-width: 640px) {
      .layout {
        padding: 12px;
        gap: 12px;
      }
    }
    
    /* Carte */
    .map-card { 
      position: relative; 
      background: var(--card-bg); 
      border-radius: 16px; 
      padding: 20px;
      box-shadow: var(--shadow);
      height: 100%;
      display: flex;
      flex-direction: column;
    }
    
    .map-header {
      margin-bottom: 16px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    
    .map-title {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--text);
    }
    
    .map-container { 
      position: relative; 
      flex: 1;
      border-radius: 12px;
      overflow: hidden;
      background: #f8fafc;
    }
    
    .center-image { 
      display: block; 
      width: 100%;
      height: 100%;
      object-fit: contain;
      border-radius: 8px;
      transition: all 0.3s ease;
    }
    
    #badges-container { 
      position: absolute; 
      inset: 0; 
      pointer-events: none; 
    }
    
    .region-badge {
      position: absolute; 
      transform: translate(-50%, -50%);
      background: var(--danger); 
      color: #fff; 
      min-width: 32px; 
      height: 32px; 
      padding: 0 10px;
      border-radius: 999px; 
      display: flex; 
      align-items: center; 
      justify-content: center;
      font-size: 14px; 
      font-weight: 800; 
      white-space: nowrap; 
      line-height: 1;
      box-shadow: 0 4px 12px rgba(239, 68, 68, 0.35);
      pointer-events: none; 
      user-select: none;
      z-index: 5;
      transition: all 0.2s ease;
    }
    
    .region-badge[data-hot="1"] { 
      background: var(--accent); 
      box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35); 
    }
    
    .region-badge:hover {
      transform: translate(-50%, -50%) scale(1.1);
    }
    
    .tooltip {
      position: absolute; 
      z-index: 1000; 
      background: rgba(15, 23, 42, 0.95); 
      color: #fff; 
      padding: 16px;
      border-radius: 12px; 
      font-size: 14px; 
      line-height: 1.5; 
      pointer-events: none;
      max-width: min(360px, 70vw); 
      box-shadow: var(--shadow-lg); 
      display: none;
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .tooltip h3 {
      margin: 0 0 8px; 
      font-size: 16px;
      color: #fff;
      font-weight: 600;
    }
    
    .tooltip small {
      opacity: 0.8;
      font-size: 12px;
    }
    
    .tooltip .list {
      max-height: 220px; 
      overflow: auto; 
      margin-top: 12px;
      padding-right: 4px;
    }
    
    .tooltip .list::-webkit-scrollbar {
      height: 6px;
      width: 6px;
    }
    
    .tooltip .list::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, 0.2);
      border-radius: 10px;
    }
    
    .tooltip .list-item {
      padding: 6px 0;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .tooltip .list-item:last-child {
      border-bottom: none;
    }
    
    /* Panneau latÃ©ral */
    .side-panel {
      background: var(--card-bg); 
      border-radius: 16px;
      padding: 20px; 
      position: sticky; 
      top: 20px; 
      height: calc(100dvh - 40px); 
      overflow: auto;
      overscroll-behavior: contain;
      box-shadow: var(--shadow);
      display: flex;
      flex-direction: column;
    }
    
    .panel-header {
      margin-bottom: 16px;
      padding-bottom: 16px;
      border-bottom: 1px solid var(--border);
    }
    
    .panel-title {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--text);
      margin-bottom: 4px;
    }
    
    .panel-subtitle {
      color: var(--text-light);
      font-size: 0.875rem;
      line-height: 1.5;
    }
    
    .stats-container {
      display: flex;
      gap: 12px;
      margin-bottom: 20px;
      flex-wrap: wrap;
    }
    
    .stat-pill {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 8px 14px;
      border-radius: 999px;
      background: #eff6ff;
      color: var(--primary);
      font-weight: 600;
      font-size: 0.875rem;
    }
    
    .stat-pill i {
      font-size: 0.75rem;
    }
    
    .panel-content {
      flex: 1;
      overflow: auto;
    }
    
    .divider {
      height: 1px;
      background: var(--border);
      margin: 20px 0;
    }
    
    /* Boutons */
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 10px 16px;
      border-radius: 10px;
      border: none;
      background: var(--primary);
      color: #fff;
      font-weight: 600;
      cursor: pointer;
      white-space: nowrap;
      transition: all 0.2s ease;
      font-size: 0.875rem;
    }
    
    .btn:hover {
      background: var(--primary-hover);
      transform: translateY(-1px);
      box-shadow: var(--shadow);
    }
    
    .btn:active {
      transform: translateY(0);
    }
    
    .btn i {
      font-size: 0.875rem;
    }
    
    .btn-secondary {
      background: #fff;
      color: var(--primary);
      border: 1px solid var(--border);
    }
    
    .btn-secondary:hover {
      background: #f1f5f9;
    }
    
    .btn-sm {
      padding: 6px 12px;
      font-size: 0.75rem;
    }
    
    /* Tableaux */
    .table-container {
      overflow: auto;
      border-radius: 12px;
      border: 1px solid var(--border);
      margin-top: 16px;
    }
    
    table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
    }
    
    th {
      background: #f8fafc;
      padding: 12px 16px;
      text-align: left;
      font-weight: 600;
      font-size: 0.875rem;
      color: var(--text);
      position: sticky;
      top: 0;
      border-bottom: 1px solid var(--border);
    }
    
    td {
      padding: 12px 16px;
      border-bottom: 1px solid var(--border);
      vertical-align: top;
      font-size: 0.875rem;
    }
    
    tr:last-child td {
      border-bottom: none;
    }
    
    tr:hover {
      background: #f8fafc;
    }
    
    /* Ã‰tats vides */
    .empty-state {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 40px 20px;
      text-align: center;
      color: var(--text-light);
    }
    
    .empty-state i {
      font-size: 2rem;
      margin-bottom: 16px;
      opacity: 0.5;
    }
    
    .empty-state p {
      margin-bottom: 16px;
    }
    
    /* LÃ©gende */
    .legend {
      display: flex;
      gap: 16px;
      margin-top: 16px;
      flex-wrap: wrap;
    }
    
    .legend-item {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 0.75rem;
      color: var(--text-light);
    }
    
    .legend-color {
      width: 16px;
      height: 16px;
      border-radius: 50%;
    }
    
    .legend-color.red {
      background: var(--danger);
    }
    
    .legend-color.green {
      background: var(--accent);
    }
    
    /* Animation */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .fade-in {
      animation: fadeIn 0.3s ease-out;
    }
    
    /* Loading */
    .loading {
      display: inline-block;
      width: 20px;
      height: 20px;
      border: 3px solid rgba(37, 99, 235, 0.3);
      border-radius: 50%;
      border-top-color: var(--primary);
      animation: spin 1s ease-in-out infinite;
    }
    
    @keyframes spin {
      to { transform: rotate(360deg); }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
      .map-card, .side-panel {
        padding: 16px;
      }
      
      .map-title, .panel-title {
        font-size: 1.25rem;
      }
      
      .stats-container {
        flex-direction: column;
        align-items: stretch;
      }
      
      .stat-pill {
        justify-content: center;
      }
    }
    
    /* AccessibilitÃ© */
    @media (prefers-reduced-motion: reduce) {
      * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
      }
    }
    
    /* Focus visible pour l'accessibilitÃ© */
    button:focus-visible, area:focus-visible {
      outline: 2px solid var(--primary);
      outline-offset: 2px;
    }
  </style>
</head>
  <br>


@include('partials.head')


<br>

<body>
  <div class="layout">
    <!-- Colonne gauche : Carte -->
    <div class="map-card">
      <div class="map-header">
        <h1 class="map-title">Carte des Etablissements</h1>
        <div class="legend">
          <div class="legend-item">
            <div class="legend-color red"></div>
            <span>1-9 Etablissements</span>
          </div>
          <div class="legend-item">
            <div class="legend-color green"></div>
            <span>10+ Etablissements</span>
          </div>
        </div>
      </div>
      
      <div class="map-container" id="mapContainer">
        <img id="carteImage"
             src="{{ asset('carte.gif') }}"
             alt="Carte du Sénégal avec départements cliquables"
             usemap="#carte_senegal"
             class="center-image" />
        <div id="badges-container"></div>
        <div id="tooltip" class="tooltip" role="tooltip" aria-hidden="true"></div>

        <map name="carte_senegal">
          @foreach($departements as $departement)
            <area
              alt="{{ $departement->libelle }}"
              title="{{ $departement->libelle }}"
              href="#"
              data-dep-id="{{ $departement->id }}"
              coords="{{ $departement->coords }}"
              shape="poly"
              aria-label="DÃ©partement {{ $departement->libelle }}, {{ $departement->etablissements->count() }} Etablissements"
              tabindex="0">
          @endforeach
        </map>
      </div>
    </div>

    <!-- Colonne droite : Panneau latÃ©ral -->
    <aside id="sidePanel" class="side-panel">
      <div class="panel-header">
        <h2 class="panel-title">Informations</h2>
        <p class="panel-subtitle">Survolez une région pour voir les Etablissements, puis <strong>cliquez</strong> pour afficher les détails.</p>
      </div>
      
      <div class="stats-container">
        <span class="stat-pill"><i class="fas fa-map-marker-alt"></i> Départements: <span id="spRegionCount">0</span></span>
        <span class="stat-pill"><i class="fas fa-school"></i> Etablissements: <span id="spEfpCount">0</span></span>
      </div>
      
      <div class="divider"></div>
      
      <div class="panel-content" id="panelBody">
        <div class="empty-state">
          <i class="fas fa-map-marked-alt"></i>
          <p>Aucune région sélectionnée</p>
          <p class="text-sm">Cliquez sur un département de la carte pour afficher ses Etablissements</p>
        </div>
      </div>
    </aside>
  </div>
<!-- 

   -->
<script>
  /* ===== Données injectées depuis Blade ===== */
  const establishments = {};
  const departments = {};

  @foreach($departements as $d)
    establishments[@json($d->libelle)] = @json($d->etablissements->pluck('nom')->values());

    departments[@json($d->id)] = {
      id: @json($d->id),
      name: @json($d->libelle),
      etablissements: [
        @foreach($d->etablissements as $e)
          {
            id: @json($e->id),
            nom: @json($e->nom),
            tel: @json($e->telephone),
            adresse: @json($e->adresse),
           metiers: [
              @foreach($e->niveauEtudeEtablissements as $nee)
                {
                  nom: @json(optional($nee->niveauEtude->metier)->nom),
                  diplome: @json(optional($nee->niveauEtude)->nom)
                },
              @endforeach
            ]
          },
        @endforeach
      ]
    };
  @endforeach

  /* ===== Stats ===== */
  document.getElementById('spRegionCount').textContent = Object.keys(departments).length;
  document.getElementById('spEfpCount').textContent =
    Object.values(departments).reduce((sum, d)=> sum + (d.etablissements?.length||0), 0);

  /* ===== Références DOM ===== */
  const mapImage = document.getElementById('carteImage');
  const badgesContainer = document.getElementById('badges-container');
  const tooltip = document.getElementById('tooltip');
  const areas = Array.from(document.querySelectorAll('map[name="carte_senegal"] area'));
  const sidePanelBody = document.getElementById('panelBody');

  /* ===== Pastilles ===== */
  function getPolyCenter(area){
    const pts = area.coords.split(',').map(Number);
    let sx=0, sy=0, n=0;
    for(let i=0;i<pts.length;i+=2){ sx+=pts[i]; sy+=pts[i+1]; n++; }
    return { x: sx/n, y: sy/n };
  }

  function createCountBadges(){
    const w = mapImage.naturalWidth  || mapImage.clientWidth;
    const h = mapImage.naturalHeight || mapImage.clientHeight;
    badgesContainer.innerHTML = '';

    areas.forEach(area=>{
      const key = area.title || area.alt || '';
      const count = (establishments[key]?.length || 0);
      if(count>0){
        const {x,y} = getPolyCenter(area);
        const badge = document.createElement('div');
        badge.className = 'region-badge';
        badge.textContent = (count >= 100) ? '99+' : String(count);
        badge.setAttribute('aria-label', `${count} établissements dans ${key}`);

        badge.style.left = (x / w * 100) + '%';
        badge.style.top  = (y / h * 100) + '%';

        if(count >= 10) badge.setAttribute('data-hot','1');
        badgesContainer.appendChild(badge);
        clampBadgePosition(badge);
      }
    });
  }

  function clampBadgePosition(badge){
    const imgRect = mapImage.getBoundingClientRect();
    const bRect = badge.getBoundingClientRect();
    const pad = 2;
    let dx = 0, dy = 0;

    if (bRect.left < imgRect.left + pad) {
      dx = (imgRect.left + pad) - bRect.left;
    } else if (bRect.right > imgRect.right - pad) {
      dx = (imgRect.right - pad) - bRect.right;
    }
    if (bRect.top < imgRect.top + pad) {
      dy = (imgRect.top + pad) - bRect.top;
    } else if (bRect.bottom > imgRect.bottom - pad) {
      dy = (imgRect.bottom - pad) - bRect.bottom;
    }
    if (dx !== 0 || dy !== 0) {
      badge.style.transform = `translate(calc(-50% + ${dx}px), calc(-50% + ${dy}px))`;
    }
  }

  if(!mapImage.complete){
    mapImage.addEventListener('load', createCountBadges, { once:true });
  } else {
    createCountBadges();
  }
  window.addEventListener('resize', createCountBadges);

  /* ===== Tooltip borné à l'image ===== */
  function positionTooltipWithinImage(e){
    const pad = 12;
    const tW = tooltip.offsetWidth || 300;
    const tH = tooltip.offsetHeight || 180;
    const imgRect = mapImage.getBoundingClientRect();

    let x = e.clientX + pad;
    let y = e.clientY + pad;

    if (x + tW > imgRect.right - pad) x = imgRect.right - tW - pad;
    if (x < imgRect.left + pad)      x = imgRect.left + pad;
    if (y + tH > imgRect.bottom - pad) y = imgRect.bottom - tH - pad;
    if (y < imgRect.top + pad)         y = imgRect.top + pad;

    tooltip.style.left = (x + window.scrollX) + 'px';
    tooltip.style.top  = (y + window.scrollY) + 'px';
  }

  function showTooltip(regionName, e){
    const list = establishments[regionName] || [];
    if(list.length === 0) return;

    tooltip.innerHTML =
      `<h3>${regionName}</h3><small>${list.length} établissement(s)</small>` +
      `<div class="list">${list.map(n => `<div class="list-item">• ${n}</div>`).join('')}</div>`;
    tooltip.style.display = 'block';
    positionTooltipWithinImage(e);
  }

  function hideTooltip(){ 
    tooltip.style.display = 'none'; 
  }

  areas.forEach(area=>{
    area.addEventListener('mouseover', e => showTooltip(area.title || area.alt, e));
    area.addEventListener('mousemove', positionTooltipWithinImage);
    area.addEventListener('mouseout', hideTooltip);
  });

  /* ===== Panneau latéral ===== */
  let currentDepId = null;

  function renderDeptPanel(depId){
    currentDepId = depId;
    const dep = departments[depId];
    if(!dep){
      sidePanelBody.innerHTML = `<div class="empty-state"><i class="fas fa-exclamation-circle"></i><p>Département introuvable</p></div>`;
      return;
    }

    const rows = (dep.etablissements||[]).map(e => `
      <tr>
        <td>${e.nom ?? '-'}</td>
        <td>
          <button class="btn btn-sm" data-action="open-programs" data-efp-id="${e.id}">
            <i class="fas fa-graduation-cap"></i> Métiers
          </button>
        </td>
      </tr>
    `).join('');

    sidePanelBody.innerHTML = `
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold">${dep.name}</h3>
        <span class="stat-pill">${dep.etablissements?.length || 0} établissement(s)</span>
      </div>
      ${
        (dep.etablissements?.length||0) === 0
          ? `<div class="empty-state"><i class="fas fa-school"></i><p>Aucun établissement dans ce département</p></div>`
          : `
            <div class="table-container">
              <table>
                <thead>
                  <tr>
                    <th>Établissements</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>${rows}</tbody>
              </table>
            </div>
          `
      }
    `;
    sidePanelBody.classList.add('fade-in');
  }

  function renderProgramsPanel(efpId){
    const dep = departments[currentDepId];
    if(!dep){ return; }
    const efp = (dep.etablissements||[]).find(x => String(x.id) === String(efpId));
    if(!efp){
      sidePanelBody.innerHTML = `<div class="empty-state"><i class="fas fa-exclamation-circle"></i><p>Établissement introuvable</p></div>`;
      return;
    }

    const progRows = (efp.metiers||[]).map(m => `
      <tr>
        <td>${m.nom ?? '-'}</td>
        <td>${m.diplome ?? '-'}</td>
      </tr>
    `).join('');

    sidePanelBody.innerHTML = `
      <div class="flex items-center justify-between mb-4">
        <div>
          <div class="text-sm text-gray-500">${dep.name}</div>
          <h3 class="text-lg font-bold">${efp.nom}</h3>
        </div>
        <button class="btn btn-secondary btn-sm" data-action="back-dep">
          <i class="fas fa-arrow-left"></i> Retour
        </button>
      </div>
      
      <div class="bg-gray-50 p-4 rounded-lg mb-4">
        <div class="grid grid-cols-1 gap-2">
          <div><span class="font-medium">Tél.:</span> ${efp.tel ?? '-'}</div>
          <div><span class="font-medium">Adresse:</span> ${efp.adresse ?? '-'}</div>
        </div>
      </div>
      
      <h4 class="font-medium mb-3">Métiers/Formations</h4>
      
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>Métier</th>
              <th>Niveau  d'etude </th>
            </tr>
          </thead>
          <tbody>
            ${
              (efp.metiers && efp.metiers.length)
                ? progRows
                : `<tr><td colspan="2" class="text-center py-8 text-gray-500"><i class="fas fa-book-open mr-2"></i>Aucun métier renseigné</td></tr>`
            }
          </tbody>
        </table>
      </div>
    `;
    sidePanelBody.classList.add('fade-in');
  }

  sidePanelBody.addEventListener('click', (e)=>{
    const btnProg = e.target.closest('[data-action="open-programs"]');
    if(btnProg){
      const efpId = btnProg.getAttribute('data-efp-id');
      renderProgramsPanel(efpId);
      return;
    }
    
    const btnBack = e.target.closest('[data-action="back-dep"]');
    if(btnBack){
      renderDeptPanel(currentDepId);
    }
  });

  /* ===== Clic carte => panneau ===== */
  areas.forEach(area=>{
    area.addEventListener('click', e=>{
      e.preventDefault();
      hideTooltip();
      const depId = area.getAttribute('data-dep-id');
      renderDeptPanel(depId);
    });
  });

  /* ===== Init ===== */
  function init(){
    if(mapImage.complete){ 
      createCountBadges(); 
    }
  }
  document.addEventListener('DOMContentLoaded', init);
</script>


<br>  
  </br>  
<br>  
  </br> 
</body>
 <br>  
  </br>
  @include('partials.footer')
</html>
