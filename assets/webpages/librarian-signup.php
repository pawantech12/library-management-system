<?php
session_start();
error_reporting(0);

include 'db-connect.php';
if (isset($_POST['register'])) {
  $name = mysqli_real_escape_string($con, $_POST['name']);
  $email = mysqli_real_escape_string($con, $_POST['email']);
  $password = mysqli_real_escape_string($con, $_POST['password']);
  $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
  $mobile = mysqli_real_escape_string($con, $_POST['mobile']);


  $emailquery = "SELECT * FROM librarian WHERE email='$email'";
  $query = mysqli_query($con, $emailquery);
  $emailcount = mysqli_num_rows($query);
  if ($emailcount > 0) {
    $error['lib-msg'] = 'email already exist';
?>
    <script>
      setTimeout(() => {
        location.replace("librarian-login.php");
      }, 2000)
    </script>
    <?php
  } else {
    if ($name == "") {
      $error['name'] = "Name should not be empty";
    } else if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
      $error['name'] = "Only alphabets are allowed";
    }
    if ($password == "") {
      $error['pass'] = "Password should not be empty";
    } else if (!preg_match("/^[a-zA-Z0-9].{8,}/", $password)) {
      $error['pass'] = "Password must be minimum 8 length and only contains character and number";
    }
    if($cpassword == ""){
      $error['cpass'] = "Confirm Password should not be empty";
    }else if ($password !== $cpassword) {
      $error['cpass'] = "Confirm Password doesn't match";
    }
    if (!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $email)) {
      $error['email'] = "Please Enter Valid Email Address";
    }else if($email == ""){
      $error['email'] = "Email should not be empty";
    }
    if (!preg_match("/^[0-9]{10}+$/", $mobile)) {
      $error['mobile'] = "Please Enter Valid Mobile Number";
    } else if($mobile == ""){
      $error['mobile'] = "Mobile field should not be empty";
    }else {
      if (!isset($error)) {
        $insertquery = "INSERT INTO librarian (name,email,password,cpassword,mobile) VALUES ('$name','$email','$password','$cpassword','$mobile')";
        $query = mysqli_query($con, $insertquery);
        if ($query) {
          $error['lib-msg'] = "You have registered successfully with us Now Login with Your Account";
        }
    ?>
        <script>
          setTimeout(() => {
            location.replace("librarian-login.php");
          }, 2000)
        </script>
<?php
      }
    }
  }
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>library Management System || Register Form For Librarian</title>
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

  <section class="registration">
    <div class="registration-form">
      <h4>Register</h4>
      <p>Please Register as librarian for issueing book to student.</p>
      <form class="input-form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
        <?php
        if (isset($error['lib-msg'])) {
        ?>
          <p>
            <?php echo $error['lib-msg']; ?>
          </p>
        <?php
        }
        ?>
        <div class="input-field">
          <label for="name">Full Name *</label>
          <input type="text" name="name" id="name" placeholder="Your Name">
          <?php
          if (isset($error['name'])) {
          ?>
            <p class="error">
              <?php echo $error['name']; ?>
            </p>
          <?php
          }
          ?>
        </div>
        <div class="input-field">
          <label for="email">Email *</label>
          <input type="text" name="email" id="email" placeholder="Your Email">
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
        <div class="input-field">
          <label for="cpassword">Confirm Password *</label>
          <input type="password" name="cpassword" id="cpassword" placeholder="Confirm Password">
          <?php
          if (isset($error['cpass'])) {
          ?>
            <p class="error">
              <?php echo $error['cpass']; ?>
            </p>
          <?php
          }
          ?>
          
        </div>
        <div class="input-field">
          <label for="mobileno">Mobile No. *</label>
          <input type="text" maxlength="10" name="mobile" id="mobileno" placeholder="Mobile No.">
          <?php
          if (isset($error['mobile'])) {
          ?>
            <p class="error">
              <?php echo $error['mobile']; ?>
            </p>
          <?php
          }
          ?>
        </div>
        <input type="submit" name="register" id="signup" value="Register">
        <p>Already Have an Account ? <a href="librarian-login.php">Login Now</a></p>
      </form>
    </div>
  </section>


</body>

</html>