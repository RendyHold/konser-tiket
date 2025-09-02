<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title','Tiket Konser')</title>
  <style>
    body{font-family:system-ui,Segoe UI,Roboto,Arial,sans-serif;margin:24px}
    .container{max-width:760px;margin:auto}
    .card{border:1px solid #ddd;border-radius:8px;padding:16px;margin:12px 0}
    input,select,button{padding:10px;font-size:16px}
    .ok{color:#090}.err{color:#c00}.warn{color:#a60}
  </style>
</head>
<body>
  <div class="container">
    @yield('content')
  </div>
</body>
</html>
