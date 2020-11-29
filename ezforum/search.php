<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Search.. </title>
  </head>
  <body>
  <?php include 'partials/_dbconnect.php'; ?>
    <?php include 'partials/_header.php'; ?>
    <!-- <?php include 'partials/_footer.php'; ?> -->
    
    <?php 
    //for searching 1st: ALTER TABLE threadz ADD FULLTEXT(thread_title, thread_desc);

    $query = $_GET["search"];
     $sql = "select * from threadz where match (thread_title, thread_desc) against ('$query')";
    $result = mysqli_query($conn,$sql);
    $noresults = true;
    while($row=mysqli_fetch_assoc($result)){
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
        $threadid = $row['thread_id'];
        $noresults = false;
        $url = "/ezforum/thread_detail.php?threadid=".$threadid;
        
        echo '<div class="container my-3">
            <h1>Search results for <em>"' .$_GET["search"]. '"</em></h1>
                <div class="result">
                <div class="media my-3">
                <img class="mr-3" src="img/user.png" width="54px;" alt="logo">
                <div class="media-body">
                <h3><a href="'.$url.'" class="text-primary">'.$title.'</a></h3>
                <p>'.$desc.'</p>   
                </div>
                </div>
                </div>  
        </div>';
    }


    // echo    '
    // <div class="container">
    // <h2>Your search reslts.</h2>
    
    // <div class="media my-3">
    // <img class="mr-3" src="img/user.png" width="54px;" alt="logo">
    // <div class="media-body">
    // <h3><a href="'.$url.'" class="text-primary">'.$title.'</a></h3>
    // <p>'.$desc.'</p>   
    // </div>
    // </div> </div>';

                
        if($noresults){
            echo' <div class = "container my-3"> <div class="jumbotron jumbotron-fluid">
                    <div class="container">
                      <h1 class="display-4">No Result found</h1>
                         <p class="lead">
                         Suggestions:
                        <ul>
                        <li>Make sure that all words are spelled correctly.</li>
                       <li>Try different keywords.</li>
                        <li>Try more general keywords.</li>
                         </ul>
                         </p>
                    </div>
                  </div> </div>';
        }

    ?>

   

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>