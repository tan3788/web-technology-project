
<?php
include 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if(isset($_POST['submit'])){

    $username = $_POST['username'];
    $email = $_POST['email'];

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $token = md5(rand());

    $sql = "INSERT INTO users
        (username, email, password, verification_token)
        VALUES
        ('$username', '$email', '$password', '$token')";

    $result = mysqli_query($conn, $sql);

    if(!$result){
        die("Query Error: " . mysqli_error($conn));
    } else {

        $mail = new PHPMailer(true);

        try {

            $mail->isSMTP();

            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;

            $mail->Username = 'ta992416@gmail.com';
            $mail->Password = 'kykopdkwtahsgklm';

            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('ta992416@gmail.com', 'SimpleStore');

            $mail->addAddress($email);

            $mail->isHTML(true);

            $mail->Subject = 'Verify Your Email';

            $mail->Body = "

            <h2>Email Verification</h2>

            <p>
            Click the button below to verify your account:
            </p>

            <a href='http://127.0.0.1/SimpleStore/verify.php?token=$token'>

                Verify Account

            </a>

            ";

            if($mail->send()){

                echo "

                <div class='container mt-5'>

                    <div class='alert alert-success text-center'>

                        Registration successful!
                        Verification email sent successfully.

                    </div>

                </div>

                ";

            } else {

                echo "Mail not sent.";

            }

        } catch (Exception $e) {

            echo "

            <div class='container mt-5'>

                <div class='alert alert-danger'>

                    <h4>Mailer Error</h4>

                    ".$mail->ErrorInfo."

                </div>

            </div>

            ";
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">

    <title>Register - SimpleStore</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

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

.register-container{
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
    width: 50%;
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
    font-size: 50px;
    font-weight: bold;
    color: #ffb020;
}

.right-side p{
    font-size: 20px;
    margin-top: 20px;
}

.login-btn{
    border: 2px solid #ffb020;
    color: white;
    padding: 12px 50px;
    border-radius: 35px;
    margin-top: 25px;
    text-decoration: none;
    font-size: 22px;
    transition: 0.3s;
}

.login-btn:hover{
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
    font-size: 40px;
    font-weight: bold;
    margin-top: 20px;
    margin-bottom: 25px;
}

.form-group{
    margin-bottom: 20px;
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
    font-size: 24px;
    padding-left: 20px;
}

.form-control:focus{
    border-color: #6366f1;
    box-shadow: none;
}

.signup-btn{
    width: 100%;
    height: 50px;
    border: none;
    border-radius: 18px;
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    color: white;
    font-size: 30px;
    font-weight: bold;
    margin-top: 20px;
    transition: 0.3s;
}

.signup-btn:hover{
    transform: translateY(-3px);
}

.terms{
    font-size: 20px;
}

@media(max-width: 992px){

    .register-container{
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

    .form-title{
        font-size: 40px;
    }
}

</style>

</head>

<body>

<div class="register-container">

    <div class="left-side">

        <a href="index.php" class="home-link">
            <i class="bi bi-chevron-left"></i> Home Page
        </a>

        <h1 class="form-title">
            Create Account
        </h1>

        <form method="POST"
              name="registerForm"
              onsubmit="return validateRegisterForm()">

            <div id="error-message"
                 class="alert alert-danger d-none">
            </div>

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
                    <i class="bi bi-envelope-fill"></i>
                    Email
                </label>

                <input type="email"
                       name="email"
                       class="form-control"
                       placeholder="Enter your email"
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

            <div class="form-group">

                <label class="form-label">
                    <i class="bi bi-shield-lock-fill"></i>
                    Confirm Password
                </label>

                <input type="password"
                       name="confirm_password"
                       class="form-control"
                       placeholder="Enter your confirmation"
                       required>

            </div>

            <div class="form-check mb-4">

                <input class="form-check-input"
                       type="checkbox"
                       required>

                <label class="form-check-label terms">

                    I accept the terms of the agreement

                </label>

            </div>

            <button type="submit"
                    name="submit"
                    class="signup-btn">

                Sign Up

            </button>

        </form>

    </div>

    <div class="right-side">

        <h1>Get Started</h1>

        <p>Already have an account?</p>

        <a href="login.php"
           class="login-btn">

           Log in

        </a>

    </div>

</div>

<script>

function validateRegisterForm(){

    let username = document.forms["registerForm"]["username"].value.trim();
    let email = document.forms["registerForm"]["email"].value.trim();
    let password = document.forms["registerForm"]["password"].value;
    let confirmPassword = document.forms["registerForm"]["confirm_password"].value;

    let errorBox = document.getElementById("error-message");

    errorBox.classList.add("d-none");

    if(username === "" || email === "" || password === "" || confirmPassword === ""){

        errorBox.innerHTML = "All fields are required!";
        errorBox.classList.remove("d-none");

        return false;
    }

    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if(!email.match(emailPattern)){

        errorBox.innerHTML = "Please enter a valid email address!";
        errorBox.classList.remove("d-none");

        return false;
    }

    if(password.length < 6){

        errorBox.innerHTML = "Password must be at least 6 characters!";
        errorBox.classList.remove("d-none");

        return false;
    }

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
