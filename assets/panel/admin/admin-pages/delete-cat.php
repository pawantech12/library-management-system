<?php
include '../../../webpages/db-connect.php';

$id = $_GET['id'];
$deletequery = "DELETE FROM category WHERE catid = '$id'"; 
  $query = mysqli_query($con,$deletequery);
  if($query){
      $error['book-msg'] = "The Category Has been deleted successfully";
      $altersql = "ALTER TABLE category AUTO_INCREMENT=1";
                                      $aquery = mysqli_query($con,$altersql);
                                      ?>
                                      <script>
                                        setTimeout(() => {
                                          location.replace("category.php");
                                        }, 2000);
                                      </script>
                                <?php


  }else{
    $error['book-msg'] = "An error occured while deleting Category";
  }

?>