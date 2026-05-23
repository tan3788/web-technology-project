<?php

session_start();
include 'config.php';

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}

$id = $_SESSION['id'];

$sql = "SELECT * FROM users WHERE id='$id'";
$result = mysqli_query($conn, $sql);

$user = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Profile - SimpleStore</title>

    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

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

/* Dark Mode */

body.dark-mode{
    background-color: #121212;
    color: white;
}

body.dark-mode .profile-container{
    background: #1f1f1f;
}

body.dark-mode .profile-info strong{
    color: white;
}

body.dark-mode .profile-info{
    color: #d1d5db;
}

/* Main Container */

.profile-container{

    width: 80%;
    max-width: 1100px;

    margin: 30px auto;

    display: flex;

    background: white;

    border-radius: 25px;

    overflow: hidden;

    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
}

/* Left Side */

.left-side{

    width: 55%;

    padding: 35px 45px;
}

.profile-title{

    color: #6366f1;

    font-size: 42px;

    font-weight: bold;

    margin-bottom: 35px;
}

.profile-info{

    margin-bottom: 25px;

    font-size: 22px;
}

.profile-info strong{

    color: #111827;
}

/* Buttons */

.action-btn{

    border: none;

    border-radius: 14px;

    padding: 12px 22px;

    margin-right: 10px;
    margin-bottom: 10px;

    font-size: 18px;

    transition: 0.3s;
}

.action-btn:hover{

    transform: translateY(-3px);
}

.edit-btn{

    background: #2563eb;
    color: white;
}

.store-btn{

    background: #6b7280;
    color: white;
}

.delete-btn{

    background: #dc2626;
    color: white;
}

.logout-btn{

    background: #ef4444;
    color: white;
}

/* Right Side */

.right-side{

    width: 45%;

    background: linear-gradient(135deg, #4f46e5, #4338ca);

    border-top-left-radius: 180px;
    border-bottom-left-radius: 180px;

    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;

    color: white;

    text-align: center;
}

.right-side i{

    font-size: 90px;

    margin-bottom: 20px;
}

.right-side h1{

    font-size: 50px;

    font-weight: bold;

    color: #ffb020;
}

.right-side p{

    font-size: 22px;

    margin-top: 10px;
}

/* Continue Shopping Button */

.home-link{

    color: white;

    border: 2px solid #ffb020;

    padding: 12px 40px;

    border-radius: 40px;

    margin-top: 25px;

    text-decoration: none;

    font-size: 20px;

    transition: 0.3s;
}

.home-link:hover{

    background: #ffb020;

    color: black;

    text-decoration: none;
}

/* Responsive */

@media(max-width: 992px){

    .profile-container{

        flex-direction: column;
    }

    .left-side,
    .right-side{

        width: 100%;

        border-radius: 0;
    }

    .right-side{

        padding: 60px 20px;
    }

    .profile-title{

        font-size: 35px;
    }
}

</style>

</head>

<body>

<div class="profile-container">

    <!-- Left Side -->

    <div class="left-side">

        <h1 class="profile-title">

            User Profile

        </h1>

        <div class="profile-info">

            <strong>

                <i class="bi bi-person-fill"></i>

                Username:

            </strong>

            <?php echo $user['username']; ?>

        </div>

        <div class="profile-info">

            <strong>

                <i class="bi bi-envelope-fill"></i>

                Email:

            </strong>

            <?php echo $user['email']; ?>

        </div>

        <div class="profile-info">

            <strong>

                <i class="bi bi-calendar-event-fill"></i>

                Account Created:

            </strong>

            <?php echo $user['created_at']; ?>

        </div>

        <div class="mt-4">

            <a href="edit_profile.php"
               class="btn action-btn edit-btn">

                Edit Profile

            </a>

            <a href="index.php"
               class="btn action-btn store-btn">

                Back to Store

            </a>

            <a href="delete_account.php"
               class="btn action-btn delete-btn"
               onclick="return confirm('Are you sure you want to delete your account?')">

               Delete Account

            </a>

            <a href="logout.php"
               class="btn action-btn logout-btn">

                Logout

            </a>

        </div>

    </div>

    <!-- Right Side -->

    <div class="right-side">

        <i class="bi bi-person-circle"></i>

        <h1>

            Welcome

        </h1>

        <p>

            <?php echo $user['username']; ?>

        </p>

        <a href="index.php"
           class="home-link">

            Continue Shopping

        </a>

    </div>

</div>

<!-- Dark Mode -->

<script>

function toggleDarkMode(){

    document.body.classList.toggle("dark-mode");

    if(document.body.classList.contains("dark-mode")){
        localStorage.setItem("theme", "dark");
    } else {
        localStorage.setItem("theme", "light");
    }
}

if(localStorage.getItem("theme") === "dark"){
    document.body.classList.add("dark-mode");
}

</script>

</body>
</html>