<?php
include '../../../webpages/db-connect.php';
session_start();
error_reporting(0);
if (!isset($_SESSION['lib-name'])) {
  header("location: ../../../webpages/librarian-login.php");
}
$table_value = 'student';
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
  <title>Library Management System || View Students</title>
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
      <h4>Students</h4>
      <div class="search-fields">
        <div class="search-id">
          <input type="text" id="search-id" onkeyup="searchid()" placeholder="Search with Student ID">
        </div>
        <div class="search-name">
          <input type="text" id="search-name" onkeyup="searchstudent()" placeholder="Search with Student Name">
        </div>
      </div>
      <div class="main">
        <?php
        if (isset($_SESSION['lib-name'])) {
          if (mysqli_num_rows($result) > 0) {
        ?>
            <div class="book-table">
              <table id="datatable" width="100%">
                <tr class="table-header">
                  <th>ID</th>
                  <th>Photo</th>
                  <th>Student Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>D.O.B</th>
                  <th>Address</th>
                  <th>Course</th>
                  <th>Years</th>
                  <th>D.A</th>
                  <th>ID Card</th>
                  <th>Action</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                  <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td>
                      <div class="student-profile" style="overflow: hidden;
  height: 150px;">
                        <img src="../../img-store/student-profile-images/<?php echo $row['std_img']; ?>" style="height: 100%;
  object-fit: cover;" alt="Student Profile Image">
                      </div>
                    </td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['mobile']; ?></td>
                    <td><?php echo $row['dob']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><?php echo $row['course']; ?></td>
                    <td><?php echo $row['year']; ?></td>
                    <td><?php echo $row['admission_date']; ?></td>
                    <td><?php echo $row['id_card']; ?></td>
                    <td class="action-btns">
                      <div class="edit">
                        <button><a href="update-student.php?id=<?php echo $row['id']; ?>"><i class='bx bxs-edit'></i></a></button>
                      </div>
                      <div class="delete">
                        <button class="delete-btn"><a href="delete-student.php?id=<?php echo $row['id']; ?>"><i class='bx bxs-trash'></i></a></button>
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
            <p class="error">No Student has been added yet</p>

          <?php
          }
        } else {
          ?>
          <p class="error">Please Login to Show Student List</p>
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
  <script>
    const searchstudent = () => {
      let value = document.getElementById("search-name").value;
      let stdTable = document.getElementById("datatable");
      let tr = stdTable.getElementsByTagName('tr');
      for (let i = 0; i < tr.length; i++) {
        let td = tr[i].getElementsByTagName('td')[2];
        if (td) {
          let textvalue = td.textContent || td.innerHTML;
          if (textvalue.indexOf(value) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
    const searchid = () => {
      let value = document.getElementById("search-id").value;
      let stdTable = document.getElementById("datatable");
      let tr = stdTable.getElementsByTagName('tr');
      for (let i = 0; i < tr.length; i++) {
        let td = tr[i].getElementsByTagName('td')[0];
        if (td) {
          let textvalue = td.textContent || td.innerHTML;
          if (textvalue.indexOf(value) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
  </script>

  <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


  <script src="../../js/main.js"></script>
</body>

</html>