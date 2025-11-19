<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Carte interactive des établissements du Sénégal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    :root{
      --bg:#f5f7fb; --fg:#1a5276; --muted:#6b7b8c; --card:#ffffff;
      --accent:#0e7abf; --badge:#e74c3c; --ring:rgba(14,122,191,.15);
    }
    *{box-sizing:border-box}
    body{
      font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
      background: var(--bg); margin:0; padding:24px; color:#1d2733;
    }
    h1{margin:0 0 10px; color:var(--fg); font-weight:800;}
    .sub{color:var(--muted); margin-bottom:16px}

    .layout{
      display:grid; gap:16px;
      grid-template-columns: 1fr 340px;
    }
    @media (max-width: 980px){ .layout{grid-template-columns:1fr} }

    .card{
      background:var(--card); border-radius:14px;
      box-shadow: 0 10px 24px rgba(16,24,40,.08);
      padding:14px;
    }
    .stats{
      display:flex; gap:12px; flex-wrap:wrap; margin-bottom:8px;
    }
    .pill{
      background:#eef6fd; color:#0b66a3; padding:8px 12px; border-radius:999px;
      font-size:14px; display:inline-flex; align-items:center; gap:8px;
    }
    .pill b{font-weight:800; font-size:15px}
    .map-wrap{ position:relative; display:inline-block; width:100%; }
    .map-image{ width:100%; height:auto; display:block; border-radius:10px; }
    .map-image.highlight{ filter:brightness(1.05) drop-shadow(0 2px 10px rgba(0,0,0,.08)); transition:filter .2s }

    .tooltip{
      position:absolute; background:#0b1b28; color:#fff; padding:12px 14px;
      border-radius:10px; font-size:14px; line-height:1.35; pointer-events:none; z-index:10;
      max-width:min(320px, 70vw); box-shadow:0 12px 24px rgba(0,0,0,.25);
      display:none;
    }
    .tooltip h3{margin:0 0 6px; font-size:15px}
    .tooltip small{opacity:.8}
    .tooltip .list{max-height:220px; overflow:auto; margin-top:8px}
    .tooltip .list::-webkit-scrollbar{height:8px;width:8px}
    .tooltip .list::-webkit-scrollbar-thumb{background:#3b4a57;border-radius:8px}

    .region-badge{
      position:absolute; transform:translate(-50%,-50%);
      background:var(--badge); color:#fff; width:28px; height:28px;
      display:flex; align-items:center; justify-content:center;
      border-radius:50%; font-size:13px; font-weight:800;
      box-shadow:0 4px 12px rgba(231,76,60,.4); user-select:none;
    }
    .region-badge[data-hot="1"]{ background:#15a362; box-shadow:0 4px 12px rgba(21,163,98,.35) }

    /* Panneau Région (zone de droite) */
    .region-panel.card{ position:sticky; top:14px; align-self:start; }
    .rp-title{font-weight:800; color:var(--fg); margin:0 0 2px; font-size:18px}
    .rp-muted{color:var(--muted); margin:0 0 10px}
    .rp-total{
      display:flex; align-items:center; gap:10px; margin:8px 0 12px;
      padding:10px 12px; border:1px solid var(--ring); border-radius:10px;
      background:#f7fbff;
    }
    .rp-total b{font-size:22px}
    .rp-actions{display:flex; gap:8px; flex-wrap:wrap; margin-top:8px}
    .btn{
      border:1px solid #d8e6f3; background:#fff; padding:8px 12px; border-radius:10px;
      cursor:pointer; font-weight:600; color:#184b6a;
    }
    .btn.primary{ background:var(--accent); color:#fff; border-color:transparent }
    .list-clean{ list-style:none; margin:0; padding:0; }
    .list-clean li{ padding:6px 0; border-bottom:1px dashed #ecf1f6; font-size:14px }
    .empty{color:#98a6b5; font-style:italic}
  </style>
</head>
<body>
  <h1>Carte interactive des établissements de formation professionnelle</h1>
  <div class="sub">Survolez une région pour voir la liste. Cliquez pour “épingler” la région dans le panneau de droite.</div>

  <div class="stats">
    <span class="pill">Total établissements: <b id="total-all">0</b></span>
    <span class="pill">Régions couvertes: <b id="total-regions">0</b></span>
  </div>

  <div class="layout">
    <!-- Carte -->
    <div class="card">
      <div class="map-wrap">
        <img src="MapSenegal.png" usemap="#image-map" alt="Carte du Sénégal" class="map-image" id="mapImage">
        <div id="badges-container"></div>
        <div id="tooltip" class="tooltip"></div>
      </div>

      <map name="image-map" id="image-map">
        <!-- (zones d’origine) -->
        <area target="_self" alt="Dakar" coords="21,292,6,276,31,268,64,252,65,301,45,282,29,278,26,286" shape="poly" data-code="DK" data-center="20,280">
        <area target="_self" alt="Diourbel" coords="156,299,173,299,199,302,210,307,218,307,224,311,252,304,256,291,256,281,264,284,276,284,284,289,290,293,296,285,302,279,306,271,303,263,273,251,266,255,256,243,249,244,220,244,207,243,196,246,186,242,170,236,156,244,138,246,133,250,139,267,139,278,139,290,142,296" shape="poly" data-code="DB" data-center="200,280">
        <area target="_self" alt="Fatick"
          coords="115,375,131,324,150,309,150,299,195,301,210,306,220,306,227,312,252,305,259,283,278,285,288,289,289,299,282,307,279,311,268,309,265,318,258,326,247,330,241,319,228,330,219,329,205,331,188,340,181,349,175,360,187,365,197,370,190,378,189,384,200,386,195,404,192,411,203,423,206,434,207,443,150,442,133,434,137,424,119,413,119,390"
          shape="poly" data-code="FT" data-center="140,360">
        <area target="_self" alt="Kaffrine" coords="272,311,291,300,291,292,308,271,332,291,368,296,383,285,401,297,421,304,424,326,426,368,422,395,401,412,393,414,375,412,359,411,341,419,332,417,323,414,312,422,300,408,289,406,283,411,277,408,268,394,259,379,249,363,256,347,273,344" shape="poly" data-code="KF" data-center="350,350">
        <area target="_self" alt="Kaolack" coords="272,346,274,316,252,328,242,321,227,330,212,334,194,338,186,346,176,353,179,363,196,369,190,382,200,387,194,408,205,428,210,442,300,442,309,421,309,411,297,412,288,407,283,415,273,406,263,388,257,374,249,364,253,350" shape="poly" data-code="KL" data-center="250,400">
        <area target="_self" alt="Kédougou" coords="638,572,638,560,637,549,634,537,624,521,640,517,654,512,674,518,695,509,700,500,710,492,719,497,737,484,752,487,762,475,765,467,777,467,800,473,812,469,824,474,834,465,850,470,859,481,866,496,873,512,888,528,882,540,886,560,880,566,881,581,885,591,888,605,884,610,846,608,833,616,808,607,798,613,785,610,761,617,740,615,721,613,710,614,700,606,689,607,667,594,660,600,647,602,640,599,646,580" shape="poly" data-code="KD" data-center="800,550">
        <area target="_self" alt="Kolda" coords="322,475,333,468,342,450,354,439,362,449,375,460,386,460,394,462,408,471,415,473,427,476,435,480,445,481,452,487,467,491,481,493,494,490,504,483,524,480,536,475,538,464,535,454,540,449,540,457,548,459,548,469,554,469,555,482,562,487,568,496,567,505,571,513,577,519,582,530,587,543,587,555,588,569,599,569,558,572,486,573,350,572,350,551,352,541,348,529,342,523,336,516,332,501,324,496,321,487" shape="poly" data-code="KO" data-center="400,500">
        <area target="_self" alt="Louga" coords="122,175,149,126,184,124,207,100,253,75,295,111,309,109,316,95,330,95,340,102,350,105,381,103,399,118,417,105,433,116,434,123,420,129,418,141,407,156,408,170,402,178,425,190,439,190,430,211,422,219,397,223,399,272,392,291,380,283,368,297,330,295,317,280,307,271,302,263,295,265,280,262,260,251,266,255,250,242,233,245,211,247,202,244,198,229,186,216,165,192,152,198,146,210,140,217,136,207,124,200,119,195" shape="poly" data-code="LG" data-center="200,180">
        <area target="_self" alt="Matam" coords="427,306,411,306,393,297,397,283,402,277,398,227,420,223,434,212,437,192,425,194,402,183,405,174,404,160,416,146,416,133,430,126,440,129,441,139,453,150,451,181,455,188,473,185,483,181,482,175,486,170,507,163,515,118,534,96,547,93,551,76,556,85,580,78,595,87,601,102,611,122,613,132,623,143,622,149,643,163,640,171,649,173,655,170,660,178,660,186,665,193,675,195,676,203,673,209,680,213,689,223,702,232,709,248,712,266,706,284,689,298,676,305,653,306,627,303,592,317,581,324,546,326,527,307,511,305,500,310,476,304,456,299" shape="poly" data-code="MT" data-center="450,250">
        <area target="_self" alt="Saint-Louis" coords="148,126,153,90,163,90,159,73,167,64,175,56,184,26,196,21,210,17,216,22,226,24,236,17,264,26,275,28,275,20,289,21,299,14,307,16,325,16,336,17,345,11,354,9,358,0,365,3,372,-1,379,4,408,5,441,5,450,4,465,6,469,13,512,47,518,62,536,77,550,74,548,88,531,100,519,115,515,128,511,149,510,156,506,161,495,162,489,164,484,168,484,175,475,182,455,187,451,169,454,152,445,140,440,130,430,115,421,106,414,105,398,117,383,101,346,105,334,95,324,92,316,96,311,97,309,107,295,113,252,75,238,84,208,99,200,108,187,118,176,123" shape="poly" data-code="SL" data-center="250,50">
        <area target="_self" alt="Sédhiou" coords="245,499,254,497,255,483,257,476,275,475,287,474,295,467,314,472,319,475,320,493,325,499,331,507,335,513,341,523,344,533,349,542,348,556,348,567,326,579,312,589,276,606,248,604,228,574,227,564,231,534,241,513" shape="poly" data-code="SD" data-center="300,550">
        <area target="_self" alt="Tambacounda" coords="591,569,604,576,622,577,637,576,638,570,639,556,634,549,633,538,627,532,622,519,632,518,643,520,654,515,676,522,698,510,699,503,707,496,717,499,738,486,748,489,749,480,759,480,759,466,776,464,787,472,796,474,809,472,813,460,798,444,786,424,803,410,804,394,806,384,798,382,798,362,796,348,783,340,781,330,766,325,767,309,775,296,772,285,761,273,744,264,732,256,727,242,715,231,702,227,710,235,711,250,712,265,706,281,696,293,684,298,663,303,643,303,622,299,585,322,540,324,530,310,522,304,502,305,498,310,478,307,460,299,451,297,443,302,430,303,422,316,424,331,426,344,428,361,429,381,424,396,411,403,402,411,396,417,401,434,418,435,429,431,444,439,450,454,469,459,483,453,497,443,510,444,529,450,543,452,550,467,561,473,560,487,569,504,576,517,588,539,589,563" shape="poly" data-code="TC" data-center="600,400">
        <area target="_self" alt="Thiès" coords="62,257,122,182,124,191,131,202,139,214,143,219,156,199,169,194,193,222,202,228,202,240,202,246,195,247,188,243,179,238,168,236,158,240,143,248,130,251,135,261,139,273,137,284,140,294,150,297,148,311,138,318,131,321,126,336,122,345,120,356,120,361,115,366,117,374,100,356,96,345,93,329,80,321,72,314,65,306,63,299,65,270" shape="poly" data-code="TH" data-center="100,250">
        <area target="_self" alt="Ziguinchor" coords="242,505,231,533,229,551,224,566,227,576,234,587,242,600,238,606,224,603,204,604,176,612,161,617,147,619,133,619,126,616,121,613,115,604,120,588,117,575,113,567,124,509,126,503" shape="poly" data-code="ZG" data-center="200,530">
      </map>
    </div>

    <!-- Zone Région (total + liste épinglée) -->
    <aside class="region-panel card" id="regionPanel">
      <h2 class="rp-title">Région</h2>
      <p class="rp-muted">Survolez la carte et cliquez pour épingler une région ici.</p>

      <div class="rp-total">
        <span>Total d’établissements:</span>
        <b id="rp-count">0</b>
      </div>

      <div id="rp-region-name" class="pill" style="display:none;"></div>

      <ul id="rp-list" class="list-clean">
        <li class="empty">Aucune région sélectionnée.</li>
      </ul>

      <div class="rp-actions">
        <button class="btn" id="btnUnpin" style="display:none;">Désépingler</button>
        <button class="btn primary" id="btnCopy" style="display:none;">Copier la liste</button>
      </div>
    </aside>
  </div>

  <script>
    // ---- Données (inchangées) ----
    const establishments = {
      "DAKAR":[
        {"name":"CFP MEDINA","lat":14.6831784,"lng":-17.4432914},
        {"name":"CFPC Delafosse","lat":14.68580,"lng":-17.46038},
        {"name":"LTID","lat":14.68611,"lng":-17.45814},
        {"name":"LTCD","lat":14.684855,"lng":-17.460241},
        {"name":"CFMPL","lat":14.698650,"lng":-17.431186},
        {"name":"CNQP","lat":14.698314,"lng":-17.432090},
        {"name":"ENFEFS","lat":14.682319,"lng":-17.441830},
        {"name":"CSFPIAA","lat":14.67371,"lng":-17.46325},
        {"name":"CEDT G-15","lat":14.69870,"lng":-17.45052},
        {"name":"CFPJ/YMCA","lat":14.7246326,"lng":-17.4297778},
        {"name":"ICCM","lat":14.4216814,"lng":-17.267502},
        {"name":"CNCPI","lat":14.6841518,"lng":-17.4585598},
        {"name":"CFPT Séné./Japon","lat":14.44332131,"lng":-17.281044264},
        {"name":"CFP Dakar","lat":14.73823,"lng":-17.45713},
        {"name":"CFP Ouakam","lat":14.72339,"lng":-17.49317},
        {"name":"CFP Pikine","lat":14.743524,"lng":-17.384516},
        {"name":"CFP Thiaroye","lat":14.743524,"lng":-17.384516},
        {"name":"LSLL","lat":14.7772,"lng":-17.379503},
        {"name":"CFP Niague","lat":14.79340,"lng":-17.31388},
        {"name":"CFP Rufisque","lat":14.714637,"lng":-17.272093},
        {"name":"CFP Bargny","lat":14.695706,"lng":-17.226763},
        {"name":"CSFP-BTP","lat":14.712338,"lng":-17.169526},
        {"name":"CSFP-MEM","lat":14.425266,"lng":-16.972045},
        {"name":"CFP TOURISME DIAMNIADIO","lat":14.425266,"lng":-16.972045},
        {"name":"CFP AVICULTURE DIAMNIADIO","lat":14.425266,"lng":-16.972045},
        {"name":"CFP Sébikotane","lat":14.726035,"lng":-17.119701}
      ],
      "DIOURBEL":[
        {"name":"CFP Diourbel","lat":14.661296,"lng":-16.228864},
        {"name":"LTAB Diourbel","lat":14.6518131,"lng":-16.2479852},
        {"name":"CFP Bambey","lat":14.698856,"lng":-16.458612},
        {"name":"CFP Ndangalma","lat":14.75614,"lng":-16.57109},
        {"name":"CFP Ndoulo","lat":14.731363,"lng":-16.117849},
        {"name":"CFP Mbacké","lat":14.799085,"lng":-15.908668},
        {"name":"CDFP Mbacké","lat":14.794954,"lng":-15.907497},
        {"name":"CFP Touba","lat":14.8681391,"lng":-15.8216368},
        {"name":"CFP Taif","lat":14.790823,"lng":-15.639313}
      ],
      "FATICK":[
        {"name":"CFP Fatick","lat":14.44335,"lng":-16.40211},
        {"name":"LTP Fatick","lat":14.349836,"lng":-16.402450},
        {"name":"CFP Niakhar","lat":14.483209,"lng":-16.399045},
        {"name":"CFP Toukar","lat":14.33969,"lng":-16.41136},
        {"name":"CFP Diofior","lat":14.187791,"lng":-16.667532},
        {"name":"CFP Djilor Saloum","lat":14.061315,"lng":-16.336004},
        {"name":"CFP Sokone","lat":13.829233,"lng":-16.382560},
        {"name":"CFP Foundiougne","lat":14.124498,"lng":-16.464428},
        {"name":"CFP Diakhao","lat":14.454256,"lng":-16.298632},
        {"name":"CFP Gossas","lat":14.485461,"lng":-16.063332},
        {"name":"CFP Dionewar","lat":14.52025,"lng":-16.28186},
        {"name":"CFP Faoye","lat":14.226501,"lng":-16.576977},
        {"name":"CFP Loul Sessene","lat":14.312118,"lng":-16.606309}
      ],
      "KAFFRINE":[
        {"name":"CNFMETP Kaffrine","lat":14.1048283,"lng":-15.5424721},
        {"name":"CFP Kaffrine","lat":14.1037084,"lng":-15.5503285},
        {"name":"CFP Koungheul","lat":13.98005,"lng":-14.78817},
        {"name":"CFP Birkelane","lat":14.1035435,"lng":-15.5641079}
      ],
      "KAOLACK":[
        {"name":"CFP Kaolack","lat":14.796768,"lng":-16.919042},
        {"name":"LTCEAN","lat":14.15750,"lng":-16.07982},
        {"name":"CFP Porokhane","lat":13.702851,"lng":-15.820822},
        {"name":"CFP Nioro du Rip","lat":13.443444,"lng":-15.45555},
        {"name":"CFP Mbadakhoune","lat":14.2080511,"lng":-16.0163014},
        {"name":"CFP Guinguinéo","lat":14.272058,"lng":-15.946700}
      ],
      "KEDOUGOU":[
        {"name":"CFP Kedougou","lat":12.557149,"lng":-12.5563079},
        {"name":"CFP Salemata","lat":12.6333633,"lng":-12.81994},
        {"name":"LTIM Mamba Guiraasy","lat":12.56071,"lng":-12.17467}
      ],
      "KOLDA":[
        {"name":"CFP Kolda","lat":12.8806991,"lng":-14.9503931},
        {"name":"CRFP Kolda","lat":12.8851932,"lng":-14.9536666},
        {"name":"CFP Dabo","lat":12.91945,"lng":-16.24923},
        {"name":"CFP Médina yoro foulah","lat":13.29786,"lng":-14.71504},
        {"name":"LETFP","lat":12.8714269,"lng":-14.9032206},
        {"name":"CFP Sare yoba","lat":12.7686942,"lng":-15.0994015},
        {"name":"CFP Kounkane","lat":13.146928,"lng":-14.079476},
        {"name":"CFP Vélingara","lat":13.146928,"lng":-14.111676},
        {"name":"CFP Médina gounass","lat":13.115184,"lng":-13.764605}
      ],
      "LOUGA":[
        {"name":"CFP LOUGA","lat":15.626608,"lng":-16.233732},
        {"name":"CEFAM LOUGA","lat":15.624756,"lng":-16.224783},
        {"name":"CFP LINGUERE","lat":15.397649,"lng":-15.116792},
        {"name":"CFP KEBEMER","lat":15.368642,"lng":-16.441103},
        {"name":"CFP DAHRA DJOLOF","lat":15.36403,"lng":-15.48835},
        {"name":"CFP KOKI","lat":15.52789,"lng":-15.98950},
        {"name":"CFP NGOURANE","lat":15.443214,"lng":-16.292406},
        {"name":"CFP THIEPPE","lat":15.70525,"lng":-16.53397}
      ],
      "MATAM":[
        {"name":"CFP MATAM","lat":16.65539,"lng":-13.25755},
        {"name":"CFP Ourossogui","lat":15.609500,"lng":-13.329500},
        {"name":"CFP Agnam Civol","lat":15.9936638,"lng":-13.667206},
        {"name":"CFP Waounde","lat":15.2614,"lng":-12.8599},
        {"name":"CFP Sinthiou Bamambe","lat":15.3791,"lng":-13.1262},
        {"name":"CFP Kanel","lat":15.490763,"lng":-13.1866359},
        {"name":"CFP Ranerou","lat":15.608046,"lng":-13.329672}
      ],
      "SAINT-LOUIS":[
        {"name":"CFP DAGANA","lat":16.506194,"lng":-15.516274},
        {"name":"CDFP/Richard Toll","lat":16.454966,"lng":-15.679082},
        {"name":"CFP Aéré Lao","lat":16.397860,"lng":-14.328763},
        {"name":"CRFP SAINT-LOUIS","lat":16.019754,"lng":-16.489693},
        {"name":"LTAP","lat":16.01934,"lng":-16.49066},
        {"name":"CFP Saint-Louis","lat":16.019853,"lng":-16.489945},
        {"name":"CDFP Podor","lat":16.645667,"lng":-14.954447},
        {"name":"CFP Podor","lat":16.660494,"lng":-14.960128},
        {"name":"CFP Mboumba","lat":16.18980,"lng":-14.01095},
        {"name":"CFP Gae","lat":16.56906,"lng":-15.44573},
        {"name":"CRMT de Saint-Louis","lat":15.965526,"lng":-16.463062}
      ],
      "SEDHIOU":[
        {"name":"CFP Sedhiou","lat":12.710201,"lng":-15.565197},
        {"name":"CFPI Sedhiou","lat":12.685521,"lng":-15.557871},
        {"name":"CFP Forestier Boukiling","lat":13.03896,"lng":-15.68655}
      ],
      "TAMBACOUNDA":[
        {"name":"CFP Tambacouda","lat":13.7816608,"lng":-13.6676813},
        {"name":"CFP Forameca","lat":13.78136,"lng":-13.66673},
        {"name":"LETFPT","lat":13.75458,"lng":-13.68825},
        {"name":"CFP Goudiry","lat":14.1949801,"lng":-12.7056515},
        {"name":"CFP KIDIRA","lat":14.500000,"lng":-12.300000},
        {"name":"CFP 1 Bakel","lat":14.90796,"lng":-12.46027},
        {"name":"CFP 2 Bakel","lat":14.9229738,"lng":-12.4584808}
      ],
      "THIES":[
        {"name":"CEP THIES","lat":14.796768,"lng":-16.919042},
        {"name":"CAP ENFEFS","lat":14.77502,"lng":-16.87953},
        {"name":"CNAFP THIES","lat":14.77539,"lng":-16.87934},
        {"name":"CFP THIES","lat":14.7925211,"lng":-16.9386896},
        {"name":"LTFXND","lat":14.81460,"lng":-16.93508},
        {"name":"CFP LALANE","lat":14.85263,"lng":-16.89290},
        {"name":"CFP TIVAOUNE","lat":14.955896,"lng":-16.818033},
        {"name":"CFP TAIBA NDIAYE","lat":15.034863,"lng":-16.87579},
        {"name":"CFP MONT ROLLAND","lat":14.911392,"lng":-16.997696},
        {"name":"CFP KHOMBOLE","lat":14.761815,"lng":-16.690271},
        {"name":"CFP THIADIAYE","lat":14.253333,"lng":-16.423052},
        {"name":"LETFP SANDIARA","lat":14.253333,"lng":-16.423052},
        {"name":"CFP NDIAGANIO","lat":14.54677,"lng":-16.72876},
        {"name":"CFP JOAL FADIOUTH","lat":14.85919,"lng":-16.494438},
        {"name":"CFP MBOUR","lat":14.244647,"lng":-16.573948},
        {"name":"CFP NGUEKHOKH","lat":14.508160,"lng":-17.007971},
        {"name":"CFP FISSEL","lat":14.321163,"lng":-16.37900}
      ],
      "ZIGUINCHOR":[
        {"name":"CFP ZIGUINCHOR","lat":12.586670,"lng":-16.273451},
        {"name":"CRFP ZIGUINCHOR","lat":12.585371,"lng":-16.261970},
        {"name":"CFP OUSSOUYE","lat":12.489258,"lng":-16.545090},
        {"name":"CFP KOUBANAO","lat":12.678221,"lng":-16.073452},
        {"name":"CFP SINDIAN","lat":12.96573,"lng":-16.18146},
        {"name":"CFP BAILA","lat":12.89414,"lng":-16.34445},
        {"name":"CFP ABENE","lat":12.999087,"lng":-16.726555},
        {"name":"LTAEB","lat":12.789826,"lng":-16.217518},
        {"name":"CNFMETP GUERINA","lat":12.76262,"lng":-16.23796},
        {"name":"CFP BIGNONA","lat":12.81186,"lng":-16.228},
        {"name":"LYCEE TECHNIQUE AGRICOLE EMILE BADIANE","lat":12.81186,"lng":-16.228},
        {"name":"CFP ALBADAR","lat":13.00484,"lng":-16.69844},
        {"name":"CFP FANDA","lat":12.574488,"lng":-16.141805},
        {"name":"CFP TENDOUCK","lat":12.72414,"lng":-16.45556}
      ]
    };

    // ---------- Helpers DOM ----------
    const mapImage = document.getElementById('mapImage');
    const tooltip = document.getElementById('tooltip');
    const badgesContainer = document.getElementById('badges-container');
    const areas = Array.from(document.querySelectorAll('area'));

    const rpTitle = document.querySelector('.rp-title');
    const rpMuted = document.querySelector('.rp-muted');
    const rpCount = document.getElementById('rp-count');
    const rpNamePill = document.getElementById('rp-region-name');
    const rpList = document.getElementById('rp-list');
    const btnUnpin = document.getElementById('btnUnpin');
    const btnCopy = document.getElementById('btnCopy');

    let pinnedRegion = null;

    // ---------- Normaliser clé région ----------
    function getRegionKey(regionName){
      return regionName.toUpperCase()
        .normalize("NFD").replace(/[\u0300-\u036f]/g,"")
        .replace(/È/g,"E").replace(/É/g,"E");
    }

    // ---------- Stats globales ----------
    function updateGlobalStats(){
      const regionKeys = Object.keys(establishments);
      const total = regionKeys.reduce((s,k)=> s + (establishments[k]?.length||0), 0);
      document.getElementById('total-all').textContent = total;
      document.getElementById('total-regions').textContent = regionKeys.length;
    }

    // ---------- Géométrie pour placer les badges ----------
    function parseCoords(area){
      return area.getAttribute('coords')
        .split(',').map(Number)
        .reduce((acc, n, i, a) => (i%2===0 ? (acc.push({x:a[i], y:a[i+1]}), acc) : acc), []);
    }

    function polygonCentroid(points){
      let A=0, cx=0, cy=0, n=points.length;
      for(let i=0;i<n;i++){
        const p=points[i], q=points[(i+1)%n];
        const cross = p.x*q.y - q.x*p.y;
        A += cross; cx += (p.x+q.x)*cross; cy += (p.y+q.y)*cross;
      }
      A *= 0.5;
      if (Math.abs(A) < 1e-7){
        const xs=points.map(p=>p.x), ys=points.map(p=>p.y);
        return { x:(Math.min(...xs)+Math.max(...xs))/2, y:(Math.min(...ys)+Math.max(...ys))/2 };
      }
      return { x: cx/(6*A), y: cy/(6*A) };
    }

    function pointInPolygon(pt, pts){
      let inside=false;
      for(let i=0,j=pts.length-1;i<pts.length;j=i++){
        const xi=pts[i].x, yi=pts[i].y, xj=pts[j].x, yj=pts[j].y;
        const intersect = ((yi>pt.y)!=(yj>pt.y)) && (pt.x < (xj-xi)*(pt.y-yi)/(yj-yi)+xi);
        if(intersect) inside=!inside;
      }
      return inside;
    }

    function robustCenter(points){
      const c = polygonCentroid(points);
      if (pointInPolygon(c, points)) return c;
      const xs=points.map(p=>p.x), ys=points.map(p=>p.y);
      return { x:(Math.min(...xs)+Math.max(...xs))/2, y:(Math.min(...ys)+Math.max(...ys))/2 };
    }

    function getScales(img){
      // Utilise les dimensions naturelles de l'image pour éviter les décalages
      return { sx: img.clientWidth / img.naturalWidth, sy: img.clientHeight / img.naturalHeight };
    }

    // ---------- Badges : unique createCountBadges ----------
    function createCountBadges(){
      if (!mapImage.naturalWidth) return; // sécurité
      const { sx, sy } = getScales(mapImage);
      badgesContainer.innerHTML = '';
      areas.forEach(area=>{
        const key = getRegionKey(area.alt);
        const count = establishments[key]?.length || 0;
        if(count <= 0) return;

        // 1) centre calculé depuis le polygone
        const pts = parseCoords(area);
        let c = robustCenter(pts);

        // 2) override manuel si data-center est présent
        const dc = area.getAttribute('data-center');
        if (dc && dc.includes(',')) {
          const [dx,dy] = dc.split(',').map(Number);
          if (!Number.isNaN(dx) && !Number.isNaN(dy)) c = {x:dx, y:dy};
        }

        // 3) placement avec échelle X/Y
        const badge = document.createElement('div');
        badge.className = 'region-badge';
        badge.textContent = count;
        badge.style.left = (c.x * sx) + 'px';
        badge.style.top  = (c.y * sy) + 'px';
        if (count >= 10) badge.setAttribute('data-hot','1');
        badgesContainer.appendChild(badge);
      });
    }

    function initBadgesWhenReady(){
      if (mapImage.complete && mapImage.naturalWidth) {
        createCountBadges();
      } else {
        mapImage.addEventListener('load', createCountBadges, { once:true });
      }
    }

    // ---------- Tooltip ----------
    function showTooltip(regionName, e){
      const key = getRegionKey(regionName);
      const list = establishments[key] || [];
      if(list.length===0) return;

      const title = `<h3>${regionName}</h3><small>${list.length} établissement(s)</small>`;
      const items = list.map(est=>`• ${est.name}`).join('<br>');
      tooltip.innerHTML = `${title}<div class="list">${items}</div>`;
      tooltip.style.display='block';
      positionTooltip(e);
      mapImage.classList.add('highlight');
    }
    function hideTooltip(){
      if(!pinnedRegion) mapImage.classList.remove('highlight');
      tooltip.style.display='none';
    }
    function positionTooltip(e){
      const pad = 16;
      const rect = mapImage.getBoundingClientRect();
      const tw = Math.min(320, window.innerWidth*0.7);
      const x = Math.min(e.pageX + pad, window.scrollX + rect.right - tw - pad);
      const y = Math.min(e.pageY + pad, window.scrollY + rect.bottom - 180);
      tooltip.style.left = x+'px';
      tooltip.style.top  = y+'px';
    }

    // ---------- Panneau Région ----------
    function fillRegionPanel(regionName){
      const key = getRegionKey(regionName);
      const list = establishments[key] || [];
      rpTitle.textContent = 'Région';
      rpMuted.style.display = 'none';
      rpCount.textContent = list.length;
      rpNamePill.style.display = 'inline-flex';
      rpNamePill.textContent = regionName;

      rpList.innerHTML = list.length
        ? list.map(e=>`<li>${e.name}</li>`).join('')
        : `<li class="empty">Aucun établissement enregistré.</li>`;

      btnUnpin.style.display = 'inline-block';
      btnCopy.style.display = list.length ? 'inline-block' : 'none';
    }
    function clearRegionPanel(){
      rpTitle.textContent = 'Région';
      rpMuted.style.display = '';
      rpCount.textContent = '0';
      rpNamePill.style.display = 'none';
      rpList.innerHTML = `<li class="empty">Aucune région sélectionnée.</li>`;
      btnUnpin.style.display = 'none';
      btnCopy.style.display = 'none';
    }

    // ---------- Events sur zones ----------
    areas.forEach(area=>{
      area.addEventListener('mouseover', e=> {
        if(!pinnedRegion) showTooltip(area.alt, e);
      });
      area.addEventListener('mousemove', positionTooltip);
      area.addEventListener('mouseout', ()=> {
        if(!pinnedRegion) hideTooltip();
      });
      area.addEventListener('click', e=>{
        e.preventDefault();
        pinnedRegion = area.alt;
        hideTooltip();
        mapImage.classList.add('highlight');
        fillRegionPanel(pinnedRegion);
      });
    });

    // ---------- Actions panneau ----------
    btnUnpin.addEventListener('click', ()=>{
      pinnedRegion = null;
      mapImage.classList.remove('highlight');
      clearRegionPanel();
    });
    btnCopy.addEventListener('click', ()=>{
      const lines = Array.from(rpList.querySelectorAll('li'))
        .map(li=>li.textContent.trim())
        .filter(v=>v && v!=='Aucune région sélectionnée.');
      const text = `${rpNamePill.textContent} — ${lines.length} établissements\n` + lines.map(l=>`- ${l}`).join('\n');
      navigator.clipboard.writeText(text).then(()=>{
        btnCopy.textContent = 'Copié ✔';
        setTimeout(()=> btnCopy.textContent='Copier la liste', 1200);
      });
    });

    // ---------- Init ----------
    window.addEventListener('load', ()=>{
      updateGlobalStats();
      initBadgesWhenReady();
    });
    window.addEventListener('resize', createCountBadges);
  </script>
</body>
</html>
