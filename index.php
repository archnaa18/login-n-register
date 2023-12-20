<?php
session_start();
if(isset($_POST['ajax'])){
    if ((time() - $_SESSION["LAST_ACTIVE_TIME"]) > 10) {
        echo " you are going to logout";
    }


}else{
if (isset($_SESSION["LAST_ACTIVE_TIME"])) {
    if ((time() - $_SESSION["LAST_ACTIVE_TIME"]) > 10) {
        header("Location: logout.php");
        die();
    }
}
$_SESSION["LAST_ACTIVE_TIME"] = time();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body style="background-color:#17a2b8;">
    <div class="container" style="background-color:#f1f7fb;">
        <h1 class="text-center">Welcome to Dashboard</h1>
        <div class="text-center mt-5"><a href="logout.php" class="btn btn-warning">Logout</a></div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        setInterval(function () {
            check_user();
        }, 2000);
        function check_user() {
            jQuery.ajax({
                url: 'login.php',
                type='post',
                data: 'type=ajax',
                success: function (result) {
                    console.log(result);
                }
            });
        }
    </script>
</body>

</html>