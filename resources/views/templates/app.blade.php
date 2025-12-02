<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title>Bakpia Pathok Agung - @yield('title')</title>

  {{-- Icon Webpage --}}
  <link rel="icon" href="{{ asset('images/symbol.png') }}">

  {{-- Font (opsional) --}}
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

  {{-- CSS Bootstrap --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  {{-- Bootstrap Icons --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  {{-- File CSS Kustom Anda --}}
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">

  <style>
    body {
      font-family: 'Poppins', system-ui, -apple-system, Segoe UI, Roboto, 'Helvetica Neue', Arial, 'Noto Sans', 'Apple Color Emoji', 'Segoe UI Emoji';
      background-color: #fbf3df;
    }

    .payment-box {
      background-color: #f9f3e2;
      border: 1px solid #d6c29e;
      border-radius: 10px;
      padding: 40px;
      max-width: 500px;
      margin: 80px auto;
      text-align: center;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .payment-box img.qris-logo {
      width: 70px;
      margin: 10px 0 20px;
    }

    .payment-box table {
      margin: 20px auto;
      text-align: left;
      width: 80%;
    }

    .payment-box table td {
      padding: 4px 0;
    }

    .payment-box .btn-status {
      background-color: #000;
      color: #fff;
      font-weight: 600;
      border-radius: 10px;
      padding: 12px 20px;
      margin-top: 20px;
      border: none;
      cursor: default;
    }

    /* {{-- Menambahkan beberapa style untuk link produk dan hover effect --}} */
    .product-link {
      text-decoration: none;
      color: inherit;
      display: block;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .product-link:hover .product-card {
      transform: translateY(-5px);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }
    .section-header {
    font-size: 22px;
    font-weight: 700;
    color: #3e2a1a;
    margin-bottom: 20px;
}
.thumb-img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid transparent;
    cursor: pointer;
    transition: .2s;
}

.thumb-img:hover {
    border-color: #c49a6c;
    transform: scale(1.05);
}

  </style>

</head>

<body class="d-flex flex-column min-vh-100">

  <div class="flex-grow-1">

    @include('includes.header')

    <div class="container bg-cream-custom">
      @yield('content')
    </div>

  </div>

  @include('includes.footer')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

</body>

</html>