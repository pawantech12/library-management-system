<?php
include '../../../webpages/db-connect.php';
session_start();
error_reporting(0);
if (!isset($_SESSION['lib-name'])) {
  header("location: ../../../webpages/librarian-login.php");
}
?>
<?php
$table_value = 'book';
$result_count = mysqli_query($con, "SELECT COUNT(*) As total_records FROM $table_value");
include 'pagination-logic.php';
$result = mysqli_query($con, "SELECT * FROM $table_value LIMIT $offset, $total_records_per_page");
?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Library Management System || View Books</title>
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

    <div class="control-panel">
      <h4>Books</h4>
      <?php
      if (isset($error['book-msg'])) {
      ?>
        <p class="error">
          <?php echo $error['book-msg']; ?>
        </p>
      <?php
      }
      ?>
      <div class="main">
        <?php
        if (isset($_SESSION['lib-name'])) {
          if (mysqli_num_rows($result) > 0) {
        ?>
            <div class="book-table">
              <table>
                <tr class="table-header">
                  <th>Cover Img</th>
                  <th>Book Title</th>
                  <th>Book Desc</th>
                  <th>Category</th>
                  <th>Price</th>
                  <th>Qty</th>
                  <th>Action</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                  <tr>
                    <td style="width: 16%;">
                      <img src="../../img-store/book-images/<?php echo $row['cover']; ?>" alt="Book Cover Image">
                    </td>
                    <td><?php echo $row['title']; ?></td>
                    <td class="desc-content"><?php echo mb_strimwidth($row['description'], 0, 100, '...'); ?></td>
                    <td><?php echo $row['category']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <td style="width: 5%;"><?php echo $row['quantity']; ?></td>
                    <td class="action-btns" style="width: 9%;">

                      <div class="edit">
                        <button><a href="update-book.php?id=<?php echo $row['id']; ?>"><i class='bx bxs-edit'></i></a></button>
                      </div>
                      <div class="delete">
                        <button class="delete-btn"><a href="delete.php?id=<?php echo $row['id']; ?>"><i class='bx bxs-trash'></i></a></button>
                      </div>

                    </td>
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
            <p>No Book has been Added Yet</p>
          <?php
          }
        } else {
          ?>
          <p class="error">Please Login to Show book data List</p>
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