<?php

$success = 0;
$user = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  include ("config/db_connect");
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM `users` WHERE username='$username'";

    $result = mysqli_query($conn, $sql);

    if($result)
    {
        $num = mysqli_num_rows($result);
        if($num != 0)
        {
           $user= 1; 
        }
        else
        {
              $sql = "INSERT INTO `users` (username, password, profile_picture) VALUES ('$username', '$password', 'hacker.png')";

              $result = mysqli_query($conn, $sql);
              if ($result) {
                    $success = 1;
                    header('location:login.php');
                 } else {
                     echo "Error: " . mysqli_error($conn);
                 }
        }
    }

}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIGN UP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
      body {
        background-color: #f8f9fa;
      }
      .container {
        max-width: 500px;
        margin-top: 100px;
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }
      .form-label {
        font-weight: bold;
      }
      .btn-primary {
        background-color: #26a69a;
        border-color: #26a69a;
      }
      .btn-primary:hover {
        background-color: #26a69a;
        border-color: #26a69a;
      }
      .alert {
        margin-top: 20px;
      }
      a{
      color: #26a69a;
    }
    </style>
  </head>
  <body>

  <div class="container">
    <h2 class="text-center mb-4">Sign Up</h2>
    <?php 
    if($user) {
      echo '<div class="alert alert-danger" role="alert">User already exists!</div>';
    }
    if($success) {
      echo '<div class="alert alert-success" role="alert">Signup successful</div>';
    }
    ?>

    <form action="sign.php" method="POST">
      <div class="mb-3">
        <label for="exampleInputusername1" class="form-label">Username</label>
        <input type="text" class="form-control" placeholder="username" name="username" required>
      </div>
      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" class="form-control" placeholder="password" name="password" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Sign Up</button>
    </form>
    <h5 class="text-center mt-3">Already have an account? <a href="login.php">Login</a></h5>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>
