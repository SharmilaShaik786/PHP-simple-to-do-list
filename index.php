<?php
  
 $server = '127.0.0.1';
 $username = 'root';
 $password = '';
 $database = 'todo_masters';

 $conn = mysqli_connect($server,$username,$password,$database);
 if($conn->connect_errno){
     die('connection to MySQL Failed : '.$conn->connect_error);
}

//creating a todo item
if(isset($_POST['add'])){ 
    $item = $_POST['item'];
     if(!empty($item)){
       $query = "INSERT INTO todo (name) VALUES ('$item')";
        if(mysqli_query($conn, $query)){
            echo '
            <center>
              <div class="alert alert-success" role="alert">
                 Item Added Successfully!
              </div>
            </center>
            '; 
       }else{
           echo mysqli_error($conn);
       }
    }
}

//Checking if action parameter is present
if(isset($_GET['action'])){ 
    $itemId = $_GET['item'];
     if($_GET['action'] == 'done'){
       $query = "UPDATE todo SET status = 1 WHERE id ='$itemId'";
        if(mysqli_query($conn, $query)){
            echo '
            <center>
              <div class="alert alert-info" role="alert">
                 Item Marked as done!
              </div>
            </center>
            '; 
       }else{
           echo mysqli_error($conn);
       }
    }elseif($_GET['action']=='delete'){
          $query = "DELETE FROM todo WHERE id = '$itemId'";
          if(mysqli_query($conn, $query)){
              echo '
             <center>
                 <div class="alert alert-danger" role="alert">
                     Item deleted successfully!
                </div>
            </center>
            '; 
          }
       }
}
 
 ?>
<!doctype html>
<html lang="en">
  <head>
    <title>TO DO LIST APPLICATION</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
         .done{
            text-decoration: line-through;
         }
    </style>
  
  </head>
  <body>
    <main>
        <div class="container pt-5">
            <div class="row">
                <div class="col-sm-12 col-md-3"></div>
                <div class="col-sm-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <p>TO DO LIST</P>
                        </div>
                        <div class="Card-Body mb-3">
                            <form method="post" action= "?$_SERVER['PHP_SELF']?>">
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="item" placeholder="Add a todo item">
                                </div>
                                <input type="submit" class="btn btn-dark" name="add" value="Add Item">
                            </form>
                            <div class="mt-5 mb-5">
                        
                                <?php
                                   $query = "SELECT * FROM todo";
                                   $result = mysqli_query($conn,$query);
                                   if($result->num_rows > 0){
                                     $i=1;
                                     while($row = $result->fetch_assoc()) {
                                           $done = $row['status'] == 1 ? "done":"";
                                         echo '
                                         <div class="row mt-4">
                                             <div class="col-sm-12 col-md-1"><h5>'.$i.'</h5></div>
                                             <div class="col-sm-12 col-md-5"><h5 class="'.$done.'">'.$row['name'].'</h5></div>
                                             <div class="col-sm-12 col-md-6">
                                                 <a href="?action=done&item='.$row['id'].'" class="btn btn-outline-dark">Mark as Done</a>
                                                 <a href="?action=delete&item='.$row['id'].'" class="btn btn-outline-danger">Delete</a>
                                               </div>
                                           </div>
                                          ';
                                          $i++;
                                        }
                                   }else{
                                    echo'
                                    <center>
                                       <img src="Folder.png" width="50px" alt="Empty list"><br><span>Your List is Empty</span>
                                    </center>
                                    ';
                                   }
                                ?>
                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            $(".alert").fadeTo(5000,500).slideUp(500,function(){
               $('.alert').slideUp(500);
            })
        })
    </script>
  </body>
</html>