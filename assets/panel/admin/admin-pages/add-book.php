<?php
include '../../../webpages/db-connect.php';
error_reporting(0);
session_start();
if (!isset($_SESSION['lib-name'])) {
  header("location: ../../../webpages/librarian-login.php");
}


if (isset($_POST['add-book'])) {
  $isbn = mysqli_real_escape_string($con, $_POST['isbn']);
  $author = mysqli_real_escape_string($con, $_POST['author']);
  $title = mysqli_real_escape_string($con, $_POST['title']);
  $category = mysqli_real_escape_string($con, $_POST['category']);
  $publisher = mysqli_real_escape_string($con, $_POST['publisher']);
  // $bookimg = mysqli_real_escape_string($con,$_POST['book-img']);

  $imgname = $_FILES["bookimg"]["name"];
  $tempname = $_FILES["bookimg"]["tmp_name"];
  $folder = "../../img-store/book-images/" . $imgname;
  move_uploaded_file($tempname, $folder);


  // $bookpdf = mysqli_real_escape_string($con,$_POST['book-pdf']);



  $pdfname = $_FILES['book-pdf']['name'];
  $file_tmp = $_FILES['book-pdf']['tmp_name'];
  move_uploaded_file($file_tmp, "../../img-store/book-pdf/" . $pdfname);


  $price = mysqli_real_escape_string($con, $_POST['price']);
  $quantity = mysqli_real_escape_string($con, $_POST['quantity']);
  $description = mysqli_real_escape_string($con, $_POST['description']);
  $bookquery = "SELECT * FROM book WHERE isbn='$isbn'";
  $query = mysqli_query($con, $bookquery);
  $bookcount = mysqli_num_rows($query);
  if ($bookcount > 0) {
    $error['book-msg'] = 'Book already exist';
?>
    <script>
      setTimeout(() => {
        document.querySelector(".error").style.display = "none"
      }, 2000);
    </script>
    <?php
  } else {
    if ($isbn == "") {
      $error['isbn'] = "Please Enter ISBN No.";
    } else if (!preg_match("/^(?:[0-9]*).{13}$/", $isbn) || !preg_match("/^(?:[0-9]*).{10}$/", $isbn)) {
      $error['isbn'] = "Please Enter Valid ISBN No.";
    }
    if ($author == "") {
      $error['author'] = "Author should not be empty";
    } else if (!preg_match("/^[a-zA-Z,&\s]*$/", $author)) {
      $error['author'] = "Only alphabets are allowed";
    }
    if ($title == "") {
      $error['title'] = "Title should not be empty";
    } else if (!preg_match("/^[A-Za-z0-9\s]*$/", $title)) {
      $error['title'] = "Only alphabets and Numbers are allowed";
    }
    if ($category == "") {
      $error['category'] = "Category should not be empty";
    } else if (!preg_match("/^[a-zA-Z\s]*$/", $category)) {
      $error['category'] = "Only alphabets are allowed";
    }
    if ($publisher == "") {
      $error['publisher'] = "Publisher should not be empty";
    } else if (!preg_match("/^[a-zA-Z\s]*$/", $publisher)) {
      $error['publisher'] = "Only alphabets are allowed";
    }
    if ($price == "") {
      $error['price'] = "Price should not be empty";
    } else if (!preg_match("/^[0-9]*$/", $price)) {
      $error['price'] = "Enter Price in Numbers";
    }
    if ($quantity == "") {
      $error['quantity'] = "Quantity should not be empty";
    } else if (!preg_match("/^[0-9]*$/", $quantity)) {
      $error['quantity'] = "Enter Quantity in Numbers";
    }
    if ($description == "") {
      $error['description'] = "Description should not be empty";
    } else {
      if (!isset($error)) {
        $insertquery = "INSERT INTO book (isbn,author,title,category,publisher,price,quantity,description,cover,pdf) VALUES ('$isbn','$author','$title','$category','$publisher','$price','$quantity','$description','$imgname','$pdfname')";
        $query = mysqli_query($con, $insertquery);
        if ($query) {

          $error['book-msg'] = 'Your Book has been Inserted Successfully';
    ?>
          <script>
            setTimeout(() => {
              document.querySelector(".error").style.display = "none"
            }, 2000);
          </script>
        <?php
        } else {
          $error['book-msg'] = 'Book Not Inserted';

        ?>
          <script>
            setTimeout(() => {
              document.querySelector(".error").style.display = "none"
            }, 2000);
          </script>
<?php
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
  <title>Library Management System || Add Book</title>
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
      <h4>Add Book</h4>
      <div class="container">
        <div class="book-cover-img">
          <img src="https://wordpress.library-management.com/wp-content/themes/library/img/259x340.png" alt="Book Cover Image" id="img-preview" />
        </div>
        <div class="add-book-form data-form">
          <h4>Book Details</h4>
          <form class="input-form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
            <div class="input-field input-group">
              <div class="input-1">
                <label for="isbn">ISBN *</label>
                <input type="text" name="isbn" id="isbn" maxlength="13" placeholder="Enter ISBN" />
                <?php
                if (isset($error['isbn'])) {
                ?>
                  <p class="error-msg">
                    <?php echo $error['isbn']; ?>
                  </p>
                <?php
                }
                ?>
              </div>
              <div class="input-2">
                <label for="author">Author Name *</label>
                <input type="text" name="author" id="author" placeholder="Enter Author Name" />

                <?php
                if (isset($error['author'])) {
                ?>
                  <p class="error-msg">
                    <?php echo $error['author']; ?>
                  </p>
                <?php
                }
                ?>
              </div>
            </div>
            <div class="input-field">
              <label for="title">Book Title *</label>
              <input type="text" name="title" id="title" placeholder="Enter Book Title" />
              <?php
              if (isset($error['title'])) {
              ?>
                <p class="error-msg">
                  <?php echo $error['title']; ?>
                </p>
              <?php
              }
              ?>
            </div>
            <div class="input-field input-group">
            <div class="input-1 Course-option">
                <label for="category">Category *</label>
                <select id="category" name="category">
                  <?php
                  $fetchcat = "SELECT * FROM category";
                  $fquery = mysqli_query($con,$fetchcat);
                  while ($row=mysqli_fetch_assoc($fquery))
                  {
                    ?>
                    <option value="<?php echo $row['category']; ?>"><?php echo $row['category']; ?></option>
                    <?php
                  }
                  ?>
                </select>

              </div>
              <div class="input-2">
                <label for="publisher">Publisher *</label>
                <input type="text" name="publisher" id="publisher" placeholder="Enter Publisher Name" />
                <?php
                if (isset($error['publisher'])) {
                ?>
                  <p class="error-msg">
                    <?php echo $error['publisher']; ?>
                  </p>
                <?php
                }
                ?>
              </div>
            </div>

            <div class="input-field upload-file">
              <div class="input-1">
                <label for="img">Upload Book Img *</label>
                <input type="file" name="bookimg" id="img" accept=".jpg,.png" required />
              </div>
              <div class="input-2">
                <label for="pdf">Upload Book Pdf *</label>
                <input type="file" name="book-pdf" id="pdf" accept=".pdf" required />
              </div>
            </div>
            <div class="input-field input-group">
              <div class="input-1">
                <label for="price">Price *</label>
                <input type="text" name="price" id="price" placeholder="Enter Book Price" />
                <?php
                if (isset($error['price'])) {
                ?>
                  <p class="error-msg">
                    <?php echo $error['price']; ?>
                  </p>
                <?php
                }
                ?>
              </div>
              <div class="input-2">
                <label for="quantity">Quantity *</label>
                <input type="text" name="quantity" id="quantity" value="1" placeholder="Enter Book Quantity" />
                <?php
                if (isset($error['quantity'])) {
                ?>
                  <p class="error-msg">
                    <?php echo $error['quantity']; ?>
                  </p>
                <?php
                }
                ?>
              </div>
            </div>
            <div class="book-desc">
              <label for="desc">Book Description *</label>
              <textarea rows="5" placeholder="Enter BOok Description" id="desc" name="description"></textarea>
              <?php
              if (isset($error['description'])) {
              ?>
                <p class="error-msg">
                  <?php echo $error['description']; ?>
                </p>
              <?php
              }
              ?>
            </div>
            <input type="submit" value="Add Book" name="add-book">
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