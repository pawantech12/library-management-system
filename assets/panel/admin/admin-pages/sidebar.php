<?php include '../../../loader/loader.php' ?>

<div class="sidebar close">
  <ul class="nav-links">
    <li>
      <a href="#">
        <i class='bx bx-pie-chart-alt-2'></i>
        <span class="link_name">Dashboard</span>
      </a>
      <ul class="sub-menu blank">
        <li><a href="../dashboard.php">Dashboard</a></li>
      </ul>
    </li>
    <li class="active">
      <div class="iocn-link">
        <a href="#">
          <i class='bx bx-book-alt'></i>
          <span class="link_name">Manage Books</span>
        </a>
        <i class='bx bxs-chevron-down arrow'></i>
      </div>
      <ul class="sub-menu">
        <li><a href="add-book.php">Add Book</a></li>
        <li><a href="view-book.php">View Book</a></li>
      </ul>
    </li>
    <li>
        <div class="iocn-link">
          <a href="category.php">
          <i class='bx bx-category'></i>
            <span class="link_name">Category</span>
          </a>
        </div>
        <ul class="sub-menu blank">
          <li><a href="category.php">Category</a></li>
        </ul>
      </li>
    <li>
      <div class="iocn-link">
        <a href="issue-book.php">
          <i class='bx bx-folder-open'></i>
          <span class="link_name">Issue Books</span>
        </a>
      </div>
      <ul class="sub-menu blank">
        <li><a href="issue-book.php">Issue Books</a></li>
      </ul>
    </li>
    <li>
      <a href="view-issue-book.php">
        <i class='bx bxs-grid'></i>
        <span class="link_name">View All Issued Books</span>
      </a>
      <ul class="sub-menu blank">
        <li><a href="view-issue-book.php">View All Issued Books</a></li>
      </ul>
    </li>
    <li>
      <a href="view-return-book.php">
        <i class='bx bx-time'></i>
        <span class="link_name">View All Return Books</span>
      </a>
      <ul class="sub-menu blank">
        <li><a href="view-return-book.php">View All Return Books</a></li>
      </ul>
    </li>
    <li>
      <a href="view-book-request.php">
        <i class='bx bx-list-ul'></i>
        <span class="link_name">View Book Request</span>
      </a>
      <ul class="sub-menu blank">
        <li><a href="view-book-request.php">View Book Request</a></li>
      </ul>
    </li>
    <li>
      <div class="iocn-link">
        <a href="#">
          <i class='bx bxs-group'></i>
          <span class="link_name">Manage Users</span>
        </a>
        <i class='bx bxs-chevron-down arrow'></i>
      </div>
      <ul class="sub-menu">
        <li><a href="add-user.php">Add Users</a></li>
        <li><a href="view-user.php">View All Users</a></li>
      </ul>
    </li>
  </ul>
</div>