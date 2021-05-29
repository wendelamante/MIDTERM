<?php 
session_start();
  
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
    header("location: welcome.php");
    exit;
}
  
require_once "config.php";

$_SESSION["verify"] = false;
$_SESSION["code_access"] = false;
$username="";
  
 
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
  
    if(empty(trim($_POST["username"]))){
        echo "<script>alert('ENTER USERNAME');</script>";
    } else{
        $username = trim($_POST["username"]);
    }
     
    if(empty(trim($_POST["password"]))){
        echo "<script>alert('ENTER PASSWORD');</script>";
    } else{
        $password = trim($_POST["password"]);
    }
     
    if(empty($username_err) && empty($password_err)){ 
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){ 
            mysqli_stmt_bind_param($stmt, "s", $param_username);
             
            $param_username = $username;
             
            if(mysqli_stmt_execute($stmt)){ 
                mysqli_stmt_store_result($stmt);
                 
                if(mysqli_stmt_num_rows($stmt) == 1){ 
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){

                            $_SESSION["verify"] = true;
                            $_SESSION["code_access"] = true;
                            
                            $_SESSION["id"] = $id;

                            $stmt1 = $link->prepare("INSERT INTO activity_log (activity, username) VALUES (?, ?)");
                            $stmt1->bind_param("ss", $activity, $username);


                            $activity = "Logged in";
                            $username = $username;


                            $stmt1->execute();
                            $stmt1->close();
                            header("location: verification.php");
                            

                        } else{ 
                             
                            echo "<script>alert('PASSWORD ERROR');</script>";
                        }
                    }
                } else{ 
                    echo "<script>alert('USERNAME IS NOT EXIST');</script>";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);
}



?>
  
<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

    <style type="text/css">
    body{ font: 14px sans-serif; 
    padding-top: 40px;
    padding-bottom: 40px;
    background-image: url('blue.jpg');
    height: 100%;
    background-position: absolute;
    background-repeat: no-repeat;
    background-size: cover;
    color: white;
}

    .wrapper{
        margin-left: 600px;
        margin-top: 170px;
    }
    .wrapper input{
       
        margin-left: -30px;
        
        width: 380px;

    }
    .wrapper label{
       
       margin-left: -30px;
       
   

   }
    .wrapper .btn{
        margin-left: 25px;
        width: 210px;
 
        
    }
    h1{
            
            font-size: 40px;
            font-weight: bold;
            margin-top: -40px;
            margin-left: 100px;
        }
   
  






</style>
   
   
</head>  
<body>
       
    <div class="wrapper">
        <h1>Login</h1>
        <br>
      
        
        <form action="" method="post">
            <div class="next">
            <div class="form-group">
                <label>Username</label>
                <br>
                <input type="text"placeholder="Enter Username" name="username" class="form-control">
                
            </div>    
            
            <div class="form-group">
                <label>Password</label>
                
                <input type="password" placeholder="Enter Password" name="password" class="form-control">
               
            </div>
            <div class="form-group">
                    <div class="btn">
                        <input type="submit" class="btn btn-primary" value="Login">  
                    </div>
            </div>
            
            <br>
           <div>
                <p style="margin-left: 110px;"><a href="forgot_password.php" style="color: white;" ><u>Forgot Password?</u><a></p>
            </div>
    </div>
        </form>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>