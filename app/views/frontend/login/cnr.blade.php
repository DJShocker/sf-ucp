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
            SF-UCP
          </h4>
          <!-- Begin login form -->
          {{Form::open(['url' => '/auth/new', 'class' => 'form-horizontal', 'method' => 'post'])}}

            <div class="form-group {{count($errors->all()) ? 'has-error' : ''}}">
              {{Form::label('username', 'Username', ['class'=>'control-label col-sm-3', 'style'=>'text-align: left;'])}}
              <div class="col-sm-9">
                {{Form::text('username', '', ['class' => 'form-control'])}}
              </div>
            </div>

            <div class="form-group {{count($errors->all()) ? 'has-error' : ''}}">
              {{Form::label('password', 'Password', ['class'=>'control-label col-sm-3', 'style'=>'text-align: left;'])}}
              <div class="col-sm-9">
                {{Form::password('password', ['class' => 'form-control'])}}

                @if(isset($errors))
                <ul style="display: block;" class="help-block list-unstyled">
                  @foreach($errors->all() as $error)
                  <li style="display: list-item;" class="required">{{$error}}</li>
                  @endforeach
                </ul>
                @endif
              </div>
            </div>

            {{Form::submit('Login', ['class'=>'btn btn-primary btn-block'])}}
          {{Form::close()}}
          <!-- End of login form -->

          <div class="text-center" style="padding-top: 14px">
            <a href="{{ route('register') }}" class="small">Create an account?</a>
          </div>

        </div>
        <div class="panel-footer">
          <div class="row">
            <div class="col-xs-6">
              <a href="{{ URL::to('//forum.sfcnr.com') }}" target="_blank" class="btn btn-block btn-default btn-sm"><i class="fa fa-group" style="font-size: 10px"></i> Forums</a>
            </div>
            <div class="col-xs-6">
              <a href="{{ URL::to('//donate.sfcnr.com') }}" target="_blank" class="btn btn-block btn-warning btn-sm"><i class="fa fa-dollar" style="font-size: 10px"></i> Donate</a>
            </div>
          </div>
        </div>
        <div class="panel-footer">
          <div class="text-center">&copy; SF-CNR, {{ date('Y') }}.</div>
        </div>
      </div>
    </div>
    <script type="text/javascript" src='{{URL::asset("/assets/js/jquery-1.10.2.min.js")}}'></script>
    <script type='text/javascript' src='{{URL::asset("/assets/js/bootstrap.min.js")}}'></script>
    <script type='text/javascript' src='{{URL::asset("/assets/js/placeholdr.js")}}'></script>
    <script type='text/javascript' src='{{URL::asset("/assets/js/application.js")}}'></script>
  </body>
</html>
