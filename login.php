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

    if(password_verify($password, $row['password'])){

        $_SESSION['id'] = $row['id'];
        $_SESSION['username'] = $row['username'];

        header("location: index.php");

    } else {

        echo "Invalid Username or Password";
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
</head>

<body>

<div class="container my-5">

    <h2 class="text-center mb-4">Student Login</h2>

    <form method="POST">

        <div class="form-group">
            <label>Username</label>

            <input type="text"
                   name="username"
                   class="form-control"
                   required>
        </div>

        <div class="form-group">
            <label>Password</label>

            <input type="password"
                   name="password"
                   class="form-control"
                   required>
        </div>

        <button type="submit"
                name="login"
                class="btn btn-primary">

            Login
        </button>

    </form>

</div>

</body>
</html>