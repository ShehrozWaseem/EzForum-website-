<?php 
$showError = "false";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include '_dbconnect.php';
    $user_email = $_POST['signupEmail'];
    $psw = $_POST['signupPassword'];
    $cpsw = $_POST['signupPassword'];

    //check if email exist or not
    $existsql = "select * from `users` where user_email = '$user_email'";
    $result = mysqli_query($conn ,$existsql);
    $numrows = mysqli_num_rows($result);
    if($numrows>0){
        $showError = "Email already exists";
    }
    else{
        if($psw==$cpsw){
            $hash = password_hash($psw, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`user_email`, `user_psw`, `timestamp`) VALUES 
            ('$user_email', '$hash', current_timestamp())";
            $result = mysqli_query($conn,$sql);

        }
        if($result){
            $showalert= true;
            header("Location: /ezforum/index.php?signupsuccess=true");
            exit();
        }
        else{
            $showError = "Passwords do not match";
        }
    }
        header("Location: /ezforum/index.php?signupsuccess=false&error=$showError");
}

?>