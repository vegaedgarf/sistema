<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>{{ config('app.name', 'Corpo System') }}</title>

  {{-- CoreUI + Bootstrap 5 --}}
  <link href="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.1.0/dist/css/coreui.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@coreui/icons@3.0.1/css/free.min.css" rel="stylesheet">

  {{-- Archivos Vite --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
      body {
          background: linear-gradient(135deg, #343a40, #212529);
          display: flex;
          align-items: center;
          justify-content: center;
          min-height: 100vh;
      }
      .auth-card {
          max-width: 420px;
          width: 100%;
          border-radius: 1rem;
          box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.2);
      }
      .brand {
          font-size: 1.5rem;
          font-weight: 600;
      }
  </style>
</head>
<body>
  <div class="container">
    <div class="card auth-card mx-auto">
      <div class="card-body p-4">
        <div class="text-center mb-4">
          <i class="cil-fire font-2xl text-danger"></i>
          <div class="brand text-dark mt-2">{{ config('app.name', 'Corpo System') }}</div>
        </div>

        {{-- Contenido dinámico del formulario --}}
        @yield('content')

      </div>
    </div>
    <div class="text-center mt-3 text-white-50">
      <small>© {{ date('Y') }} Corpo System — Todos los derechos reservados</small>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.1.0/dist/js/coreui.bundle.min.js"></script>
</body>
</html>
