<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Login &mdash; Stisla</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="assets/modules/bootstrap-social/bootstrap-social.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
  <!-- Start GA -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-94034622-3');
  </script>
  <!-- /END GA -->
</head>

<body class="bg-babyblue">
  <div id="app container" class="container">
    <section class="section mt-4">
      <div class="container mt-5 align-item-center">
        <div class="login-brand">
          <!-- <img src="assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle"> -->
          <h2 class="text-dark">si gemoy </h2>
          <h4 class="text-dark">SISTEM VALIDASI DATA PEMILIHAN </h4>
        </div>
        <div class="row flex-row-reverse flex-column d-flex vh-100 justify-content-center align-items-center text-center">
          <div class="col-12 col-md-6 rounded-lg justify-content-center align-items-center text-center">
            <div id="carouselExampleSlidesOnly" class="carousel slide " data-ride="carousel">
              <div class="carousel-inner rounded-lg">
                <div class="carousel-item rounded-lg active">
                  <img src="{{asset('assets/img/carousel-login/gemoy.jpg')}}" class="d-block w-100  carousel-img-login rounded" alt="...">
                </div>
                <div class="carousel-item">
                  <img src="{{asset('assets/img/carousel-login/gemoy2.jpg')}}" class="d-block w-100  carousel-img-login" alt="...">
                </div>
                <div class="carousel-item">
                  <img src="{{asset('assets/img/carousel-login/gemoy3.jpg')}}" class="d-block w-100  carousel-img-login" alt="...">
                </div>
                <div class="carousel-item">
                  <img src="{{asset('assets/img/carousel-login/gemoy4.jpg')}}" class="d-block w-100  carousel-img-login" alt="...">
                </div>
                <div class="carousel-item">
                  <img src="{{asset('assets/img/carousel-login/gemoy5.jpg')}}" class="d-block w-100  carousel-img-login" alt="...">
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 mt-4">
            <div class="card card-primary py-4">
              <div class="card-header">
                <h3>Login</h3>
              </div>
              <div class="card-body py-4">
                <form method="POST" action="/login" class="needs-validation" novalidate="">
                  @csrf
                  @if(session('loginError'))
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('loginError') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @endif
                  <div class="form-group">
                    <label for="user" class="text-left w-100 font-weight-bolder">Username</label>
                    <input id="user" type="text" class="form-control" placeholder="Masukkan Username" name="user" tabindex="1" required autofocus>
                    <div class="invalid-feedback text-left">
                      Mohon Masukkan Username Anda
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label text-left w-100 font-weight-bolder">Password</label>
                      <div class="float-right">

                      </div>
                    </div>
                    <div class="input-group">
                      <input id="password" type="password" class="form-control" name="password" tabindex="2" placeholder="Masukkan Password" required>
                      <div class="input-group-append">
                        <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                          <i class="fa fa-eye" id="eyeIcon"></i>
                        </span>
                      </div>
                      <div class="invalid-feedback text-left">
                        Mohon Masukkan Password Anda
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="custom-control custom-checkbox text-left">
                      <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                      <label class="custom-control-label" for="remember-me">Remember Me</label>
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
                    </button>
                  </div>
                </form>
              </div>
            </div>


          </div>
        </div>
        <h4 class="d-block text-center mt-4 text-dark footer-login">TIM PEMENANGAN </h4>
        <h4 class="d-block text-center mt-2 text-dark footer-login">YUDHI-NIRNA </h4>
        <h4 class="d-block text-center mt-2 text-dark footer-login">KENDARI MEAMBO 2024 </h4>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/modules/popper.js') }}"></script>
  <script src="{{ asset('assets/modules/tooltip.js') }}"></script>
  <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ asset('assets/modules/moment.min.js') }}"></script>
  <script src="{{ asset('assets/js/stisla.js') }}"></script>

  <!-- JS Libraies -->

  <!-- Page Specific JS File -->

  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>

  <script>
    const togglePassword = document.querySelector('#togglePassword');
    const passwordField = document.querySelector('#password');
    const eyeIcon = document.querySelector('#eyeIcon');

    togglePassword.addEventListener('click', function() {
      // Ganti tipe input password menjadi text atau sebaliknya
      const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordField.setAttribute('type', type);

      // Ganti ikon mata
      eyeIcon.classList.toggle('fa-eye');
      eyeIcon.classList.toggle('fa-eye-slash');
    });
  </script>
</body>

</html>