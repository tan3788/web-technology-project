<?php

session_start();

include 'config.php';

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){

    $row = mysqli_fetch_assoc($result);

if($row['is_verified'] == 0){

    echo "

    <div class='alert alert-warning text-center'>

        Please verify your email first.

    </div>

    ";

} else {

    if(password_verify($password, $row['password'])){

        $_SESSION['id'] = $row['id'];
        $_SESSION['username'] = $row['username'];

        header("location: index.php");

    } else {

        echo "Invalid Username or Password";
    }
}

} else {

    echo "Invalid Username or Password";
}
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Login Form</title>

    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">

    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

body{
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background: #f8f1e7;
    overflow-x: hidden;
}

.login-container{
    width: 80%;
    max-width: 1100px;

    margin: 20px auto;

    display: flex;

    background: white;

    border-radius: 25px;

    overflow: hidden;

    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
}

.left-side{
    width: 55%;
    padding: 25px 40px;
    position: relative;
}

.right-side{
    width: 45%;
    background: linear-gradient(135deg, #4f46e5, #4338ca);

    border-top-left-radius: 200px;
    border-bottom-left-radius: 200px;

    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;

    color: white;
}

.right-side h1{
    font-size: 55px;
    font-weight: bold;
    color: #ffb020;
}

.right-side p{
    font-size: 22px;
    margin-top: 20px;
}

.register-btn{
    border: 2px solid #ffb020;
    color: white;
    padding: 12px 50px;
    border-radius: 40px;
    margin-top: 25px;
    text-decoration: none;
    font-size: 22px;
    transition: 0.3s;
}

.register-btn:hover{
    background: #ffb020;
    color: black;
    text-decoration: none;
}

.home-link{
    color: #6366f1;
    font-size: 22px;
    text-decoration: none;
}

.form-title{
    color: #6366f1;
    font-size: 42px;
    font-weight: bold;

    margin-top: 20px;
    margin-bottom: 25px;
}

.form-group{
    margin-bottom: 15px;
}

.form-label{
    color: #6366f1;
    font-size: 22px;
    font-weight: bold;
}

.form-control{
    height: 45px;

    border-radius: 18px;

    border: 2px solid #d1d5db;

    font-size: 18px;

    padding-left: 20px;
}

.form-control:focus{
    border-color: #6366f1;
    box-shadow: none;
}

.login-btn{
    width: 100%;

    height: 48px;

    border: none;

    border-radius: 18px;

    background: linear-gradient(135deg, #6366f1, #4f46e5);

    color: white;

    font-size: 24px;

    font-weight: bold;

    margin-top: 15px;

    transition: 0.3s;
}

.login-btn:hover{
    transform: translateY(-3px);
}

@media(max-width: 992px){

    .login-container{
        flex-direction: column;
    }

    .left-side,
    .right-side{
        width: 100%;
        border-radius: 0;
        padding: 40px;
    }

    .right-side{
        padding: 80px 20px;
    }
}

</style>



</head>

<body>

<div class="login-container">

    <div class="left-side">

        <a href="index.php" class="home-link">
            <i class="bi bi-chevron-left"></i> Home Page
        </a>

        <h1 class="form-title">
            Welcome Back
        </h1>

        <form method="POST"
              name="loginForm"
              onsubmit="return validateLoginForm()">

            <div class="form-group">

                <label class="form-label">

                    <i class="bi bi-person-fill"></i>

                    Username

                </label>

                <input type="text"
                       name="username"
                       class="form-control"
                       placeholder="Enter your username"
                       required>

            </div>

            <div class="form-group">

                <label class="form-label">

                    <i class="bi bi-lock-fill"></i>

                    Password

                </label>

                <input type="password"
                       name="password"
                       class="form-control"
                       placeholder="Enter your password"
                       required>

            </div>

            <button type="submit"
                    name="login"
                    class="login-btn">

                Login

            </button>

        </form>

    </div>

    <div class="right-side">

        <h1>Hello!</h1>

        <p>Don't have an account?</p>

        <a href="register.php"
           class="register-btn">

           Create Account

        </a>

    </div>

</div>

<!-- Loging Page Validation -->
<script>

function validateLoginForm(){

    let username = document.forms["loginForm"]["username"].value;
    let password = document.forms["loginForm"]["password"].value;

    if(username == "" || password == ""){

        alert("All fields are required!");
        return false;
    }

    return true;
}

</script>


</body>
</html>