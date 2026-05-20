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
    <title>Profile Page</title>

    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">


    <style>

body.dark-mode{
    background-color: #121212;
    color: white;
}

body.dark-mode .card{
    background-color: #1f1f1f;
    color: white;
}

body.dark-mode .navbar{
    background-color: #000 !important;
}

body.dark-mode .text-muted{
    color: #bdbdbd !important;
}

</style>

  
</head>

<body>

<div class="container mt-5">

    <div class="card p-4 shadow">

        <h2 class="mb-4">User Profile</h2>

        <p>
            <strong>Username:</strong>
            <?php echo $user['username']; ?>
        </p>

        <p>
            <strong>Email:</strong>
            <?php echo $user['email']; ?>
        </p>

        <p>
            <strong>Account Created:</strong>
            <?php echo $user['created_at']; ?>
        </p>

        <div class="mt-3">

            <a href="edit_profile.php" class="btn btn-primary">
                Edit Profile
            </a>

            <a href="index.php" class="btn btn-secondary">
                Back to Store
            </a>

            <a href="delete_account.php"
               class="btn btn-danger"
               onclick="return confirm('Are you sure you want to delete your account?')">

               Delete Account
            </a>

            <a href="logout.php" class="btn btn-danger">
                Logout
            </a>

        </div>

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