<?php
include '../../../webpages/db-connect.php';
session_start();
error_reporting(0);
if (!isset($_SESSION['lib-name'])) {
    header("location: ../../../webpages/librarian-login.php");
  }
?>
<?php
$table_value = 'book_request';
$result_count = mysqli_query($con, "SELECT COUNT(*) As total_records FROM $table_value WHERE status='Waiting'");
include 'pagination-logic.php';
$requestresult = mysqli_query($con, "SELECT * FROM $table_value WHERE status='Waiting' LIMIT $offset, $total_records_per_page");

?>
<?php

if (isset($_POST['issue-book'])) {
    $title = $_POST['title'];
    $id = $_POST['id'];
    $name = $_POST['name'];
    $issuedate = $_POST['issuedate'];
    $duedate = $_POST['duedate'];


    $checkquery = "SELECT * FROM student WHERE id='$id'";
    $query = mysqli_query($con, $checkquery);
    $result = mysqli_fetch_assoc($query);
    $stdcount = mysqli_num_rows($query);
    if ($stdcount > 0) {
        $checkissue = "SELECT * FROM issuebook WHERE title='$title' AND status='Not Returned'";
        $iquery = mysqli_query($con, $checkissue);
        $issueresult = mysqli_fetch_assoc($iquery);
        $issuecount = mysqli_num_rows($iquery);

        $book = "SELECT * FROM book WHERE title='$title'";
        $bookquery = mysqli_query($con, $book);
        $bookfetch = mysqli_fetch_assoc($bookquery);
        $isbn = $bookfetch['isbn'];
        if ($issuecount > 0) {
            $error['book-msg'] = "Book has been already issued to student";
?>
            <script>
                setTimeout(() => {
                    location.replace("view-book-request.php");
                }, 2000);
            </script>
            <?php
        } else {
            $checkquery = "SELECT * FROM book WHERE isbn='$isbn'";
            $query = mysqli_query($con, $checkquery);
            $result = mysqli_fetch_assoc($query);
            $bookcount = $result['quantity'];
            if ($bookcount > 0) {

                $status = "Not Returned";
                $return_date = "0000-00-00";
                $insertquery = "INSERT INTO issuebook VALUES('$isbn','$title','$id','$name','$issuedate','$duedate','$status','$return_date')";
                $query = mysqli_query($con, $insertquery);
                if ($query) {
                    $error['book-msg'] = "Book " . $title . " has been issued to " . $name;
                    $updatebookdata = "UPDATE book SET quantity= quantity-1 WHERE isbn='$isbn'";
                    $query = mysqli_query($con, $updatebookdata);
                    $updatestatus = "UPDATE book_request SET status='Approved' WHERE std_id='$id' AND title='$title'";
                    $queryrun = mysqli_query($con, $updatestatus);
            ?>
                    <script>
                        setTimeout(() => {
                            location.replace("view-book-request.php");
                        }, 2000);
                    </script>
                <?php
                } else {
                    $error['book-msg'] = "An error occured while issueing book to student";
                ?>
                    <script>
                        setTimeout(() => {
                            location.replace("view-book-request.php");
                        }, 2000);
                    </script>
                <?php
                }
            } else {
                $error['book-msg'] = "Book is not available";
                ?>
                <script>
                    setTimeout(() => {
                        location.replace("view-book-request.php");
                    }, 2000);
                </script>
<?php
            }
        }
    } else {
        $error['id'] = "No student has been found with this ID";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Library Management System || View Book Requests</title>
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
            <h4>All Book Request</h4>
            <div class="main">
                <?php
                if (isset($_SESSION['lib-name'])) {
                    if (mysqli_num_rows($requestresult) > 0) {
                ?>
                        <div class="book-table">
                            <table>
                                <tr class="table-header">
                                    <th>Book Title</th>
                                    <th>Student ID</th>
                                    <th>Student Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                <?php

                                while ($row = mysqli_fetch_assoc($requestresult)) {
                                ?>
                                    <tr>
                                        <td><?php echo $row['title']; ?></td>
                                        <td><?php echo $row['std_id']; ?></td>
                                        <td><?php echo $row['std_name']; ?></td>
                                        <td><?php echo $row['status']; ?></td>
                                        <td class="action-btns">
                                            <div class="return">
                                                <button data-title="<?php echo $row['title']; ?>" class="approve-btn"><i class='bx bx-check'></i></button>
                                            </div>
                                            <div class="send-mail">
                                                <a href="disapprove-request.php?id=<?php echo $row['std_id']; ?>&title=<?php echo $row['title']; ?>"><button class="disapprove-btn"><i class='bx bx-x'></i></button></a>
                                            </div>
                                        </td>
                                    </tr>

                                <?php
                                }
                                ?>
                            </table>
                        </div>
                        <?php include 'pagination.php'; ?>
                        <div class="modal" id="issue">
                            <div class="modal-main">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4>Issue Book</h4>
                                        <span><i class='bx bx-x' id="close"></i></span>
                                    </div>
                                    <div class="issue-form">
                                        <form method="POST" class="input-form">
                                            <div class="input-field">
                                                <label for="name">Book Title *</label>
                                                <input type="text" name="title" id="title" value="" placeholder="Enter Book Title" />
                                            </div>
                                            <div class="input-field">
                                                <label for="name">Student ID *</label>
                                                <input type="text" name="id" id="id" placeholder="Enter Student ID" />
                                            </div>
                                            <div class="input-field">
                                                <label for="name">Student Name *</label>
                                                <input type="text" name="name" id="name" placeholder="Enter Student Name" />
                                            </div>
                                            <div class="input-field input-group">
                                                <div class="input-1">
                                                    <label for="name">Date Issued *</label>
                                                    <input type="date" name="issuedate" id="name" />

                                                </div>
                                                <div class="input-2">
                                                    <label for="name">By when to return *</label>
                                                    <input type="date" name="duedate" id="name" />

                                                </div>
                                            </div>
                                            <input type="submit" name="issue-book" value="Issue Book">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php

                    } else {
                    ?>
                        <p class="error" style="margin-top: 1rem;text-align:center;">No Book has been Requested Yet</p>

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
    <script>
        //       // Get the modal
        // var modal = document.getElementById("return");

        // // Get the button that opens the modal
        // const btn = document.querySelector(".return-btn");

        // // Get the <span> element that closes the modal
        var span = document.getElementById("close");

        // When the user clicks on the button, open the modal
        $(document).on("click", ".approve-btn", function() {
            $("#issue").show();
            var title = $(this).data("title");
            $.ajax({
                url: "approve-request.php",
                type: "POST",
                data: {
                    title: title
                },
                dataType: 'json',
                success: function(response) {
                    // alert(response.title);
                    $('#title').val(response.title);
                    $('#id').val(response.std_id);
                    $('#name').val(response.std_name);
                }
            })
        })
        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            $("#issue").hide();
        }
    </script>



    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>



    <script src="../../js/main.js"></script>
</body>

</html>