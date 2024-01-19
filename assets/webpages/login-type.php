<!-- This page is for checking login type i.e checking student had login or librarian -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>library Management System || Select Login Type</title>
    <link rel="stylesheet" href="../css/index.css">
    <!--- google font link-->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap"
      rel="stylesheet"
    />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
</head>
<body onload="preloader()">
<?php include '../loader/loader.php' ?>

    <section class="login-type">
        <div class="main">
            <a href="student-login.php">
                <div class="student-login-btn">
                    <i class='bx bxs-user-circle'></i>
                    <h4>Student</h4>
                </div>
            </a>
            <div class="vr-line"></div>
            <a href="librarian-login.php">
                <div class="librarian-login-btn">
                    <i class='bx bxs-user-badge'></i>
                    <h4>Librarian</h4>
                </div>
            </a>
        </div>
    </section>
</body>
</html>