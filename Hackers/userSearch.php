<?php
session_start();
include 'config/db_connect';
mysqli_report(MYSQLI_REPORT_OFF);

$searchOutput = ""; 

if (isset($_GET['id'])) {
    $id =  $_GET['id']; 

    $sql = "SELECT username FROM users WHERE user_id = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Fetching the results and constructing the output string
        $resultsFound = false;
        while ($row = mysqli_fetch_assoc($result)) {
            $searchOutput .= "<div style='text-align: center;'>User Name: " . htmlspecialchars($row['username']) . "</div><br>";
            $resultsFound = true;
        }
        if (!$resultsFound) {
            $searchOutput = "No results found.";
        }
    } else {
        // If the query fails, this message is shown instead of any error
        $searchOutput = "No results found.";
    }
}
?>
<!DOCTYPE html>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

<div>
            <a href="index.php?page=en" class="brand-logo" style="color: #000; font-size: 2em;">
                <i class="material-icons" style="color: #26a69a; font-size: 1.5em;">home</i>
            </a>
        </div>
   
<html>
<head>
    <title>Search by ID</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        h2, h3 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"], input[type="submit"] {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-sizing: border-box; 
        }

        input[type="submit"] {
            background-color: #26a69a;
            color: white;
            cursor: pointer;
            border: none;
        }

        input[type="submit"]:hover {
            background-color: #26a69a;
        }

        .search-result {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <br><br><br><br>
    <div class="container">
        <h2>Search by ID</h2>
    
        <form action="userSearch.php" method="GET">
            <label for="id">Enter User ID:</label>
            <input type="text" id="id" name="id"><br>
            <input type="submit" value="Search">
        </form>
        <div class="search-result">
            <h3>Search Results:</h3>
            <?php echo $searchOutput; ?>
        </div>
    </div>
</body>
</html>