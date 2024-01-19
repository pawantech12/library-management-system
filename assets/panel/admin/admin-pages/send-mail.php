<?php
include '../../../webpages/db-connect.php';

if(isset($_POST['id'])){
  $id = $_POST['id'];
$stdquery = "SELECT * FROM student WHERE id = '$id'"; 
  $query = mysqli_query($con,$stdquery);
  $row = mysqli_fetch_assoc($query);
  echo json_encode($row);
}
  
  

?>
