<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>{{Config::get('irresistible.title')}} {{isset($pageheadTitle) ? ('- ' . ucfirst($pageheadTitle)) : ('')}}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="San Fierro Cops And Robbers User Control Panel">
    <link rel="Shortcut Icon" href="{{URL::to('/')}}/favicon.ico" type="image/x-icon" />

    <link href='http://fonts.googleapis.com/css?family=Montserrat|Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{URL::asset('assets/css/styles.css')}}">
  </head>
 <body class="focusedform">
    <div class="verticalcenter">
      <div class="panel panel-primary">
        <div class="panel-body">
          <h4 class="text-center">
            SF-UCP<br>
          </h4>

          <div class="text-center">
            <h3><a href="samp://{{ Config::get('irresistible.gaming') }}:7777">{{ Config::get('irresistible.gaming') }}:7777</a></h3>

            <p style="padding-top: 14px">The user control panel can only be accessed by users registered within our SA-MP server.</p>
            <p style="padding-top: 14px">{{ $serverPlayers }} players are currently online at the moment.</p>
            <p class="small" style="padding-top: 14px"><a href="{{ URL::to('/') }}"><i class="fa fa-long-arrow-left"></i> Go back</a></p>
          </div>
          <!-- End of login form -->
        </div>
        <div class="panel-footer">
          <div class="text-center">&copy; IrresistibleGaming, 2011.</div>
        </div>
      </div>
    </div>
    <script type="text/javascript" src='{{URL::asset("/assets/js/jquery-1.10.2.min.js")}}'></script>
    <script type='text/javascript' src='{{URL::asset("/assets/js/bootstrap.min.js")}}'></script>
    <script type='text/javascript' src='{{URL::asset("/assets/js/placeholdr.js")}}'></script>
    <script type='text/javascript' src='{{URL::asset("/assets/js/application.js")}}'></script>
  </body>
</html>
