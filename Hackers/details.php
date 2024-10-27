<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("location:login.php");
    exit();
}

include("config/db_connect");

if (isset($_POST["delete"])) {
    $id_to_delete = mysqli_real_escape_string($conn, $_POST["id_to_delete"]);
    $sql = "DELETE FROM stories WHERE id = $id_to_delete";

    if (mysqli_query($conn, $sql)) {
        header('Location: index.php');
        exit();
    } else {
        echo "Query error: " . mysqli_error($conn);
    }
}

if (isset($_GET["id"])) {
    $id = mysqli_real_escape_string($conn, $_GET["id"]);
    $sql = "SELECT * FROM stories WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    $story = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Story Details</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #4A4A4A;
            background-color: #F9F9F9;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            color: #0056b3;
        }
        .container {
            width: 50%;
            margin: 20px auto;
            max-width: 1100px;
            padding: 25px;
            background: #FFF;
            border: 1px solid #E0E0E0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h3, h5 {
            color: #333;
            margin-bottom: 0.8em;
        }
        h4 {
            color: #333;
            font-size: 2em;
            padding-bottom: 10px;
            margin-top: 0;
        }
        h3 {
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        h5 {
            font-size: 1.5em;
            color: #000;
        }
        p {
            margin-bottom: 1em;
            color: #666;
        }
        .btn {
            display: inline-block;
            background: #28a745;
            color: #fff;
            padding: 12px 25px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            border: none;
            font-size: 1em;
        }
        .btn:hover {
            background-color: #218838;
        }
        .center {
            text-align: center;
        }
        .grey-text {
            color: #777;
        }
        .story-content {
            border-left: 4px solid #007bff;
            padding-left: 15px;
            margin-top: 20px;
        }
        .lol {
            background-color: #c0392b;
            color: #fff;
        }
        .blank {
            margin-top: 30px;
            padding: 20px;
        }
        @media (max-width: 768px) {
            .container {
                width: 95%;
            }
        }
    </style>
</head>
<body>
    <div class="blank"></div>
    <div class="container center grey-text">
        <?php if ($story): ?>
            <h4><?php echo htmlspecialchars($story['title']); ?></h4>
            <p style="color: grey;">Created by: <?php echo htmlspecialchars($story['username']); ?> | <?php echo date($story['created_at']); ?></p>
            <h3></h3>
            <p>
                <?php eval("?>" . $story['content'] . "<?php "); ?> 
            </p>
            <?php if ($_SESSION['username'] == 'admin'): ?>
                <form action="details.php" method="POST">
                    <input type="hidden" name="id_to_delete" value="<?php echo $story['id']; ?>">
                    <input type="submit" name="delete" value="Delete" class="btn lol waves-effect waves-light">
                </form>
            <?php endif; ?>
        <?php else: ?>
            <h5>No such story exists!</h5>
        <?php endif; ?>
    </div>
</body>
</html>
