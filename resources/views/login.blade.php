<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<!--    <meta name="viewport" content="width=device-width, initial-scale=1">  -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login SGSI</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ URL::asset('css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ URL::asset('css/signin.css')}}" rel="stylesheet">

    <script src="{{ URL::asset('js/ie-emulation-modes-warning.js')}}"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @include('includes.styles')
    <link href="{{ URL::asset('css/login.css')}}" rel="stylesheet">
  </head>

  <body>

    <div id="container">
    <div id="logo">
    	<img src="{{ URL::asset('img/logo-Qualidad.JPG') }}">
	    <span style="color:#FFFFFF;"><center><h2>SGSI</h2></center></span>	
    </div>

    <div id="loginbox" class="wrapper">          
      <form id="loginform" action="{{URL::to('login')}}" method="post">
        <!-- CSRF Token -->
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <!-- ./ csrf token -->
        @if (Session::has('login_errors'))
        <p style='color:#FB1D1D' >El nombre de usuario o la contraseña no son correctos.</p>
        @else
        <p>Introduzca usuario y contraseña para continuar.</p>
        @endif
        <div class="input-group input-sm">
            <span class="input-group-addon"><i class="fa fa-user"></i></span><input class="form-control" id="email" placeholder="Email" type="text" name="email"/>
        </div>
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-lock"></i></span><input class="form-control" id="password" placeholder="Contraseña" type="password" name="password"/>
        </div>
        <div class="form-actions clearfix">                      
			<input class="btn btn-block btn-primary btn-default" value="Acceder" type="submit">
        </div>
        <div class="footer-login">
            <div class="pull-left text">
                <div id="loading"><img src="{{ URL::asset('img/loading-icons/loader.gif')}}"></div>
            </div>

        </div>
      </form>
      </div>

    <span style="color:#FFFFFF;">@include('includes.footer') </span>
    </div> <!-- /container -->

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="{{ URL::asset('js/ie10-viewport-bug-workaround.js')}}"></script>
    <script src="{{ URL::asset('js/jquery.js')}}"></script>
    <script src="{{ URL::asset('js/jquery-ui.js')}}"></script>
    <script src="{{ URL::asset('js/login.js')}}"></script>
  </body>
</html>