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
   $id = $_GET['threadid']; //url se lerha
   $sql = "SELECT * FROM `threadz` WHERE thread_id=$id";
   $result = mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($result)){
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
        $thread_user_id = $row['thread_user_id'];
        $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
        $result2 = mysqli_query($conn , $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $post_by = $row2['user_email'];

    }


    ?>

    <?php 
        $showAlert = false;
        $method=$_SERVER['REQUEST_METHOD']; //yani jab form submit krnga question wala tu req post hugi or
        // jab page pe srf redirect kr rha hnga tu wu get req hugi
        if($method=='POST'){
            //INSERT KRDU DATABASE MA YE comment
            $comment=$_POST['comment']; //neeche form ma name="title" ha tu usse access krnga value

            $comment = str_replace(">" , "&gt;", $comment);
            $comment = str_replace("<" , "&lt;", $comment);

            $cmnt_by = $_POST['sno'];
            
            $sql = "INSERT INTO `comments` (`cmnt_content`, `thread_id`, `cmnt_by`, `cmnt_time`) 
            VALUES ('$comment', '$id', '$cmnt_by', current_timestamp());"; //yhan $id thread id ha //user abi ni ha tu 0 rkha
            $result = mysqli_query($conn,$sql);
            $showAlert= true;
            if($showAlert){
                echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Your comment has been added.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button></div>';}
        }

    ?>
    <div class="container">

        <div class="jumbotron my-2">
            <h1 class="display-4"><?php echo $title; ?> </h1>
            <p class="lead"><?php echo $desc; ?></p>
            <hr class="my-4">
            <?php echo '<p>Posted By: <b>' .$post_by.'</b></p>';?>
            <p class="lead">
                <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
            </p>
        </div>
        <!-- THREADS WORK -->

        <div class="container">
            <h1 class="py-2">Post a Comment</h1>
            <!-- /ezforum/threads.php?catid='.$id.' iski jaga ma action ma ye use krnga $_SERVER['REQUEST_URI'] same page pe post request bhejni hu tu ye use krlia kru -->
            <?php 
            if(isset($_SESSION['loggedin'])  && $_SESSION['loggedin'] == true){
            echo '<form action="'.$_SERVER['REQUEST_URI'].'" method="POST">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Type comment for this thread</label>
                    <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                    <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">
                </div>

                <button type="submit" class="btn btn-primary">Post</button>
            </form>';
        }
//    // <!-- /ezforum/threads.php?catid='.$id.' iski jaga ma action ma ye use krnga $_SERVER['REQUEST_URI'] same page pe post request bhejni hu tu ye use krlia kru -->

            else{
                    echo '<div class="alert alert-primary font-weight-bold" role="alert">
                    You are not logged in. Please <a href="#" data-toggle="modal" data-target="#loginModal"> Log in </a> to reply this question.
                    </div>';
            }


?>
        </div>

        <div class="container">
            <h1 class="py-2">Discussion</h1>

            <?php 
                $noResult = true;
                $id = $_GET['threadid']; //url se lerha
                $sql = "SELECT * FROM `comments` WHERE thread_id=$id";
                $result = mysqli_query($conn,$sql);
                while($row=mysqli_fetch_assoc($result)){
                    $noResult = false;
                    $id = $row['cmnt_id'];
                    $content = $row['cmnt_content'];
                    $comment_time = $row['cmnt_time'];
                    $cmnt_by = $row['cmnt_by'];
                    $sql2 = "SELECT user_email FROM `users` WHERE sno='$cmnt_by'";
                    $result2 = mysqli_query($conn , $sql2);
                    $row2 = mysqli_fetch_assoc($result2);

                echo '<div class="media my-3">
                <img class="mr-3" src="img/user.png" width="54px;" alt="logo">
                <div class="media-body">
                 <p class="font-weight-bold my-0">'.$row2['user_email'].'<a class="font-weight-light"> at '.  $comment_time .'</a></p>    
                    '.$content.'  
                </div>
                </div>'; }

                if($noResult){
                    echo'<div class="jumbotron jumbotron-fluid">
                    <div class="container">
                      <h1 class="display-4">No Threads Found</h1>
                         <p class="lead">Be the first person to ask a question.</p>
                    </div>
                  </div>';
                }
                
            ?>
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
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    </script>
</body>

</html>