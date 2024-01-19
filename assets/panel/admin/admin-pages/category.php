<?php
include '../../../webpages/db-connect.php';
session_start();
error_reporting(0);
if (!isset($_SESSION['lib-name'])) {
    header("location: ../../../webpages/librarian-login.php");
  }
?>
<?php
$table_value = 'category';
$result_count = mysqli_query($con, "SELECT COUNT(*) As total_records FROM $table_value");
include 'pagination-logic.php';
$result = mysqli_query($con, "SELECT * FROM $table_value LIMIT $offset, $total_records_per_page");
?>

<?php
if(isset($_POST['add-cat'])){
    $category = mysqli_real_escape_string($con,$_POST['category']);
    $catcheck = "SELECT * FROM category WHERE category='$category'";
    $cquery = mysqli_query($con,$catcheck);
    if(mysqli_num_rows($cquery)>0){
        $error['cat'] = "Category Already Exist";
    }else{
        $insertcat = "INSERT INTO category (category) VALUES('$category')";
        $iquery = mysqli_query($con,$insertcat);
        if($iquery){
            $error['cat'] = "Category Added Successfully";
            ?>
          <script>
            setTimeout(() => {
              location.replace("category.php");
            }, 2000);
          </script>
        <?php
        }else{
            $error['cat'] = "An Error Ocurred while adding category";
            ?>
          <script>
            setTimeout(() => {
              location.replace('category.php');
            }, 2000);
          </script>
        <?php
        }
    }
}

?>
<?php



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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            <h4>Category</h4>
            <?php
            if (isset($error['cat'])) {
            ?>
                <p class="error">
                    <?php echo $error['cat']; ?>
                </p>
            <?php
            }
            ?>

            <div class="add-cat">
                <button class="category-btn"><i class='bx bxs-plus-square'></i></button>
            </div>
            <div class="main">
                <?php
                if (isset($_SESSION['lib-name'])) {
                    if (mysqli_num_rows($result) > 0) {
                ?>
                        <div class="book-table">
                            <table>
                                <tr class="table-header">
                                    <th>ID</th>
                                    <th>Category</th>
                                    <th>Action</th>
                                </tr>
                                <?php
                                $num = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $id = $row['catid'];
                                    $sql = "UPDATE category SET catid=$num WHERE catid=$id";
                                    $rquery = mysqli_query($con,$sql);
                                    $num++;
                                ?>
                                    <tr>
                                        <td>
                                            <?php echo $row['catid']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['category']; ?>
                                        </td>
                                        <td class="action-btns">
                                            <div class="delete">
                                                <button class="delete-btn"><a href="delete-cat.php?id=<?php echo $row['catid']; ?>"><i class='bx bxs-trash'></i></a></button>
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
                        <p class="error">No Category has been Added Yet</p>
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
    <div class="modal-container">
        <div class="modal" id="category">
            <div class="modal-main">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Add Category Form</h4>
                        <span><i class='bx bx-x' id="close"></i></span>
                    </div>
                    <div class="return-form">
                        <form method="POST" class="input-form">
                            <div class="input-field">
                                <label for="category">Category *</label>
                                <input type="text" name="category" id="category" value="" placeholder="Enter Category" />
                            </div>

                            <input type="submit" name="add-cat" value="Add Category">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var span = document.getElementById("close");

        // When the user clicks on the button, open the modal
        $(document).on("click", ".category-btn", function() {
            $("#category").show();
        })
        span.onclick = function() {
            $("#category").hide();
        }
    </script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

    <script src="../../js/main.js"></script>
</body>

</html>