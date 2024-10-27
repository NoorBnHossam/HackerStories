<?php

$login = 0;
$invalid  = 0;
$alertMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include("config/db_connect");
    $username = $_POST["username"];
    $password = $_POST["password"];
    $stmt = $conn->prepare("SELECT * FROM `users` WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $num = $result->num_rows;
        if ($num != 0) {
            echo "LOGIN SUCCESSFULLY";
            session_start();
            $user_data = $result->fetch_assoc();
            $_SESSION["user_id"] = $user_data["user_id"];
            $_SESSION["username"] = $username;
            $_SESSION["password"] = $password;

            $page = 'en';

            header("location:index.php?page=" . $page);
        } else {
            $alertMessage = "Invalid credentials";
        }
    }

    $stmt->close();
    $conn->close();
}

?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="refresh" content="800">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .container {
      max-width: 450px;
      margin-top: 120px;
      padding: 30px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .form-label {
      font-weight: bold;
    }
    .btn-primary {
      background-color: #26a69a;
      border: none;
    }
    .btn-primary:hover {
      background-color: #26a69a;
    }
    a{
      color: #26a69a;
    }
  </style>
</head>
<body>

<div class="container mt-5">
  <h2 class="text-center mt-3">Login</h2>
  <?php if ($alertMessage): ?>
    <div class="alert alert-danger" role="alert">
      <?php echo $alertMessage; ?>
    </div>
  <?php endif; ?>
  <form action="login.php" method="POST">
    <div class="mb-3">
      <label for="username" class="form-label">Username</label>
      <input type="text" class="form-control" placeholder="username" name="username" id="username" required>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" class="form-control" placeholder="password" name="password" id="password" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">LOGIN</button>
  </form>
  <div class="text-center mt-3">
    <a href="sign.php">Register?</a>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
