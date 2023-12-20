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
    <title>Registration-form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <?php
        if (isset($_POST["submit"])) {
            $fullName = $_POST["fullname"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $passwordRepeat = $_POST["repeat_password"];
            $passwordHash=password_hash($password,PASSWORD_DEFAULT);
            $errors = array();
            if (empty($fullName) or empty($email) or empty($password) or empty($passwordRepeat)) {
                array_push($errors, "All fields are required");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "Email is not valid");
            }
            if (strlen($password) < 8) {
                array_push($errors, "Password must be atleast 8 characters long");
            }
            if ($password !== $passwordRepeat) {
                array_push($errors, "Password does not match");
            }
            require_once "database.php";
            $sql="SELECT * FROM users WHERE email='$email'";
            $result=mysqli_query($conn,$sql);
            $rowCount=mysqli_num_rows($result);
            if($rowCount>0){
                array_push($errors,"Email already Registered");
            }

            if(count($errors)>0){
                foreach ($errors as $error) {
                   echo "<div class='alert alert-danger'>$error</div>";
                }
            }
            else{
                //we will insert the data into database
             
                $sql="INSERT INTO users (full_name, email, password) VALUES(?,?,?)";
               $stmt= mysqli_stmt_init($conn);
              $preparestmt= mysqli_stmt_prepare($stmt,$sql);
              if($preparestmt){
                mysqli_stmt_bind_param($stmt,"sss",$fullName,$email,$passwordHash);
                mysqli_stmt_execute($stmt);
                echo "<div class='alert alert-success'>You are Registered Successfully</div>";
              }else{
                die("Something Went Wrong");
              }
            }

        }
        ?>
        <h2 class="text-center mb-5"> User Registration</h2>
        <form action="registration.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="fullname" placeholder="Full Name" required>
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password" required>
            </div>
            <div class="form-btn text-center">
                <input type="submit" class="btn btn-success" value="Register" name="submit">
            </div>
        </form>
        <div class="mt-3"><p>Already registered <a href="login.php" class="text-danger">Login Here</a></p></div>
    </div>
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>