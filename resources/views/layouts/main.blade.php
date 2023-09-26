<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta id="authId" content="{{ $authId }}">
  <meta id="csrf_token" name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="/build/assets/app-79303d09.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <!-- <script type="text/javascript" src="/js/profile_script.js"></script> -->
  <script type="text/javascript" src="/build/assets/app-38d1fa96.js" defer></script>

  </script>
  @vite('resources/css/app.css')
  @vite('resources/js/app.js')

  <title>@yield('page-title')</title>
</head>

<body class="">
  @yield('edit_info')
  @yield('picture_modal')
  @yield('up_modal')
  @yield('fl_modal')
  @include('inc.header')
  @yield('page-container')

</body>
</html>
<style media="screen">
  body{
    background-image: url('/188943.jpg');
    background-attachment: fixed;
    background-position: center;
    background-size: cover;
  }
</style>
