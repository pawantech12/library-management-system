<?php
include '../../../webpages/db-connect.php';

if (isset($_GET['page_no']) && $_GET['page_no']!=""){
  $page_no = $_GET['page_no'];
} else {
  $page_no = 1;
}
$total_records_per_page = 4;
$offset = ($page_no-1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacents = "2"; 
$total_records = mysqli_fetch_array($result_count);
$total_records = $total_records['total_records'];
$total_no_of_pages = ceil($total_records / $total_records_per_page);
$second_last = $total_no_of_pages - 1; // total page minus 1

?>