<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Log in</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="{{ asset('backend') }}/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="{{ asset('backend') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset('backend') }}/dist/css/adminlte.min.css">
  <link href="{{ asset('backend') }}/font/Sans-Pro.css" rel="stylesheet"> 

</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card">
    
    <div class="login-logo mb-0 mt-2">
      <div class="row">
        <div class="col-12 p-2">
          <img src="{{ asset('backend') }}/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image" style="width: 100px;">
        </div> 
      </div>
      <a href="{{ route('login') }}"><b>Koding</b>Ku</a>
    </div> 
    <div class="card-body login-card-body">
      <p class="login-box-msg">Login Untuk Memulai Sesi</p> 
      @error('email')
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        E-Mail / Password yang ada masukan salah ! 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="document.getElementById('email').focus();">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> 
      @enderror
      <form action="{{ route('login') }}" method="post">
        @csrf
        <div class="input-group mb-3">
          <input type="email" name="email" id="email" class="form-control" placeholder="Email" autofocus required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">
              Login
            </button>
          </div>
        </div>
        {{-- <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
        </div> --}}
      </form>

      {{-- <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div> --}}

      {{-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p> --}}
    </div>
  </div>
</div>

<script src="{{ asset('backend') }}/plugins/jquery/jquery.min.js"></script>
<script src="{{ asset('backend') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('backend') }}/dist/js/adminlte.min.js"></script>

</body>
</html>
