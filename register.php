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
        echo "<script>
            alert('Registration successful!');
            window.location.href='login.php';
          </script>";
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

    <form method="POST" 
      name="registerForm"
      onsubmit="return validateRegisterForm()">
      
        <div id="error-message"
          class="alert alert-danger d-none">
        </div>

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

        <div class="form-group">
    <label>Confirm Password</label>

    <input type="password"
           name="confirm_password"
           class="form-control"
           placeholder="Confirm your password"
           required>
</div>

        

        <button type="submit" name="submit" class="btn btn-primary">
            Submit
        </button>

        <p class="mt-3">

    Already have an account?

    <a href="login.php">
        Login
    </a>

</p>

<p>

    <a href="index.php">
        Back to Home
    </a>

</p>

    </form>

</div>


<script>

function validateRegisterForm(){

    let username = document.forms["registerForm"]["username"].value.trim();
    let email = document.forms["registerForm"]["email"].value.trim();
    let password = document.forms["registerForm"]["password"].value;
    let confirmPassword = document.forms["registerForm"]["confirm_password"].value;

    let errorBox = document.getElementById("error-message");

    errorBox.classList.add("d-none");

    // Empty fields
    if(username === "" || email === "" || password === "" || confirmPassword === ""){

        errorBox.innerHTML = "All fields are required!";
        errorBox.classList.remove("d-none");

        return false;
    }

    // Email validation
    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if(!email.match(emailPattern)){

        errorBox.innerHTML = "Please enter a valid email address!";
        errorBox.classList.remove("d-none");

        return false;
    }

    // Password length
    if(password.length < 6){

        errorBox.innerHTML = "Password must be at least 6 characters!";
        errorBox.classList.remove("d-none");

        return false;
    }

    // Confirm password
    if(password !== confirmPassword){

        errorBox.innerHTML = "Passwords do not match!";
        errorBox.classList.remove("d-none");

        return false;
    }

    return true;
}

</script>


</body>
</html>