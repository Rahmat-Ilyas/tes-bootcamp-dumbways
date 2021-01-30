<?php 
require('config.php');

if (isset($_SESSION['session_login'])) header("location: index.php");

$password = null;
$email = null;
$err_email = false;
$err_pass = false;

if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
  $get = mysqli_fetch_assoc($result);
  if ($get) {
    $get_password = $get['password'];
    $get_id = $get['id'];
    if (password_verify($password, $get_password)) {
      $_SESSION['session_login'] = $get_password;
      $_SESSION['user_id'] = $get_id;
      header("location: index.php");
      exit();
    } else $err_pass = true;
  } else $err_email = true;
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
                <h6 class="text-white text-center">Login to School Data</h6>
                <form method="POST" action="" class="needs-validation" novalidate="">
                  <div class="form-group">
                    <label for="email" class="control-label text-white">Email</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" value="<?= $email ? $email : '' ?>" required autofocus>
                    <?php if ($err_email == true) { ?>
                      <div class="text-danger">
                        Email tidak ditemukan
                      </div>
                    <?php } ?>
                  </div>

                  <div class="form-group">
                   <label for="password" class="control-label text-white">Password</label>
                   <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                   <?php if ($err_pass == true) { ?>
                    <div class="text-danger">
                      Password tidak sesuai
                    </div>
                  <?php } ?>
                </div>

                <div class="form-group">
                  <button type="submit" name="login" class="btn btn-warning btn-lg btn-block" tabindex="4">
                    Login
                  </button>
                </div>
              </form>


            </div>
          </div>

          <div class="mt-3 text-center text-dark">
            <b>Belum punya akun? <a href="register.php">Daftar</a></b>
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