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

if(isset($_POST['update'])){

    $username = $_POST['username'];
    $email = $_POST['email'];

    $updateQuery = "UPDATE users 
                    SET username='$username', email='$email'
                    WHERE id='$id'";

    $updateResult = mysqli_query($conn, $updateQuery);

    if($updateResult){

        $_SESSION['username'] = $username;

        header("Location: profile.php");
        exit();

    } else {

        echo "Update Failed";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>

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

        <h2 class="mb-4">Edit Profile</h2>

        <form method="POST">

            <div class="mb-3">

                <label class="form-label">
                    Username
                </label>

                <input type="text"
                       name="username"
                       class="form-control"
                       value="<?php echo $user['username']; ?>"
                       required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Email
                </label>

                <input type="email"
                       name="email"
                       class="form-control"
                       value="<?php echo $user['email']; ?>"
                       required>

            </div>

            <button type="submit"
                    name="update"
                    class="btn btn-primary">

                Update Profile
            </button>

            <a href="profile.php"
               class="btn btn-secondary">

               Cancel
            </a>

        </form>

    </div>

</div>


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