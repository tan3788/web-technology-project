<?php
include 'config.php';

if(isset($_POST['submit'])){

    $username = $_POST['username'];
    $email = $_POST['email'];

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password)
            VALUES ('$username', '$email', '$password')";

    $result = mysqli_query($conn, $sql);

    if(!$result){
        die("Query Error: " . mysqli_error($conn));
    } else {
        echo "Data inserted successfully";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>User Form</title>

    <!-- Bootstrap 4 CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
</head>

<body>

<div class="container my-5">

    <h2 class="text-center mb-4">User Registration</h2>

    <form method="POST">     

        <div class="form-group">
            <label>Username</label>

            <input type="text" name="username" class="form-control" placeholder="Enter your username" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="text" name="email" class="form-control" placeholder="Enter your email" required>
        </div>
       
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
        </div>

        

        <button type="submit" name="submit" class="btn btn-primary">
            Submit
        </button>

    </form>

</div>

</body>
</html>