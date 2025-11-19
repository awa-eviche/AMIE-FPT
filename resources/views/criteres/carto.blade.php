<!DOCTYPE html>
<html lang="fr">
<head>

    @include('layouts.v1.partials._head')

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Carte du S�n�gal</title>

  <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css" rel="stylesheet">

  <style>
    :root{
      --panel-bg:#fff; --panel-border:#e5e7eb; --muted:#64748b;
      --badge:#e74c3c; --badge2:#15a362; --tooltip:#0b1b28;
    }
    *{ box-sizing:border-box }
    html,body{ height:100% }
    body{ margin:0; font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; overflow-x:hidden; }
    .layout{ display:grid; grid-template-columns: 1fr 420px; gap:16px; padding:16px; }
    @media (max-width: 1024px){ .layout{ grid-template-columns:1fr; } }

    .map-card{ position:relative; background:#fff; border-radius:12px; padding:12px; }
    .map-container{ position:relative; display:block; width:100%; }
    .center-image{ display:block; margin:0 auto; max-width:100%; height:auto; border-radius:8px; }
    #badges-container{ position:absolute; inset:0; pointer-events:none; }

    .region-badge{
      position:absolute; transform:translate(-50%,-50%);
      background:var(--badge); color:#fff; min-width:28px; height:28px; padding:0 8px;
      border-radius:999px; display:flex; align-items:center; justify-content:center;
      font-size:13px; font-weight:800; white-space:nowrap; line-height:1;
      box-shadow:0 4px 12px rgba(231,76,60,.35);
      pointer-events:none; user-select:none;
    }
    .region-badge[data-hot="1"]{ background:var(--badge2); box-shadow:0 4px 12px rgba(21,163,98,.35) }

    .tooltip{
      position:absolute; z-index:1000; background:var(--tooltip); color:#fff; padding:12px 14px;
      border-radius:10px; font-size:14px; line-height:1.35; pointer-events:none;
      max-width:min(340px, 70vw); box-shadow:0 12px 24px rgba(0,0,0,.25); display:none;
      overflow:hidden;
    }
    .tooltip h3{margin:0 0 6px; font-size:15px}
    .tooltip small{opacity:.8}
    .tooltip .list{max-height:220px; overflow:auto; margin-top:8px}
    .tooltip .list::-webkit-scrollbar{height:8px;width:8px}
    .tooltip .list::-webkit-scrollbar-thumb{background:#3b4a57;border-radius:8px}

    .side-panel{
      background:var(--panel-bg); border:1px solid var(--panel-border); border-radius:12px;
      padding:14px; position:sticky; top:14px; height:calc(100dvh - 28px); overflow:auto;
      overscroll-behavior:contain;
    }
    .side-muted{ color:var(--muted); }
    .btn{
      display:inline-flex; align-items:center; gap:6px; padding:8px 12px; border-radius:10px;
      border:1px solid #dbe3ee; background:#0e7abf; color:#fff; font-weight:600; cursor:pointer;
      white-space:nowrap;
    }
    .btn.secondary{ background:#fff; color:#0e7abf; }

    table{ width:100%; border-collapse:collapse; table-layout:fixed; }
    th, td{ border:1px solid var(--panel-border); padding:8px; text-align:left; vertical-align:top; word-break:break-word; }
    thead th{ background:#f8fafc; }
    .pill{ display:inline-flex; align-items:center; gap:6px; padding:6px 10px; border-radius:999px; background:#eef6fd; color:#0b66a3; font-weight:700; }
  </style>
</head>

  @include('partials.head')
<br>
<br>
<body>


  <div class="layout">
    <!-- Colonne gauche : Carte -->
    <div class="map-card">
      <div class="map-container" id="mapContainer">
        <img id="carteImage"
             src="{{ asset('carte.gif') }}"
             alt="Carte du Sénégal"
             usemap="#carte_senegal"
             class="center-image" />
        <div id="badges-container"></div>
        <div id="tooltip" class="tooltip" role="tooltip" aria-hidden="true"></div>

        <map name="carte_senegal">
          @foreach($departements as $departement)
            <area
              alt="{{ $departement->nom_depart }}"
              title="{{ $departement->nom_depart }}"
              href="#"
              data-dep-id="{{ $departement->id }}"
              coords="{{ $departement->coords }}"
              shape="poly">
          @endforeach
        </map>
      </div>
    </div>

    <!-- Colonne droite : Panneau latéral -->
    <aside id="sidePanel" class="side-panel">
      <h2 class="text-xl font-bold mb-1">Informations</h2>
      <p class="side-muted">Survolez une région pour voir la liste (tooltip), puis <b>cliquez</b> pour lister les établissements ici. Cliquez sur <i>Voir formations</i> pour afficher les filières.</p>
      <div class="mt-3" style="display:flex; gap:8px; flex-wrap:wrap;">
        <span class="pill">Total départements : <span id="spRegionCount">0</span></span>
        <span class="pill">Total établissements : <span id="spEfpCount">0</span></span>
      </div>
      <hr class="my-4">
      <div id="panelBody">
        <em class="side-muted">Aucune région sélectionnée.</em>
      </div>
    </aside>
  </div>

  <script>
    /* ===== Données depuis Blade ===== */
    const establishments = {};
    const departments = {};

    @foreach($departements as $d)
      establishments[@json($d->nom_depart)] = @json($d->efpts->pluck('nom')->values());

      departments[@json($d->id)] = {
        id: @json($d->id),
        name: @json($d->nom_depart),
        efpts: [
          @foreach($d->efpts as $e)
            {
              id: @json($e->id),
              nom: @json($e->nom),
              tel: @json($e->tel),
              adresse: @json($e->adresse),
              programms: [
                @foreach($e->programms as $p)
                  { nom: @json($p->nom), grade: @json(optional($p->grade)->nom) },
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
      Object.values(departments).reduce((sum, d)=> sum + (d.efpts?.length||0), 0);

    /* ===== Références DOM ===== */
    const mapImage = document.getElementById('carteImage');
    const mapContainer = document.getElementById('mapContainer');
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
          const label = (count >= 100) ? '99+' : String(count);
          badge.textContent = label;

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
        `<div class="list">${list.map(n => `• ${n}`).join('<br>')}</div>`;
      tooltip.style.display = 'block';
      positionTooltipWithinImage(e);
    }
    function hideTooltip(){ tooltip.style.display = 'none'; }

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
        sidePanelBody.innerHTML = `<em class="side-muted">Région introuvable.</em>`;
        return;
      }

      const rows = (dep.efpts||[]).map(e => `
        <tr>
          <td>${e.nom ?? '-'}</td>
          <td>${e.tel ?? '-'}</td>
          <td>${e.adresse ?? '-'}</td>
          <td style="width:1%">
            <button class="btn" data-action="open-programs" data-efp-id="${e.id}">
              Voir formations
            </button>
          </td>
        </tr>
      `).join('');

      sidePanelBody.innerHTML = `
        <div class="flex items-center justify-between mb-2" style="gap:8px; flex-wrap:wrap;">
          <h3 class="text-lg font-bold" style="margin:0">${dep.name}</h3>
          <span class="pill">${dep.efpts?.length || 0} établissement(s)</span>
        </div>
        ${
          (dep.efpts?.length||0) === 0
            ? `<p class="side-muted">Pas d’établissement.</p>`
            : `
              <div style="max-height:60vh; overflow:auto; border:1px solid #e5e7eb; border-radius:10px;">
                <table>
                  <thead>
                    <tr>
                      <th style="width:38%">Nom</th>
                      <th style="width:18%">Téléphone</th>
                      <th style="width:34%">Adresse</th>
                      <th style="width:10%">Actions</th>
                    </tr>
                  </thead>
                  <tbody>${rows}</tbody>
                </table>
              </div>
            `
        }
      `;
    }

    function renderProgramsPanel(efpId){
      const dep = departments[currentDepId];
      if(!dep){ return; }
      const efp = (dep.efpts||[]).find(x => String(x.id) === String(efpId));
      if(!efp){
        sidePanelBody.innerHTML = `<em class="side-muted">Établissement introuvable.</em>`;
        return;
      }
      const progRows = (efp.programms||[]).map(p => `
        <tr><td>${p.nom ?? '-'}</td><td>${p.grade ?? '-'}</td></tr>
      `).join('');

      sidePanelBody.innerHTML = `
        <div class="flex items-center justify-between mb-2" style="gap:8px; flex-wrap:wrap;">
          <div>
            <div class="text-sm side-muted">${dep.name}</div>
            <h3 class="text-lg font-bold" style="margin:0">${efp.nom}</h3>
          </div>
          <button class="btn secondary" data-action="back-dep">← Retour</button>
        </div>
        <div class="mb-3 side-muted" style="display:grid; grid-template-columns:1fr; gap:4px;">
          <div><b>Tél. :</b> ${efp.tel ?? '-'}</div>
          <div><b>Adresse :</b> ${efp.adresse ?? '-'}</div>
        </div>
        <div style="max-height:60vh; overflow:auto; border:1px solid #e5e7eb; border-radius:10px;">
          <table>
            <thead>
              <tr><th style="width:70%">Filières/Métiers</th><th style="width:30%">Niveau</th></tr>
            </thead>
            <tbody>
              ${
                (efp.programms && efp.programms.length)
                  ? progRows
                  : `<tr><td colspan="2" class="side-muted" style="text-align:center; padding:16px;">Aucune formation renseignée.</td></tr>`
              }
            </tbody>
          </table>
        </div>
      `;
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
      if(mapImage.complete){ createCountBadges(); }
    }
    document.addEventListener('DOMContentLoaded', init);
  </script>
</body>
</html>

