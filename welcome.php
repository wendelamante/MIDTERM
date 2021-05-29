<?php 
session_start();
  
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"]== "POST"){
    $sql= 'SELECT id, username, password FROM users WHERE username = ?';
    if ($stmt = mysql_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, 's', $param_username);


        $param_username= $username;
        $stmt1= $link->prepare("INSER INTO actvity_log (activity,username) VALUES (?,?)");
        $stmt1->bind_param("ss", $activity, $username);

        $activity="Logged out";
        $username = ($_SESSION["username"]);

        $stmt1->execute();
        $stmt->close();

        header("location: login.php");

    }
    mysqli_close($conn);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    
    <style type="text/css">
    body{ font: 14px sans-serif; 
    padding-top: 40px;
    padding-bottom: 40px;
    background-image: url('bluess.jpg');
    height: 100%;
    background-position: absolute;
    background-repeat: no-repeat;
    background-size: cover;
    color: white;
}

.page-header{
    margin-left: 600px;
    color: white;
}
h1{
    font-size: 50px;
}
a{
    margin-left: 80px;
}

</style>
    
</head>
<body>
    
    <div class="page-header">
        <h1><b>Welcome!</h1>
        <p style="margin-left: 45px; font-size: 20px;"> Log in Successful! </p>
        <p>
            <a href="logout.php" style="color: white; font-size: 15px; margin-left: 115px;" class="btn btn-danger" >Logout</a>
        </p>
    </div>
    
</body>
</html>