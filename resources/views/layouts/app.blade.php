<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">

        <style>
          * {
            font-family: 'Nunito', sans-serif;
          }

          .card-image{
            position: relative;
          }
          .card-image-tag{
            position: absolute;
            top: 1rem;
            left: 1rem;
            z-index: 10;
          }

          .card-image-tag.is-right{
            left: auto;
            right: 1rem;
          }

          .is-image-fit{
            object-fit: cover;
            object-position: center;
          }
        </style>
    </head>
    <body>
      @yield('content')
    </body>
</html>
