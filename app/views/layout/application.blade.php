<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{Config::get('irresistible.title')}} {{isset($pageheadTitle) ? ('- ' . ucfirst($pageheadTitle)) : ('')}}</title>
    <meta name="description" content="San Fierro Cops And Robbers User Control Panel">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="Shortcut Icon" href="{{URL::to('/')}}/favicon.ico" type="image/x-icon" />

    <!-- Core -->
    <link href="{{URL::to('/')}}/assets/css/styles.css" rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries. Placeholdr.js enables the placeholder attribute -->
    <!--[if lt IE 9]>
    <link rel="stylesheet" href="assets/css/ie8.css">
    <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
    <script type="text/javascript" src="assets/plugins/charts-flot/excanvas.min.js"></script>
    <![endif]-->

    <!-- Plugins -->
    <link rel='stylesheet' type='text/css' href='{{URL::to('/')}}/assets/plugins/form-toggle/toggles.css' />

  </head>
  <body class="static-header">
    <!--[if lt IE 7]>
      <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <!-- Begin Top navigation -->
    @include('partials/navigation')
    <!-- End of Top Navigation -->

    <!-- Begin MAIN -->
    <div id="page-container" role="main">
      <!-- Begin sidebar -->
      @include('partials/sidebar')
      <!-- End of sidebar -->
      <!-- Main contents -->
      <div id="page-content">
        <div id="wrap">
          <!-- Begin Page head -->
          @include('partials/pagehead')
          <!-- End of Page head -->
          <!-- Begin container contents -->
          @include('partials/messages')
          @yield('content')
          <!-- End of container contents -->
        </div>
      </div>
      <!-- End of main contents -->

      <!-- Begin footer -->
      @include('partials/footer')
      <!-- End of footer -->
    </div>
    <!-- End of MAIN -->

    @section('javascripts')
    <!--
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

    <script>!window.jQuery && document.write(unescape('%3Cscript src="assets/js/jquery-1.10.2.min.js"%3E%3C/script%3E'))</script>
    <script type="text/javascript">!window.jQuery.ui && document.write(unescape('%3Cscript src="assets/js/jqueryui-1.10.3.min.js'))</script>
    -->

    <!-- Making the page load faster this way -->
    <script type='text/javascript' src='{{URL::to('/')}}/assets/js/jquery-1.10.2.min.js'></script>
    <script type='text/javascript' src='{{URL::to('/')}}/assets/js/bootstrap.min.js'></script>
    <script type='text/javascript' src='{{URL::to('/')}}/assets/js/jquery.nicescroll.min.js'></script>
    <script type='text/javascript' src='{{URL::to('/')}}/assets/js/enquire.js'></script>
    <script type='text/javascript' src='{{URL::to('/')}}/assets/js/jquery.cookie.js'></script>
    <script type='text/javascript' src='{{URL::to('/')}}/assets/plugins/form-toggle/toggle.min.js'></script>
    <script type='text/javascript' src='{{URL::to('/')}}/assets/js/application.js'></script>
    <script type='text/javascript' src='{{URL::to('/')}}/assets/js/placeholdr.js'></script>

    <!-- Misc JS content (if there is any) -->
    @yield('jscontent')
    @show
  </body>
</html>
