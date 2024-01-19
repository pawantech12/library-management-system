<?php
include '../../../webpages/db-connect.php';
session_start();
error_reporting(0);
$dataquery = "SELECT * FROM issuebook WHERE status='Returned' ORDER BY userid DESC";
$result = mysqli_query($con, $dataquery);

if (!isset($_SESSION['lib-name'])) {
  header("location: ../../../webpages/librarian-login.php");
}
?>
<?php
$table_value = 'issuebook';
$result_count = mysqli_query($con, "SELECT COUNT(*) As total_records FROM $table_value WHERE status='Returned'");
include 'pagination-logic.php';
$result = mysqli_query($con, "SELECT * FROM $table_value WHERE status='Returned' LIMIT $offset, $total_records_per_page");
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Library Management System || View Returned Books</title>
  <link rel="stylesheet" href="../../css/main.css" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <!--- google font link-->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    if (isset($error['book-msg'])) {
    ?>
      <p class="error">
        <?php echo $error['book-msg']; ?>
      </p>
    <?php
    }
    ?>
    <div class="control-panel">
      <h4>All Return Books</h4>
      <div class="main">
        <?php
        if (isset($_SESSION['lib-name'])) {
          if (mysqli_num_rows($result) > 0) {
        ?>
            <div class="book-table">
              <table>
                <tr class="table-header">
                  <th>ISBN NO.</th>
                  <th>Book Title</th>
                  <th>User ID</th>
                  <th>Student Name</th>
                  <th>Issued Date</th>
                  <th>Due Date</th>
                  <th>Return Date</th>
                  <th>Status</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                  <tr>
                    <td><?php echo $row['isbn']; ?></td>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['userid']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['issuedate']; ?></td>
                    <td><?php echo $row['duedate']; ?></td>
                    <td><?php echo $row['return_date']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                  </tr>
                <?php
                }
                ?>
              </table>
            </div>
            <?php include 'pagination.php'; ?>
          <?php
          } else {
          ?>
            <p class="error">No Book has been Returned Yet</p>
          <?php
          }
        } else {
          ?>
          <p class="error">Please Login to Show Returned Book Data</p>
          <script>
            setTimeout(() => {
              location.replace('../../../webpages/librarian-login.php');
            }, 2000);
          </script>
        <?php
        }

        ?>

      </div>

    </div>
  </section>


  <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>



  <script src="../../js/main.js"></script>
</body>

</html>