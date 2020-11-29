<?php 
session_start();

echo ' <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/ezforum/index.php">EzForum </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/ezforum">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="about.php">About</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Categories
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">';
        $sql = "SELECT cat_name, cat_id FROM `cat` LIMIT 3";
        $result = mysqli_query($conn,$sql);
        while($row=mysqli_fetch_assoc($result)){
         echo '<a class="dropdown-item" href="threads.php?catid='.$row['cat_id'].'">'.$row['cat_name'].'</a>';}

         echo '<div class="dropdown-divider"></div>
          <a class="font-weight-bold text-primary dropdown-item" href="index.php">View more</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="contact.php" tabindex="-1" >Contacts</a>
      </li>
    </ul>';





    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
      echo '  
      <form class="form-inline my-2 my-lg-0" method="get" action="search.php">
      <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-primary my-2 my-sm-0 mx-1" type="submit">Search</button> 
      <p class="text-primary my-0 mx-2"><b> ' .$_SESSION['useremail'].'</b></p>
      <a href="partials/_logout.php" class="btn btn-outline-primary my-2 my-sm-0">Logout</a> 
      </form>
      
  ';
      }
      else{ 
    echo '<form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button> </form>
      <div class="mx-2">
          <button class="btn btn-primary mx-1" data-toggle="modal" data-target="#loginModal">Login</button>
          <button class="btn btn-primary mx-1" data-toggle="modal" data-target="#signupModal">Signup</button>';}
          
   
  echo '</div></div>
</nav>'; 
include 'partials/_loginModal.php';
include 'partials/_signupModal.php';

if (isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "true"){
  echo '<div class="alert alert-primary alert-dismissible fade show my-0" role="alert">
          <strong>Success ! </strong>You can now login.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
      </div>';
}
?>