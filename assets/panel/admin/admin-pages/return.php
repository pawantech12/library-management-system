<?php
include '../../../webpages/db-connect.php';

if(isset($_POST['title'])){
  $title = $_POST['title'];
$returnbookquery = "SELECT * FROM issuebook WHERE title = '$title'"; 
  $query = mysqli_query($con,$returnbookquery);
  $row = mysqli_fetch_assoc($query);
  echo json_encode($row);
}
  
  

?>
