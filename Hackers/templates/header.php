<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="800">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>0xKimoz</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <style type="text/css">
        .brand {
            background: #cbb09c !important;
            color: #007acc !important;
        }
        .brand-text {
            color: #007acc !important;
        }
        form {
            max-width: 460px;
            margin: 20px auto;
            padding: 20px;
        }
        .story {
            width: 100px;
            margin: 40px auto -30px;
            display: block;
            position: relative;
            top: -30px;
        }

        /* Responsive Styles */
        @media screen and (max-width: 768px) {
            .nav-mobile {
                display: block;
            }
            .nav-mobile li {
                display: block;
                text-align: center;
                width: 100%;
            }
            .brand-logo {
                margin: 0 auto; /* Center the brand logo */
            }
        }
    </style>
</head>
<body class="grey lighten-4">
    <nav class="white z-depth-0">
        <div class="container">
            <a href="index.php?page=en" class="brand-logo" style="color: #000;">Hackers stories</a>
            <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul id="nav-mobile" class="right hide-on-med-and-down" style="display: flex; align-items: center;">
                <li><a href="add.php" class="btn waves-effect waves-light">ADD A story</a></li>
                <li><a href="edit.php" id="edit" class="btn waves-effect waves-light">Edit Profile</a></li>
                <li><a href="userSearch.php" class="btn waves-effect waves-light">Search Users</a></li>
                <?php if ($_SESSION['username'] === 'admin'): ?>
                    <li><a href="reports.php" class="btn waves-effect waves-light">Reports</a></li>
                <?php endif; ?>
                <li><a href="#" id="profile-icon"><i class="large material-icons" style="color: #26a69a; font-size: 40px; margin-top: 4px;">account_circle</i></a></li>
            </ul>
        </div>
    </nav>

    <ul class="sidenav" id="mobile-demo">
        <li><a href="add.php" class="waves-effect waves-light">ADD A story</a></li>
        <li><a href="edit.php" id="edit" class="waves-effect waves-light">Edit Profile</a></li>
        <li><a href="userSearch.php" class="waves-effect waves-light">Search Users</a></li>
        <?php if ($_SESSION['username'] === 'admin'): ?>
            <li><a href="reports.php" class="waves-effect waves-light">Reports</a></li>
        <?php endif; ?>
        <li><a href="#" id="profile-icon"><i class="material-icons" style="color: black;">account_circle</i></a></li>
    </ul>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var profileIconLink = document.getElementById("profile-icon");
            var editLink = document.getElementById("edit");

            profileIconLink.addEventListener("click", function(e) {
                e.preventDefault();
                window.location.href = "profile.php?uid=<?php echo $_SESSION['user_id']; ?>";
            });

            editLink.addEventListener("click", function(e) {
                e.preventDefault();
                window.location.href = "edit.php?id=<?php echo $_SESSION['user_id']; ?>";
            });
        });
    </script>
</body>
