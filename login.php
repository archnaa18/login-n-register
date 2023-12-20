<?php
session_start();
if(isset($_SESSION["user"])){
    header("Location: index.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php
        if(isset($_POST["login"])){
            $email=$_POST["email"];
            $password=$_POST["password"];
            require_once "database.php";
            $sql="SELECT * FROM users WHERE email='$email'";
            $result=mysqli_query($conn,$sql);
            $user=mysqli_fetch_array($result,MYSQLI_ASSOC);
            if($user){
               if(password_verify($password,$user["password"])){
                session_start();
                $_SESSION["user"]="yes";
                header("Location: index.php");
                die();
               }
               else{
                echo "<div class='alert alert-danger'>Password Does not Match</div>";
               }
            }
            else{
                echo "<div class='alert alert-danger'>User does not exist in database</div>";
            }
        }
        ?>
         <h2 class="text-center mb-5"> User Login</h2>
        <form action="login.php" method="post">
            <div class="form-group">
                <input type="email" placeholder="Enter Email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="password" placeholder="Enter Password" name="password" class="form-control">
            </div>
            <div class="form-btn text-center">
                <input type="submit" value="login" name="login" class="btn btn-danger" required>

            </div>
        </form>
        <div><p>Not registered yet <a href="registration.php" class="text-success">Register Here</a></p></div>
    </div>
</body>
</html>