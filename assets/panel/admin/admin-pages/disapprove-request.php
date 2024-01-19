<?php
include '../../../webpages/db-connect.php';
session_start();
$id = $_GET['id'];
$title = $_GET['title'];
$bookrequest = "SELECT * FROM book_request WHERE std_id='$id'";
$deletequery = "UPDATE book_request SET status='Disapproved' WHERE std_id = '$id' and title='$title'"; 
  $query = mysqli_query($con,$deletequery);
  if($query){
    $error['book-msg'] = "The Book Request From ".$id." Has been Disapproved";
    ?>
      <script>
        setTimeout(() => {
          location.replace("view-book-request.php");
        }, 2000);
      </script>
<?php
  }else{
    $error['book-msg'] = "An error occured while deleting or disapproving the Book request";
  }


?>