<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Session expirée · {{ config('app.name') }}</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{font-family:'DM Sans',sans-serif;background:#F0F8FF;color:#0D1B3E;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px}
.card{width:100%;max-width:420px;background:#fff;border-radius:14px;padding:36px;box-shadow:0 18px 40px rgba(11,44,77,.08);text-align:center}
.ico{width:56px;height:56px;border-radius:50%;background:rgba(6,143,125,.1);color:#068F7D;display:flex;align-items:center;justify-content:center;margin:0 auto 18px;font-size:1.6rem}
h1{font-family:'Playfair Display',serif;font-size:1.5rem;margin-bottom:10px}
p{color:#4A6880;font-size:.92rem;line-height:1.7;margin-bottom:26px}
.btn{display:inline-block;width:100%;padding:14px;background:#068F7D;color:#fff;font-weight:700;border:none;border-radius:8px;cursor:pointer;text-decoration:none}
.btn:hover{background:#057365}
</style>
</head>
<body>
<div class="card">
  <div class="ico">⏱</div>
  <h1>Votre session a expiré</h1>
  <p>Pour votre sécurité, votre session a expiré après une période d'inactivité. Merci de vous reconnecter pour continuer.</p>
  <a class="btn" href="{{ route('login') }}">Se reconnecter</a>
</div>
</body>
</html>
