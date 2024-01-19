<?php
include 'db-connect.php';
session_start();
error_reporting(0);

$_SESSION['msg'] = ' ';
if (isset($_POST['lib-login'])) {
  $email = mysqli_real_escape_string($con, $_POST['email']);
  $password = mysqli_real_escape_string($con, $_POST['password']);
  $emailquery = "SELECT * FROM librarian WHERE email = '$email'";
  $check_email = mysqli_query($con, $emailquery);
  $emailcount = mysqli_num_rows($check_email);
  if ($password == '') {
    $error['pass'] = "This field should not be empty";
  }
  if ($emailcount > 0) {
    $fetch = mysqli_fetch_assoc($check_email);
    $fetch_pass = $fetch['password'];
    if ($password === $fetch_pass) {
      $_SESSION['loggedin'] = true;
      $_SESSION['lib-name'] = $fetch['name'];

      header('location: ../panel/admin/dashboard.php');
    } else {
      $error['pass'] = 'incorrect password';
      $_SESSION['loggedin'] = false;
      ?>
      <script>
        setTimeout(() => {
          location.replace("librarian-login.php");
        },2000)
      </script>
      <?php
    }
  } else {
    $error['email'] = 'Please Enter registered Email';
    $_SESSION['loggedin'] = false;
    ?>
      <script>
        setTimeout(() => {
          location.replace("librarian-login.php");
        },2000)
      </script>
      <?php
  }
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Library Management System || Login Form For Librarian</title>
  <link rel="stylesheet" href="../css/index.css">
  <!--- google font link-->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
  
</head>

<body onload="preloader()">
  <style>
    .input-field .error {
      color: #FF3333;
      font-size: 14px;
    }
  </style>
    <?php include '../loader/loader.php' ?>

  <section class="login">
    <form class="login-form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
      <h4>Librarian Login</h4>

      <div class="input-form">
        <div class="input-field">
          <label for="email">Email *</label>
          <input type="email" name="email" id="email" placeholder="Your Email">
          <?php
          if (isset($error['email'])) {
          ?>
            <p class="error">
              <?php echo $error['email']; ?>
            </p>
          <?php
          }
          ?>
        </div>
        <div class="input-field">
          <label for="password">Password *</label>
          <input type="password" name="password" id="password" placeholder="Password">
          <?php
          if (isset($error['pass'])) {
          ?>
            <p class="error">
              <?php echo $error['pass']; ?>
            </p>
          <?php
          }
          ?>
        </div>
        <input type="submit" name="lib-login" value="Login">
        <p>Don't Have an Account ? <a href="librarian-signup.php">Signup Now</a></p>
      </div>
    </form>
  </section>
</body>

</html>