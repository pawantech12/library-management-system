<?php
include '../../../webpages/db-connect.php';
session_start();
if (!isset($_SESSION['lib-name'])) {
  header("location: ../../../webpages/librarian-login.php");
}

?>
<?php
// $id = $_GET['id'];
error_reporting(0);
$id = $_GET['id'];
$previewquery = "SELECT * FROM book WHERE id='$id'";
$pquery = mysqli_query($con, $previewquery);
$row = mysqli_fetch_assoc($pquery);


if (isset($_POST['update-book'])) {
  $isbn = $_POST['isbn'];
  $author = $_POST['author'];
  $title = $_POST['title'];
  $category = $_POST['category'];
  $publisher = $_POST['publisher'];
  // $bookimg = mysqli_real_escape_string($con,$_POST['book-img']);

  $imgname = $_FILES["bookimg"]["name"];
  $tempname = $_FILES["bookimg"]["tmp_name"];
  $folder = "../../img-store/book-images/" . $imgname;
  move_uploaded_file($tempname, $folder);


  // $bookpdf = mysqli_real_escape_string($con,$_POST['book-pdf']);



  $pdfname = $_FILES['book-pdf']['name'];
  $file_tmp = $_FILES['book-pdf']['tmp_name'];
  move_uploaded_file($file_tmp, "../../img-store/book-pdf/" . $pdfname);


  $price = $_POST['price'];
  $quantity = $_POST['quantity'];
  $description = $_POST['description'];
  // $id = $_GET['id'];

  $query = "UPDATE book SET isbn='$isbn',author='$author',title='$title',category='$category',publisher='$publisher',price='$price',quantity='$quantity',description='$description',cover='$imgname',pdf='$pdfname' WHERE id = '$id'";
  $result = mysqli_query($con, $query);
  if ($result) {
    $error['book-msg'] = "Book Details have been updated successfully";
?>
    <script>
      setTimeout(() => {
        document.querySelector(".error").style.display = "none";
      }, 2000);
    </script>
  <?php
  } else {
    $error['book-msg'] = "Your Book details Has not been updated. Please Update Again";
  ?>
    <script>
      setTimeout(() => {
        document.querySelector(".error").style.display = "none";
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
  <title>Library Management System || Update Book Details</title>
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
    if (isset($error['book-msg'])) {
    ?>
      <p class="error">
        <?php echo $error['book-msg']; ?>
      </p>
    <?php
    }
    ?>
    <div class="control-panel">
      <h4>Update Book</h4>
      <div class="container">
        <div class="book-cover-img">
          <img src="../../img-store/book-images/<?php echo $row['cover']; ?>" alt="Book Cover Image" id="img-preview" />
        </div>
        <div class="update-book-form data-form">
          <h4>Update Book Details</h4>
          <form class="input-form" method="POST" enctype="multipart/form-data">

            <div class="input-field input-group">
              <div class="input-1">
                <label for="isbn">ISBN *</label>
                <input type="text" name="isbn" id="isbn" value="<?php echo $row['isbn']; ?>" />
              </div>
              <div class="input-2">
                <label for="author">Author Name *</label>
                <input type="text" name="author" id="author" value="<?php echo $row['author']; ?>" />
              </div>
            </div>
            <div class="input-field">
              <label for="title">Book Title *</label>
              <input type="text" name="title" id="title" value="<?php echo $row['title']; ?>" />
            </div>
            <div class="input-field input-group">
              <div class="input-1 Course-option">
                <label for="category">Category *</label>
                <select id="category" name="category">
                  <?php
                  $fetchcat = "SELECT * FROM category";
                  $fquery = mysqli_query($con, $fetchcat);
                  while ($catrow = mysqli_fetch_assoc($fquery)) {
                  ?>
                    <option value="<?php echo $catrow['category'] ?>" <?php
                                                                      if ($row['category'] === $catrow['category']) {
                                                                        echo 'selected';
                                                                      }
                                                                      ?>><?php echo $catrow['category'] ?></option>
                  <?php
                  }
                  ?>
                </select>

              </div>
              <div class="input-2">
                <label for="publisher">Publisher *</label>
                <input type="text" name="publisher" id="publisher" value="<?php echo $row['publisher']; ?>" />
              </div>
            </div>

            <div class="input-field upload-file">
              <div class="input-1">
                <label for="img">Upload Book Img *</label>
                <input type="file" name="bookimg" id="img" accesskey="image/*" required/>
              </div>
              <div class="input-2">
                <label for="pdf">Upload Book Pdf *</label>
                <input type="file" name="book-pdf" id="pdf" required/>
              </div>
            </div>
            <div class="input-field input-group">
              <div class="input-1">
                <label for="price">Price *</label>
                <input type="text" name="price" id="price" value="<?php echo $row['price']; ?>" />
              </div>
              <div class="input-2">
                <label for="quantity">Quantity *</label>
                <input type="text" name="quantity" id="quantity" value="<?php echo $row['quantity']; ?>" />
              </div>
            </div>
            <div class="book-desc">
              <label for="desc">Book Description *</label>
              <textarea rows="5" id="desc" name="description"><?php echo $row['description']; ?></textarea>
            </div>
            <input type="submit" value="Update" name="update-book">
          </form>
        </div>
      </div>
    </div>
  </section>

  <script>
    let imgpreview = document.querySelector(".book-cover-img #img-preview");
    let fileinput = document.getElementById("img");

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