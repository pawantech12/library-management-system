<?php
include '../../../webpages/db-connect.php';
error_reporting(0);
session_start();
if (!isset($_SESSION['lib-name'])) {
  header("location: ../../../webpages/librarian-login.php");
}

if (isset($_POST['add-user'])) {
  $name = mysqli_real_escape_string($con, $_POST['name']);
  $email = mysqli_real_escape_string($con, $_POST['email']);
  $course = mysqli_real_escape_string($con, $_POST['course']);
  $year = mysqli_real_escape_string($con, $_POST['year']);
  $mobile = mysqli_real_escape_string($con, $_POST['mobile']);
  $address = mysqli_real_escape_string($con, $_POST['address']);
  $city = mysqli_real_escape_string($con, $_POST['city']);
  $state = mysqli_real_escape_string($con, $_POST['state']);
  $zipcode = mysqli_real_escape_string($con, $_POST['zipcode']);
  $role = mysqli_real_escape_string($con, $_POST['role']);
  $idcard = mysqli_real_escape_string($con, $_POST['idcard']);
  $dob = mysqli_real_escape_string($con, $_POST['dob']);
  $imgname = $_FILES["profileimg"]["name"];
  $tempname = $_FILES["profileimg"]["tmp_name"];
  $folder = "../../img-store/student-profile-images/" . $imgname;
  move_uploaded_file($tempname, $folder);
  $code = rand(999999, 111111);

  $checkquery = "SELECT * FROM student WHERE email='$email' AND name='$name'";
  $query = mysqli_query($con, $checkquery);
  $emailcount = mysqli_num_rows($query);
  if ($emailcount > 0) {
    $error['std-msg'] = 'Student already exist';
?>
    <script>
      setTimeout(() => {
        document.querySelector(".error").style.display = "none"
      }, 2000);
    </script>
    <?php
  } else {
    if ($name == "") {
      $error['name'] = "Name should not be empty";
    } else if (!preg_match("/^[a-zA-Z\s]*$/", $name)) {
      $error['name'] = "Only alphabets are allowed";
    }
    if ($email == "") {
      $error['email'] = "Email should not be empty";
    } else if (!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $email)) {
      $error['email'] = "Please Enter Valid Email Address";
    }
    if ($mobile == "") {
      $error['mobile'] = "Mobile field should not be empty";
    } else if (!preg_match("/^[0-9]{10}+$/", $mobile)) {
      $error['mobile'] = "Please Enter Valid Mobile Number";
    }
    if ($address == "") {
      $error['address'] = "Address should not be empty";
    } else if (!preg_match("/^[a-zA-Z0-9.,\s]*$/", $address)) {
      $error['address'] = "Only alphabets and numbers are allowed";
    }
    if ($city == "") {
      $error['city'] = "City should not be empty";
    } else if (!preg_match("/^[a-zA-Z\s]*$/", $city)) {
      $error['city'] = "Only alphabets are allowed";
    }
    
    if ($zipcode == "") {
      $error['zipcode'] = "Please Enter Zipcode";
    } else if(!preg_match("/^[0-9]{6}+$/", $zipcode)) {
      $error['zipcode'] = "Please Enter Valid Zipcode";
    }else {
      if (!isset($error)) {
        $insertquery = "INSERT INTO student(name, email, course, year, mobile, address, city, state, zipcode, role, std_img, code,admission_date,id_card,dob) VALUES ('$name','$email','$course','$year','$mobile','$address','$city','$state','$zipcode','$role','$imgname','$code',curdate(),'$idcard','$dob')";
        $query = mysqli_query($con, $insertquery);
        if ($query) {
          $reciever_email = $email;
          $subject = "Code for Student Login";
          $message = 'You have successfully Added by Librarian to Library Records. Now You can use books from library or simply you can request book through online library website.
You can simply Use the login details that is your registered email and 6-digit password.
Here is Your Login Password:'.$code;
          $sender = "From: codewithpawanofficial@gmail.com";
          if (mail($reciever_email, $subject, $message, $sender)) {
            $error['std-msg'] = "Student Added Successfully we have sent a Login details to Student email Address - $reciever_email";
    ?>
            <script>
              setTimeout(() => {
                location.replace("add-user.php");
              }, 2000);
            </script>
          <?php
          } else {
            $error['std-msg'] = "Failed while adding student and sending Login Details!";
          ?>
            <script>
              setTimeout(() => {
                location.replace("add-user.php");
              }, 2000);
            </script>
          <?php
          }
          $error['std-msg'] = 'Student Details have been added successfully';
          ?>
          <script>
            setTimeout(() => {
              document.querySelector(".error").style.display = "none"
            }, 2000);
          </script>
<?php
        } else {
          $error['std-msg'] = 'Error Occured while adding student details' . mysqli_error($con);
        }
      }
    }
  }
}


?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Library Management System || Add Student</title>
  <link rel="stylesheet" href="../../css/main.css" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <!--- google font link-->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />

  <!-- Fontawesome Link for Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
</head>

