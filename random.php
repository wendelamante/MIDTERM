<?php 
session_start();
require_once "config.php";
    if(!isset($_SESSION["code_access"]) || $_SESSION["code_access"] !== true){
        header("location: login.php");
        exit;
    }else{
   

        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';

        $duration = floor(time()/(60*5));
        srand($duration);
        $_SESSION["codee"] = substr(str_shuffle($permitted_chars), 0, 6);
                
        date_default_timezone_set('Asia/Manila');

        $currentDate = date('Y-m-d H:i:s');
        $currentDate_timestamp = strtotime($currentDate);
        $endDate_months = strtotime("+5 minutes", $currentDate_timestamp);
        $packageEndDate = date('Y-m-d H:i:s', $endDate_months);
            
        $_SESSION["current"] = $currentDate;
        $_SESSION["expired"] = $packageEndDate;

        $user_id = $_SESSION["id"];
        $codee = $_SESSION["codee"];
        

        $sql = "INSERT INTO code (user_id, code, created_at, expiration) VALUES('$user_id', '$codee', '$currentDate', '$packageEndDate')";
        
        $result = mysqli_query($link,"select * from code where code='$codee'") or die('Error connecting to MySQL server');
        $count = mysqli_num_rows($result);
        if($count == 0)
        {
            if(mysqli_query($link, $sql)){
               
            } else{
            echo "ERROR: $sql. " . mysqli_error($link);
            }
        }else{
       
        }

        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
    body{ font: 14px sans-serif; 
    padding-top: 40px;
    padding-bottom: 40px;
    background-image: url('blues.jpg');
    height: 100%;
    background-position: absolute;
    background-repeat: no-repeat;
    background-size: cover;
    color: white;
}

    .cd{
        font-size: 50px;
        margin-left: 60px;
        margin-top: 50px;
        
    }
    h1{
        margin-left:590px;
        font-size: 40px;
        font-weight: bold;
       
    
    }
    a {
        font-size: 30px;
        margin-left: 5px;
    }
</style>
    
</head>

<body>
<h1> YOUR CODE IS: <h1>
        <div class="cd">
            <b><?php echo $_SESSION["codee"]; ?> </b>
        </div>
        <br>
        <a class="" style=" color: white; font-size: 20px;" href="verification.php" target="_blank"> Enter your verification code here.</a>
              
 
</body>
</html>  