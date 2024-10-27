<?php
session_start();

include("config/db_connect");

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    // Redirect to a different page if the user is not logged in
    header("location:some_error_page.php");
    exit;
}

$loggedUserId = $_SESSION['user_id'];

// Check if the 'uid' parameter exists in the URL
if (isset($_GET['uid'])) {
    $uid = $_GET['uid'];
} else {
    // 'uid' parameter is not provided
    header("location:some_error_page.php");
    exit;
}

// Fetch user details from the database based on the provided 'uid'
$user = null;
if ($conn) {
    $sql = "SELECT * FROM users WHERE user_id = '$uid'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $user = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
    }
}

// Check if the logged-in user's uid is not equal to 1 and the 'uid' parameter is equal to 1
if ($loggedUserId != 1 && $uid == 1) {
    // Unauthorized access
    header("location:unauthorized_access.php");
    exit;
}

// Retrieve the user's profile picture from the database
$userId = $_SESSION['user_id'];
$profilePicture = null; // Initialize profilePicture variable

$sql = "SELECT profile_picture FROM users WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $userId);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $profilePicture);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt); // Close the prepared statement

// Fetch stories added by the user
$stories = array();
if ($conn && $user) {
    $username = $user['username'];
    $sql = "SELECT title, content, id FROM stories WHERE username = '$username' ORDER BY created_at";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $stories[] = $row;
        }
        mysqli_free_result($result);
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>


            body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 50%;
            margin: 20px auto; 
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .blank {

            margin-top: 30px;
            padding: 20px;

        }

        .no-stories{
            margin-top: 30px;
            text-align: center;

        }
        /* Profile picture styles */
        img {
            display: block;
            max-width: 150px;
            height: auto;
            border-radius: 75px;
            margin: 20px auto;
        }

        /* User details styles */
        .user-details {
            background-color: #e7e7e7;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 30px;
        }

        .user-details strong {
            color: #2c3e50;
        }

        /* User stories styles */
        .user-stories {
            margin-bottom: 30px;
        }

        .user-stories h5 {
            color: #27ae60;
            margin-bottom: 15px;
        }

        .user-stories ul {
            list-style-type: none;
            padding: 0;
        }

        .user-stories li {
            background-color: #f9f9f9;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .user-stories button {
            margin-right: 10px;
        }

        /* Logout button styles */
        .logout-container {
            text-align: center;
            padding: 20px;
        }

        .logout-container a button {
            background-color: #c0392b;
            color: #fff;
        }

        /* Button hover effect */
        button:hover {
            opacity: 0.8;
            cursor: pointer;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .container {
                width: 95%;
            }

            .user-details, .user-stories li {
                text-align: center;
            }
        }
    </style>
</head>
<body>
<div class="blank"></div>
<div class="container">
    <?php include('templates/backtohome.php'); ?> 

    <?php if ($user): ?>
        <h4 class="center grey-text">Profile of <?php echo htmlspecialchars($user['username']); ?></h4>
        <?php if ($profilePicture): ?>
            <!-- Display the profile picture if available -->
            <?php $imagePath = 'profile_pics/' . $profilePicture; ?>
            <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Profile Picture">
        <?php else: ?>
            <img src="https://picsbed.top/file/jAFr%2B%2FhrwFj09IZdYTzOHIllTK7CrF2F5QLxPguzQM0%3D4" alt="Default Profile Picture" style="display: block; margin: 20px auto; border-radius: 75px;">
        <?php endif; ?>
        <!-- <div class="row user-details">
            <div class="col s12 m6">
                <h5>User Details:</h5>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
            </div>
        </div> -->
        <!-- Show Stories Section -->
        <div class="user-stories">
            <?php if (!empty($stories)): ?>
                <h5>User's Stories:</h5>
                <ul>
                <?php foreach ($stories as $story): ?>
                    <li>
                       
                        <?php echo htmlspecialchars($story['title']); ?> <strong> &nbsp</strong> 
                        <a href="delete_story.php?id=<?php echo $story['id']; ?>"><button class="btn waves-effect waves-light" style="background-color: #c0392b; border-radius: 25px;">Delete</button></a>
                        <a href="edit_story.php?id=<?php echo $story['id']; ?>"><button class="btn waves-effect waves-light" style="border-radius: 25px;">Edit</button></a>
                        <a href="details.php?id=<?php echo $story['id']; ?>"><button class="btn waves-effect waves-light" style="border-radius: 25px;">View</button></a>
                    </li>
                <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="no-stories">No stories found for this user.</p>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <p>User not found.</p>
    <?php endif; ?>
</div>
<div class="logout-container">
    <a href="logout.php"><button class="btn waves-effect waves-light" style="border-radius: 15px;">Logout</button></a>
</div>

</body>
</html>
