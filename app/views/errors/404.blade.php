<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>{{Config::get('irresistible.title')}} - Page Not Found</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="{{URL::to('/')}}/assets/css/styles.css" rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries. Placeholdr.js enables the placeholder attribute -->
    <!--[if lt IE 9]>
    <link rel="stylesheet" href="assets/css/ie8.css">
    <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
    <script type="text/javascript" src="/assets/plugins/charts-flot/excanvas.min.js"></script>
    <![endif]-->
  </head>
  <body>
      <div id='wrap'>
        <div class="container">

          <div class="row">
            <div class="col-md-12">
              <p class="text-center">
                <span class="text-info" style="font-size:4em;">Uh-oh!</span>
              </p>
              <p class="text-center">The page you tried to access for has been abducted by aliens.</p>
            </div>
            <div class="col-md-4 col-md-offset-4">
              <p class="text-center"><a href="{{URL::to('/')}}">Would you like to go back to home page?</a></p>
            </div>
          </div>

        </div> <!-- container -->
      </div> <!--wrap -->


    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/assets/js/jquery-1.10.2.min.js"><\/script>')</script>
  </body>
</html>