<body onload="preloader()">
  <?php include 'sidebar.php'; ?>
  <section class="home-section">
    <div class="home-content">
      <i class="fa-solid fa-bars"></i>
      <div class="logout">
        <button><a href="logout.php">Log Out</a></button>
      </div>
    </div>
    <?php
    if (isset($error['std-msg'])) {
    ?>
      <p class="error">
        <?php echo $error['std-msg']; ?>
      </p>
    <?php
    }
    ?>
    <div class="control-panel">
      <h4>Add Student</h4>
      <div class="container" style="margin-top: 1rem;">
        <div class="book-cover-img">
          <img src="https://wordpress.library-management.com/wp-content/themes/library/img/259x340.png" alt="Student Profile Image" id="img-preview" />
        </div>
        <div class="add-student-form data-form">
          <h4>Student Details</h4>
          <form class="input-form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
            <div class="input-field">
              <label for="name">Student Name *</label>
              <input type="text" name="name" id="name" placeholder="Enter Student Name" />
              <?php
              if (isset($error['name'])) {
              ?>
                <p class="error-msg">
                  <?php echo $error['name']; ?>
                </p>
              <?php
              }
              ?>
            </div>
            <div class="input-1">
              <label for="email">Email *</label>
              <input type="text" name="email" id="email" placeholder="Enter E-mail Address" />
              <?php
              if (isset($error['email'])) {
              ?>
                <p class="error-msg">
                  <?php echo $error['email']; ?>
                </p>
              <?php
              }
              ?>
            </div>
            <div class="input-field input-group upload-file">
              <div class="input-1">
                <label for="stdImg">Student Img *</label>
                <input type="file" id="stdimg" name="profileimg" accept=".jpg,.png" required>
              </div>
              <div class="input-2 Course-option">
                <label for="course">Course Name *</label>
                <select id="course" name="course">
                  <option value="Bsc">BSc</option>
                  <option value="B-Com">B-Com</option>
                  <option value="B-Tech">B-Tech</option>
                  <option value="MCA">MCA</option>
                  <option value="BA ">BA</option>
                </select>

              </div>
            </div>

            <div class="input-field input-group">
              <div class="input-1 year-option">
                <label for="year">Year *</label>
                <select id="year" name="year">
                  <option value="1st Year">1st Year</option>
                  <option value="2nd Year">2nd Year</option>
                  <option value="3rd Year">3rd Year</option>
                  <option value="4th Year">4th Year</option>
                  <option value="5th Year">5th Year</option>
                </select>
                
              </div>
              <div class="input-2">
                <label for="mobile">Mobile No. *</label>
                <input type="text" name="mobile" id="mobile" placeholder="Enter mobile no." />
                <?php
                if (isset($error['mobile'])) {
                ?>
                  <p class="error-msg">
                    <?php echo $error['mobile']; ?>
                  </p>
                <?php
                }
                ?>
              </div>
            </div>
            <div class="book-desc">
              <label for="desc">Address *</label>
              <textarea rows="5" placeholder="Enter Student Address" id="desc" name="address"></textarea>
              <?php
              if (isset($error['address'])) {
              ?>
                <p class="error-msg">
                  <?php echo $error['address']; ?>
                </p>
              <?php
              }
              ?>
            </div>

            <div class="input-field upload-file">
              <div class="input-1">
                <label for="city">City *</label>
                <input type="text" name="city" id="city" placeholder="Enter City" />
                <?php
                if (isset($error['city'])) {
                ?>
                  <p class="error-msg">
                    <?php echo $error['city']; ?>
                  </p>
                <?php
                }
                ?>
              </div>
              <div class="input-2 state-option">
                <label for="state">State *</label>
                <select id="state" name="state">
                  <option value="Maharashtra">Maharashtra</option>
                  <option value="Bengalore">Bengalore</option>
                  <option value="Delhi">Delhi</option>
                  <option value="Andaman And Nicobar Island">Andaman And Nicobar Island</option>
                  <option value="Andhra Pradesh">Andhra Pradesh</option>
                  <option value="Bihar">Bihar</option>
                  <option value="Chandigarh">Chandigarh</option>
                </select>
                
              </div>
            </div>
            <div class="input-field input-group">
              <div class="input-1">
                <label for="zipcode">Zip Code *</label>
                <input type="text" maxlength="6" name="zipcode" id="zipcode" placeholder="Zip Code" />
                <?php
                if (isset($error['zipcode'])) {
                ?>
                  <p class="error-msg">
                    <?php echo $error['zipcode']; ?>
                  </p>
                <?php
                }
                ?>
              </div>
              <div class="input-2">
                <label for="role">Role *</label>
                <input type="text" name="role" id="role" value="Student" />
              </div>
            </div>
            <div class="input-field input-group">
              <div class="input-2">
                <label for="idcard">ID Card *</label>
                <select id="idcard" name="idcard">
                  <option value="notassign">Don't Assign</option>
                  <option value="assign">Assign</option>
                </select>
                <?php
              if (isset($error['idcard'])) {
              ?>
                <p class="error-msg">
                  <?php echo $error['idcard']; ?>
                </p>
              <?php
              }
              ?>
              </div>
              <div class="input-1">
                <label for="dob">D.O.B *</label>
                <input type="date" name="dob" id="dob" required/>
              </div>
            </div>
            <input type="submit" value="Add User" name="add-user">
          </form>
        </div>
      </div>
    </div>
  </section>
  <script>
    let imgpreview = document.querySelector("#img-preview");
    let fileinput = document.getElementById("stdimg");

    fileinput.onchange = () => {
      let reader = new FileReader();
      reader.readAsDataURL(fileinput.files[0]);
      reader.onload = () => {
        let fileURL = reader.result;
        imgpreview.src = fileURL;
        // let imgTag = `<img src="${fileURL}" alt="image">`;
        // dropArea.innerHTML = imgTag;
      }
    }
  </script>

  <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

  <script src="../../js/main.js"></script>
</body>

</html>