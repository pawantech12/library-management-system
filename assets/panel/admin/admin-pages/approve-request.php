<?php
include '../../../webpages/db-connect.php';

if(isset($_POST['title'])){
  $title = $_POST['title'];
    $requestquery = "SELECT * FROM book_request WHERE title = '$title' AND status='Waiting'"; 
  $query = mysqli_query($con,$requestquery);
  $row = mysqli_fetch_assoc($query);
  echo json_encode($row);
}
  
  

?>
