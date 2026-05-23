<?php

include 'config.php';

if(isset($_GET['token'])){

    $token = $_GET['token'];

    $sql = "SELECT * FROM users
            WHERE verification_token='$token'";

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){

        $update = "UPDATE users
                   SET is_verified='1',
                       verification_token=NULL
                   WHERE verification_token='$token'";

        mysqli_query($conn, $update);

        echo "

        <!doctype html>
        <html lang='en'>

        <head>

            <meta charset='utf-8'>

            <title>Email Verification</title>

            <link rel='stylesheet'
            href='https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css'>

        </head>

        <body>

        <div class='container mt-5'>

            <div class='alert alert-success text-center'>

                <h3>Email Verified Successfully!</h3>

                <p>
                    Your account is now verified.
                </p>

                <a href='login.php'
                   class='btn btn-primary'>

                   Login Now
                </a>

            </div>

        </div>

        </body>
        </html>

        ";

    } else {

        echo "

        <div class='container mt-5'>

            <div class='alert alert-danger text-center'>

                Invalid or expired verification link.

            </div>

        </div>

        ";
    }
}
?>