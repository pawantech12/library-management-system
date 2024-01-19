<?php
session_start();
error_reporting(0);

include 'db-connect.php';
$id = $_GET['id'];
$fetchbook = "SELECT * FROM book WHERE id='$id'";
$result = mysqli_query($con, $fetchbook);
$bookrow = mysqli_num_rows($result);
$bookdata = mysqli_fetch_assoc($result);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System || Book Details</title>
    <link rel="stylesheet" href="../css/index.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!--- google font link-->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <!-- Fontawesome Link for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />

</head>

<body onload="preloader()">
    <?php include '../loader/loader.php' ?>
    <header>
        <nav class="navbar">
            <div class="logo">
                <div class="icon">
                    <img src="../images/lib.png" alt="Management System Logo">
                </div>
                <div class="logo-details">
                    <h5>L.M.S</h5>
                </div>
            </div>
            <ul class="nav-list">
                <div class="logo">
                    <div class="title">
                        <div class="icon">
                            <img src="../images/lib.png" alt="Management System Logo">
                        </div>
                        <div class="logo-header">
                            <h4>L.M.S</h4>
                            <small>Library System</small>
                        </div>
                    </div>
                    <button class="close"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <li><a href="">Home</a></li>
                <li><a href="#book">Books</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">contact</a></li>
                <div class="login">
                    <?php
                    if (isset($_SESSION['loggedin'])) {
                    ?>
                        <a href="../panel/admin/dashboard.php" type="button" class="loginbtn">Dashboard</a>
                    <?php
                    } else if (isset($_SESSION['stdloggedin'])) {
                    ?>
                        <a href="../panel/student/std-dashboard.php">Dashboard</a>

                    <?php
                    } else {
                    ?>
                        <a href="login-type.php" type="button" class="loginbtn">Log In</a>
                    <?php
                    }
                    ?>
                </div>
            </ul>
            <div class="hamburger">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </div>
        </nav>
    </header>


    <section class="book-overview">
        <div class="img">
            <img src="../panel/img-store/book-images/<?php echo $bookdata['cover'] ?>" alt="" />
        </div>
        <div class="book-content">
            <h4><?php echo $bookdata['title'] ?></h4>

            <p>
                <?php echo $bookdata['description'] ?>
            </p>


            <div class="footer">
                <div class="author-detail">
                    <div class="author">
                        <small>Author</small>
                        <strong><?php echo $bookdata['author'] ?></strong>
                    </div>
                    <div class="publisher">
                        <small>Publisher</small>
                        <strong><?php echo $bookdata['publisher'] ?></strong>
                    </div>
                </div>
                <div class="badge">
                    <?php
                    if ($bookdata['quantity'] > 0) {
                        echo '<span style="background-color: #dbf5e5;
                        color: #56c156;">Available</span>';
                    } else {
                        echo '<span style="background-color: #FF8989;
                        color: #D71313;">Not Available</span>';
                    }
                    ?>
                </div>
            </div>
            <div class="book-price">
                <div class="price">
                    <strong><span>&#8377;</span><?php echo $bookdata['price'] ?></strong>
                </div>
                <div class="input-group">

                    <button class="cartbtn"><a href="login-type.php" style="text-decoration: none;color:#fff;">Get Book</a></button>

                </div>
            </div>
        </div>
    </section>
    <section class="bookdata-recentbook">
        <div class="main">
            <table>
                <tr>
                    <th>Title</th>
                    <td><?php echo $bookdata['title'] ?></td>
                </tr>
                <tr>
                    <th>Author</th>
                    <td><?php echo $bookdata['author'] ?></td>
                </tr>
                <tr>
                    <th>Publisher</th>
                    <td><?php echo $bookdata['publisher'] ?></td>
                </tr>
                <tr>
                    <th>Language</th>
                    <td>English</td>
                </tr>
                <tr>
                    <th>ISBN</th>
                    <td><?php echo $bookdata['isbn'] ?></td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td><?php echo $bookdata['category'] ?></td>
                </tr>
            </table>
            <div class="recent-book">
                <h4>Recent Book</h4>
                <div class="book-container">
                    <?php
                    $book = "SELECT * FROM book WHERE NOT id='$id' ORDER BY id DESC LIMIT 4";
                    $bookresult = mysqli_query($con, $book);
                    if (mysqli_num_rows($bookresult) > 0) {
                        while ($row = mysqli_fetch_assoc($bookresult)) {
                    ?>
                            <div class="book">
                                <div class="img">
                                    <img src="../panel/img-store/book-images/<?php echo $row['cover'] ?>" alt="Book Cover Image">
                                </div>
                                <div class="content">
                                    <h5><?php echo $row['title'] ?></h5>
                                    <div class="badge">
                                        <span><?php echo mb_strimwidth($row['author'], 0, 30, '...'); ?></span>
                                    </div>

                                    <div class="price">
                                        <strong>$<?php echo $row['price'] ?></strong>
                                    </div>
                                    <div class="btn">
                                        <button><a href="book-details.php?id=<?php echo $row['id'] ?>" style="text-decoration: none;color:#fff;">Get Book</a></button>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>

        </div>
    </section>



    <footer>
        <div class="container">
            <div class="logo-description">
                <div class="logo">
                    <div class="img">
                        <i class='bx bx-book-reader'></i>
                    </div>
                    <div class="title">
                        <h4>L.M.S</h4>
                    </div>
                </div>
                <div class="logo-body">
                    <p>
                        Library Management System is carefully developed for easy management of any type of library. It’s actually a virtual version of a real library.
                    </p>
                </div>
                <div class="social-links">
                    <h4>Follow Us</h4>
                    <ul class="links">
                        <li>
                            <a href=""><i class="fa-brands fa-facebook-f"></i></a>
                        </li>
                        <li>
                            <a href=""><i class="fa-brands fa-youtube"></i></a>
                        </li>
                        <li>
                            <a href=""><i class="fa-brands fa-twitter"></i></a>
                        </li>
                        <li>
                            <a href=""><i class="fa-brands fa-linkedin"></i></a>
                        </li>
                        <li>
                            <a href=""><i class="fa-brands fa-instagram"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="categories list">
                <h4>Book Categories</h4>
                <ul>
                    <li><a href="#">Computer Science</a></li>
                    <li><a href="#">Programming</a></li>
                    <li><a href="#">Philosophy</a></li>
                    <li><a href="#">Social Science</a></li>
                    <li><a href="#">Fiction</a></li>
                    <li><a href="#">Fantasy</a></li>
                </ul>
            </div>
            <div class="quick-links list">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#contact">Contact Us</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="assets/webpages/login-type.php">Login</a></li>
                    <li><a href="#book">Find Books</a></li>
                </ul>
            </div>
            <div class="our-store list">
                <h4>Our Library</h4>
                <div class="map" style="margin-top: 1rem">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6310.594819201665!2d-122.42768319999999!3d37.73616639999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808f7e60a337d5f5%3A0xfa0bb626904e5ab2!2z4KSV4KWJ4KSy4KWH4KScIOCkueCkv-Cksiwg4KS44KS-4KSoIOCkq-CljeCksOCkvuCkguCkuOCkv-CkuOCljeCkleCliywg4KSV4KWI4KSy4KWA4KSr4KWL4KSw4KWN4KSo4KS_4KSv4KS-LCDgpK_gpYLgpKjgpL7gpIfgpJ_gpYfgpKEg4KS44KWN4KSf4KWH4KSf4KWN4oCN4KS4!5e0!3m2!1shi!2sin!4v1686917463994!5m2!1shi!2sin" height="70" style="width: 100%; border: none; border-radius: 5px" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <ul>
                    <li>
                        <a href=""><i class="fa-solid fa-location-dot"></i>832 Thompson Drive,San
                            Fransisco CA 94 107,United States</a>
                    </li>
                    <li>
                        <a href=""><i class="fa-solid fa-phone"></i>+12 1345678991</a>
                    </li>
                    <li>
                        <a href=""><i class="fa-solid fa-envelope"></i>support@bookoe.id</a>
                    </li>
                </ul>
            </div>
        </div>
    </footer>
    <script>
        let hamburgerbtn = document.querySelector(".hamburger");
        let nav_list = document.querySelector(".nav-list");
        let closebtn = document.querySelector(".close");
        hamburgerbtn.addEventListener("click", () => {
            nav_list.classList.add("active");
        });
        closebtn.addEventListener("click", () => {
            nav_list.classList.remove("active");
        });
    </script>
</body>

</html>