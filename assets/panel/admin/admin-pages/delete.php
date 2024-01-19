<?php
include '../../../webpages/db-connect.php';

$id = $_GET['id'];
$deletequery = "DELETE FROM book WHERE id = '$id'"; 
  $query = mysqli_query($con,$deletequery);
  if($query){
    $error['book-msg'] = "The Book Data Has been deleted successfully";
    ?>
      <script>
        setTimeout(() => {
          location.replace("view-book.php");
        }, 2000);
      </script>
<?php
  }else{
    $error['book-msg'] = "An error occured while deleting Book details";
  }


?>