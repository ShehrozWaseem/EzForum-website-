<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>EzForum </title>
</head>

<body>

    <?php include 'partials/_dbconnect.php'; ?>
    <?php include 'partials/_header.php'; ?>
    <!-- <?php include 'partials/_footer.php'; ?> -->

    <?php 
    $id = $_GET['catid']; //url se lerha
    $sql = "SELECT * FROM `cat` WHERE cat_id=$id";
    $result = mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($result)){
        $catname = $row['cat_name'];
        $catdesc = $row['cat_desc'];
    }


    ?>
    <?php 
        $showAlert = false;
        $method=$_SERVER['REQUEST_METHOD']; //yani jab form submit krnga question wala tu req post hugi or
        // jab page pe srf redirect kr rha hnga tu wu get req hugi
        if($method=='POST'){
            //INSERT KRDU DATABASE MA YE FORM
            $th_title=$_POST['title']; //neeche form ma name="title" ha tu usse access krnga value
            $th_desc = $_POST['desc'];

            $th_title = str_replace(">" , "&gt;", $th_title);
            $th_title = str_replace("<" , "&lt;", $th_title);

            $th_desc = str_replace(">" , "&gt;", $th_desc);
            $th_desc = str_replace("<" , "&lt;", $th_desc);

            $sno = $_POST['sno'];
            $sql = "INSERT INTO `threadz` ( `thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`)
             VALUES ('$th_title ', '$th_desc', $id , '$sno', current_timestamp())"; //yhan $id cat id ha //user abi ni ha tu 0 rkha
            $result = mysqli_query($conn,$sql);
            $showAlert= true;
            if($showAlert){
                echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Your thread has been added. Kindly wait for the community members to respond.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button></div>';}
        }

    ?>


    <div class="container">
        <div class="jumbotron my-2">
            <h1 class="display-4">Welcome To <?php echo $catname; ?> Forum</h1>
            <p class="lead"><?php echo $catdesc; ?></p>
            <hr class="my-4">
            <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
            <p class="lead">
                <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
            </p>
        </div>



        <!-- THREADS WORK -->

        <div class="container">
            <h1 class="py-2">Ask a Question</h1>
<?php 

if(isset($_SESSION['loggedin'])  && $_SESSION['loggedin'] == true){
    echo '<div class="container">
        <form action="'.$_SERVER['REQUEST_URI'].'"method="POST"> 
        <div class="form-group">Problem Titile</label>
            <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp"
                placeholder="Problem Title">
            <small id="emailHelp" class="form-text text-muted">Keep your title short.</small>
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Describe Your Problem</label>
            <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
            <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    
        </form>
        </div>';
}
//    // <!-- /ezforum/threads.php?catid='.$id.' iski jaga ma action ma ye use krnga $_SERVER['REQUEST_URI'] same page pe post request bhejni hu tu ye use krlia kru -->

else{
        echo '<div class="alert alert-primary font-weight-bold" role="alert">
        You are not logged in. Please <a href="#" data-toggle="modal" data-target="#loginModal"> Log in </a> to ask a question.
        </div>';
}


?>

        <h1 class="py-2">Browse Questions</h1>
            <?php 
                $id = $_GET['catid']; //url se lerha
                $sql = "SELECT * FROM `threadz` WHERE thread_cat_id=$id";
                $result = mysqli_query($conn,$sql);
                $noResult = true;
                while($row=mysqli_fetch_assoc($result)){
                    $noResult = false;
                    $id = $row['thread_id']; //ye id neeche ancor tag * ma derha take thread detail ma iss tthread ko access kr skun
                    $title = $row['thread_title'];
                    $desc = $row['thread_desc'];

                    $desc = str_replace(">" , "&gt;", $desc);
                    $desc = str_replace("<" , "&lt;", $desc);

                    $thread_time = $row['timestamp'];
                    $thread_user_id = $row['thread_user_id'];
                    $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
                    $result2 = mysqli_query($conn , $sql2);
                    $row2 = mysqli_fetch_assoc($result2);


           echo '<div class="media my-3">
                <img class="mr-3" src="img/user.png" width="54px;" alt="logo">
                <div class="media-body">
                <p class="font-weight-bold my-0">'. $row2['user_email'] .'<a class="font-weight-light"> at '.  $thread_time .'</a></p>
                    <h5 class="mt-0"><a href="thread_detail.php?threadid='.$id.'">'.$title.'</a></h5>' //*
                    .$desc.  
                '</div>
                </div>'; 
            }
            if($noResult){
                echo'<div class="jumbotron jumbotron-fluid">
                <div class="container">
                  <h1   class="display-4">No Threads Found</h1>
                  <p class="lead">Be the first person to ask a question.</p>
                </div>
              </div>';
            }
            
            
            ?>



            <!-- Keeping themm for some later stuff -->



        </div>



    </div>






    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script>
        if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}

    </script>
</body>

</html>