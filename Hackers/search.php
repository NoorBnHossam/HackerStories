<?php
include("config/db_connect");
session_start();

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : "";
$search = str_replace("script", "", $search);


$sql = "SELECT title, content, id FROM stories WHERE title LIKE '%$search%' ORDER BY created_at";

$result = mysqli_query($conn, $sql);
$stories = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_free_result($result);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Search</title>
    <?php include('templates/header.php') ?>
</head>
<body>
<div class="row">
    <form action="search.php" method="GET">
        <div class="input-field col s12">
            <input type="text" name="search" id="search" placeholder="Search by Title">
            <button class="btn waves-effect waves-light" type="submit">Search</button>
        </div>
    </form>
</div>
<h4 class="center grey-text">
    <?php if (!empty($search)): ?>
        Search Results for "<?php echo htmlspecialchars($search); ?>"
    <?php else: ?>
        Please enter a search term.
    <?php endif; ?>
</h4>

<div class="container">
    <div class="row">
        <?php if (!empty($search) && count($stories) > 0): ?>
            <?php foreach ($stories as $story): ?>
                <div class="col s6 md3">
                    <div class="card z-depth-0">
                        <img src="img/book-4986.png" class="story" alt="">
                        <div class="card-content center">
                            <h6><?php echo htmlspecialchars($story['title']) ?></h6>
                            <ul>
                                <?php foreach (explode(',', $story['content']) as $ing): ?>
                                    <li><?php echo htmlspecialchars($ing) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="card-action right-align">
                            <a href="details.php?id=<?php echo $story['id'] ?>" class="brand-text">MORE INFO</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php elseif (!empty($search) && count($stories) === 0): ?>
            <p class="center grey-text">No matching search results for "<?php echo htmlspecialchars($search); ?>"</p>
        <?php endif; ?>
    </div>
</div>

<script>

    var searchTerm = "<?php echo htmlspecialchars($search); ?>";
    // Prevent the user from typing '<' or '>' in the search input
    document.getElementById('search').addEventListener('input', function (e) {
        this.value = this.value.replace(/[<>]/g, '');
    });
</script>
</body>
</html>
