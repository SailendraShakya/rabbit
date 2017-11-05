<!DOCTYPE html>
<html lang="en">
<head>
  <title>Rabbit Internet</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"> 

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="shortcut icon" href="https://rabbitinternet.com/wp-content/uploads/2015/09/xfavicon16-16.png.pagespeed.ic.o5h3AM6GAp.webp"/>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  <link rel="stylesheet" type="text/css" href="/css/main.css">

  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

  <script src="//maps.googleapis.com/maps/api/js?key=AIzaSyD6T6BYnfeGxcz0yiN4lM8WNMwOil7u64s&libraries=places" async
  defer></script>
  <script type="text/javascript" src="/js/main.js"></script>
</head>
<body>
  <div class="container">
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <span class="navbar-brand">
            <a href="{{ url('/') }}">
              <img style="max-width:100px; margin-top: -7px;"
              src="RabbitInternet.png">
            </a>
          </span>
        </div>
      </div>
    </nav>
    @yield('content')
  </div>
</body>
</html>
