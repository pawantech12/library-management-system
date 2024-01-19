<?php
include '../../../webpages/db-connect.php';

$id = $_GET['id'];
$deletequery = "DELETE FROM student WHERE id = '$id'"; 
  $query = mysqli_query($con,$deletequery);
  if($query){
    $error['std-msg'] = "The Student Data Has been deleted successfully";
    ?>
      <script>
        setTimeout(() => {
          location.replace("view-user.php");
        }, 2000);
      </script>
<?php
  }else{
    $error['std-msg'] = "An error occured while deleting student details";
    ?>
      <script>
        setTimeout(() => {
          location.replace("view-user.php");
        }, 2000);
      </script>
<?php
  }


?>