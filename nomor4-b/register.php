<?php 
require('config.php');

if (isset($_SESSION['session_login'])) header("location: index.php");

if (isset($_POST['register'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  mysqli_query($conn, "INSERT INTO users VALUES(NULL, '$name', '$email', '$password')");

  if (mysqli_affected_rows($conn) > 0) {
    echo "<script>alert('Pendaftaran berhasil, Silhkan login!'); location.href='login.php'</script>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - School Data</title>
  <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/icons.css" rel="stylesheet" type="text/css">
  <link href="css/metismenu.min.css" rel="stylesheet" type="text/css">
  <link href="css/style.css" rel="stylesheet" type="text/css">
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <!-- <img src="../assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle"> -->
            </div>

            <div class="card bg-dark">
              <div class="card-header text-center">
                <a href="index.php"><h2 class="text-white">School <span class="text-warning">Data</span></h2></a>
              </div>

              <div class="card-body">
                <h6 class="text-white text-center">Register School Data</h6>
                <form method="POST" action="" class="needs-validation" novalidate="">
                  <div class="form-group">
                    <label for="name" class="control-label text-white">Full Name</label>
                    <input id="name" type="text" class="form-control" name="name" tabindex="1"required autofocus>
                  </div>

                  <div class="form-group">
                    <label for="email" class="control-label text-white">Email</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1"required>
                  </div>

                  <div class="form-group">
                   <label for="password" class="control-label text-white">Password</label>
                   <input id="password" type="password" class="form-control" name="password" required>
                </div>

                <div class="form-group">
                  <button type="submit" name="register" class="btn btn-warning btn-lg btn-block" tabindex="4">
                    Register
                  </button>
                </div>
              </form>


            </div>
          </div>

          <div class="mt-3 text-center text-dark">
            <b>Sudah punya akun? <a href="login.php">Login</a></b>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>