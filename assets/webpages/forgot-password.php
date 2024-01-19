<?php
include 'db-connect.php';
session_start();
error_reporting(0);

if (isset($_POST['send-code'])) {
  $email = mysqli_real_escape_string($con, $_POST['email']);
  $emailquery = "SELECT * FROM student WHERE email = '$email'";
  $check_email = mysqli_query($con, $emailquery);
  $emailcount = mysqli_num_rows($check_email);
  if ($emailcount > 0) {
    $ucode = rand(999999, 111111);
    $updatecode = "UPDATE student SET code='$ucode' WHERE email='$email'";
    $runquery = mysqli_query($con, $updatecode);
    if ($runquery) {
      $reciever_email = $email;
      $subject = "Code for Student Login";
      $message = "Your Code has been changed and new code is $ucode";
      $sender = "From: codewithpawanofficial@gmail.com";
      if (mail($reciever_email, $subject, $message, $sender)) {
        $_SESSION['code'] = "we have sent a updated code to your email - $reciever_email";
        header('location: student-login.php');
      } else {
        $errors['otp-error'] = "Failed while sending code!";
      }
    } else {
      $errors['otp-error'] = "An error occured while running query";
    }
  } else {
    $error['email'] = 'Enter Registered Email';
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Library Management System || Forgot Password?</title>
  <link rel="stylesheet" href="../css/index.css" />
  <!--- google font link-->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
  
</head>

<body onload="preloader()">
  <?php include '../loader/loader.php' ?>

  <section class="forgot-pass">
    <div class="forgot-form">
      <h4>Forgot Password</h4>
      <p>Enter E-mail that has been Registered with your account</p>
      <?php
      if (isset($errors['otp-error'])) {
      ?>
        <p class="error">
          <?php echo $errors['otp-error']; ?>
        </p>
      <?php
      }
      ?>
      <form class="input-form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
        <div class="input-field">
          <label for="email">E-mail *</label>
          <input type="email" name="email" id="email" placeholder="Email Address" />
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
        <input type="submit" name="send-code" value="Submit">
        <p>Already Register ? <a href="student-login.php">Login</a></p>
      </form>
    </div>
  </section>
</body>

</html>