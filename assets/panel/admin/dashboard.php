<?php
include '../../webpages/db-connect.php';
error_reporting(0);
session_start();
if (!isset($_SESSION['lib-name'])) {
  header("location: ../../webpages/librarian-login.php");
}

$bookquery = "select * from book";
$query = mysqli_query($con, $bookquery);
$totalBook = mysqli_num_rows($query);
$stdquery = "select * from student";
$squery = mysqli_query($con, $stdquery);
$totalStudent = mysqli_num_rows($squery);

$issuequery = "select * from issuebook where status='Not Returned'";
$iquery = mysqli_query($con, $issuequery);
$issuecount = mysqli_num_rows($iquery);

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Library Management System || Librarian Dashboard</title>
  <link rel="stylesheet" href="../css/main.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

  <!-- Fontawesome Link for Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
</head>

<body onload="preloader()">
  <style>
    .home-section {
      height: 100vh;
    }
  </style>
  <?php include '../../loader/loader.php' ?>


  <div class="sidebar close">
    <ul class="nav-links">
      <li>
        <a href="dashboard.php">
          <i class='bx bx-pie-chart-alt-2'></i>
          <span class="link_name">Dashboard</span>
        </a>
        <ul class="sub-menu blank">
          <li><a href="dashboard.php">Dashboard</a></li>
        </ul>
      </li>
      <li class="active">
        <div class="iocn-link">
          <a href="#">
            <i class='bx bx-book-alt'></i>
            <span class="link_name">Manage Books</span>
          </a>
          <i class='bx bxs-chevron-down arrow'></i>
        </div>
        <ul class="sub-menu">
          <li><a href="admin-pages/add-book.php">Add Book</a></li>
          <li><a href="admin-pages/view-book.php">View Book</a></li>
        </ul>
      </li>
      <li>
        <div class="iocn-link">
          <a href="admin-pages/category.php">
          <i class='bx bx-category'></i>
            <span class="link_name">Category</span>
          </a>
        </div>
        <ul class="sub-menu blank">
          <li><a href="admin-pages/category.php">Category</a></li>
        </ul>
      </li>
      <li>
        <div class="iocn-link">
          <a href="admin-pages/issue-book.php">
            <i class='bx bx-folder-open'></i>
            <span class="link_name">Issue Books</span>
          </a>
        </div>
        <ul class="sub-menu blank">
          <li><a href="admin-pages/issue-book.php">Issue Books</a></li>
        </ul>
      </li>
      <li>
        <a href="admin-pages/view-issue-book.php">
          <i class='bx bxs-grid'></i>
          <span class="link_name">View All Issued Books</span>
        </a>
        <ul class="sub-menu blank">
          <li><a href="admin-pages/view-issue-book.php">View All Issued Books</a></li>
        </ul>
      </li>
      <li>
        <a href="admin-pages/view-return-book.php">
          <i class='bx bx-time'></i>
          <span class="link_name">View All Return Books</span>
        </a>
        <ul class="sub-menu blank">
          <li><a href="admin-pages/view-return-book.php">View All Return Books</a></li>
        </ul>
      </li>
      <li>
        <a href="admin-pages/view-book-request.php">
          <i class='bx bx-list-ul'></i>
          <span class="link_name">View Book Request</span>
        </a>
        <ul class="sub-menu blank">
          <li><a href="admin-pages/view-book-request.php">View Book Request</a></li>
        </ul>
      </li>
      <li>
        <div class="iocn-link">
          <a href="#">
            <i class='bx bxs-group'></i>
            <span class="link_name">Manage Users</span>
          </a>
          <i class='bx bxs-chevron-down arrow'></i>
        </div>
        <ul class="sub-menu">
          <li><a href="admin-pages/add-user.php">Add Users</a></li>
          <li><a href="admin-pages/view-user.php">View All Users</a></li>
        </ul>
      </li>


    </ul>
  </div>
  <section class="home-section">
    <div class="home-content">
      <i class="fa-solid fa-bars"></i>

      
      <div class="logout">
        <button><a href="admin-pages/logout.php">Log Out</a></button>
      </div>
    </div>
    <div class="control-panel">
      <h4>Dashboard</h4>
      <div class="panel-container">
        <div class="issued-books panel">
          <div class="data">
            <span><?php echo $issuecount; ?></span>
            <label for="">Issued Books</label>
          </div>
          <div class="icon">
            <i class='bx bx-book'></i>
          </div>
        </div>
        <div class="return-books panel">
          <div class="data">
            <span><?php
                  $returnquery = "select * from issuebook where status='Returned'";
                  $queryrun = mysqli_query($con, $returnquery);
                  $queryrow = mysqli_num_rows($queryrun);
                  if ($queryrow > 0) {
                    echo $queryrow;
                  } else {
                    echo "0";
                  }
                  ?></span>
            <label for="">Return Books</label>
          </div>
          <div class="icon">
            <i class='bx bx-book'></i>
          </div>
        </div>
        <div class="all-books panel">
          <div class="data">
            <span><?php echo $totalBook; ?></span>
            <label for="">Total Books</label>
          </div>
          <div class="icon">
            <i class='bx bx-book'></i>
          </div>
        </div>
        <div class="manage-users panel">
          <div class="data">
            <span><?php echo $totalStudent; ?></span>
            <label for="">Manage Users</label>
          </div>
          <div class="icon">
            <i class='bx bxs-group'></i>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>


  <script src="../js/main.js"></script>
</body>

</html>