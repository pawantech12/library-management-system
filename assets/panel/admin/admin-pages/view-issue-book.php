<?php
include '../../../webpages/db-connect.php';
session_start();
error_reporting(0);
if (!isset($_SESSION['lib-name'])) {
  header("location: ../../../webpages/librarian-login.php");
}
?>
<?php
$table_value = 'issuebook';
$result_count = mysqli_query($con, "SELECT COUNT(*) As total_records FROM $table_value WHERE status='Not Returned'");
include 'pagination-logic.php';
$result = mysqli_query($con, "SELECT * FROM $table_value WHERE status='Not Returned' LIMIT $offset, $total_records_per_page");
?>

<?php
// include 'return.php';
if (isset($_POST['book-return'])) {
  $title = $_POST['title'];
  $name = $_POST['name'];
  $returndate = $_POST['returndate'];
  $returnquery = "update issuebook set return_date='$returndate',status='Returned' where name='$name' and title='$title'";
  $query = mysqli_query($con, $returnquery);
  $bookquery = "select * from issuebook where name='$name'";
  $runquery = mysqli_query($con, $bookquery);
  $fetch = mysqli_fetch_assoc($runquery);
  $isbn = $fetch['isbn'];
  if ($query) {
    $error['book-msg'] = "The Book has been returned successfully";
    $updatebookdata = "UPDATE book SET quantity= quantity+1 WHERE isbn='$isbn'";
?>
    <script>
      setTimeout(() => {
        location.replace("view-issue-book.php");
      }, 2000);
    </script>
  <?php
    $updatebookdata = "UPDATE book SET quantity= quantity+1 WHERE isbn='$isbn'";
    $query = mysqli_query($con, $updatebookdata);
  } else {
    $error['book-msg'] = "An error occured while returning the book";
  ?>
    <script>
      setTimeout(() => {
        location.replace("view-issue-book.php");
      }, 2000);
    </script>
<?php
  }
}

?>
<?php
if (isset($_POST['send-mail'])) {
  $email = $_POST['email'];
  $msg = $_POST['msg'];
  $subject = "Reminder For Returning Book";
  $sender = "From: codewithpawanofficial@gmail.com";
  if (mail($email, $subject, $msg, $sender)) {
    $error['book-msg'] = "Email has been sent successfuly to " . $email;
    ?>
    <script>
      setTimeout(() => {
        location.replace("view-issue-book.php");
      }, 2000);
    </script>
  <?php
  } else {
    $error['book-msg'] = "Failed while sending email!";
    ?>
    <script>
      setTimeout(() => {
        location.replace("view-issue-book.php");
      }, 2000);
    </script>
  <?php
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Library Management System || View Issued Books</title>
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
      <h4>All Issued Books</h4>
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
                  <th>Status</th>
                  <th>Action</th>
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
                    <td><?php echo $row['status']; ?></td>
                    <td class="action-btns">
                      <div class="return">
                        <button data-title="<?php echo $row['title']; ?>" class="return-btn"><i class='bx bxs-edit'></i></button>
                      </div>
                      <div class="send-mail">
                        <button data-userid="<?php echo $row['userid']; ?>" class="mail-btn"><i class='bx bxs-envelope'></i></button>
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
            <p class="error">No Book has been Issued Yet</p>
          <?php
          }
        } else {
          ?>
          <p class="error">Please Login to Show Issued book data</p>
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

  <section class="model-container">
    <div class="modal" id="return">
      <div class="modal-main">
        <div class="modal-content">
          <div class="modal-header">
            <h4>Return Book</h4>
            <span><i class='bx bx-x' id="close"></i></span>
          </div>
          <div class="return-form">
            <form method="POST" class="input-form">
              <div class="input-field">
                <label for="name">Book Title *</label>
                <input type="text" name="title" id="title" value="" placeholder="Enter Book Title" />
              </div>
              <div class="input-field">
                <label for="name">Student Name *</label>
                <input type="text" name="name" id="name" placeholder="Enter Student Name" />
              </div>
              <div class="input-field">
                <label for="name">Return Date *</label>
                <input type="date" name="returndate" id="name" />
              </div>
              <input type="submit" name="book-return" value="Return Book">
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal" id="send-mail">
      <div class="modal-main">
        <div class="modal-content">
          <div class="modal-header">
            <h4>Send Email</h4>
            <span><i class='bx bx-x' id="close-btn"></i></span>
          </div>
          <div class="send-mail">
            <form method="POST" class="input-form">
              <div class="input-field">
                <label for="name">E-mail *</label>
                <input type="email" name="email" id="email" />
              </div>
              <div class="msg">
                <label for="name">Message *</label>
                <textarea id="msg" name="msg"></textarea>
              </div>
              <input type="submit" name="send-mail" value="Send Mail">
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>


  <script>
    //       // Get the modal
    // var modal = document.getElementById("return");

    // // Get the button that opens the modal
    // const btn = document.querySelector(".return-btn");

    // // Get the <span> element that closes the modal
    var span = document.getElementById("close");
    var span2 = document.getElementById("close-btn");

    // When the user clicks on the button, open the modal
    $(document).on("click", ".return-btn", function() {
      $("#return").show();
      var title = $(this).data("title");
      $.ajax({
        url: "return.php",
        type: "POST",
        data: {
          title: title
        },
        dataType: 'json',
        success: function(response) {
          // alert(response.title);
          $('#title').val(response.title);
          $('#name').val(response.name);
        }
      })
    })
    $(document).on("click", ".mail-btn", function() {
      $("#send-mail").show();
      var id = $(this).data("userid");
      $.ajax({
        url: "send-mail.php",
        type: "POST",
        data: {
          id: id
        },
        dataType: 'json',
        success: function(response) {
          // alert(response.title);
          $('#email').val(response.email);
        }
      })
    })
    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
      $("#return").hide();
    }
    span2.onclick = function() {
      $("#send-mail").hide();
    }
  </script>

  <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>



  <script src="../../js/main.js"></script>
</body>

</html>