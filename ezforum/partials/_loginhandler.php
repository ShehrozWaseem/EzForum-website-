<?php 
$showError = "false";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include '_dbconnect.php';
    $email = $_POST["loginEmail"];
    $psw = $_POST["loginPassword"];

    $sql = "Select * from users where user_email = '$email'";
    $result = mysqli_query($conn,$sql);
    $numrows = mysqli_num_rows($result);

   if($numrows==1){
       $row = mysqli_fetch_assoc($result);
       if(password_verify($psw,$row['user_psw'])){
           session_start();
           $_SESSION['sno'] = $row['sno'];
           $_SESSION['loggedin'] = true;
           $_SESSION['useremail'] = $email;
           //header('Location:'.$_SERVER['REQUEST_URI']);
           //echo "logged in ".$email;
   }
   header('Location: /ezforum/index.php'); //agar psw verify ni b huta tu b home pe chala jaega ye

} header('Location: /ezforum/index.php'); // agar email already use ma ha
}