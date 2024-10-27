<?php
session_start();


$error = "";
$dataFetched = "";

if (isset($_GET['url'])) {
    $url = $_GET['url'];


    if (filter_var($url, FILTER_VALIDATE_URL)) {

        $dataFetched = @file_get_contents($url);
        if ($dataFetched === FALSE) {
            $error = "Failed to fetch data from the URL.";
        }
    } else {
        $error = "Invalid URL.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>URL Fetch Vulnerability Test</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    .navbar {
        background-color: #333;
        overflow: hidden;
        color: white;
        padding: 14px 16px;
        position: absolute;
        top: 0;
        width: 100%;
    }
    .navbar a {
        float: left;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
    }
    .main {
        background-color: white;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 600px;
        text-align: center;
        overflow: auto; 
        max-height: 60vh; 
    }
    input[type="text"], button {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }
    button {
        background-color: #26a69a;
        color: white;
        border: none;
        cursor: pointer;
    }
    button:hover {
        opacity: 0.9;
    }
    .error {
        color: red;
        margin: 5px 0;
    }
    pre {
        text-align: left;
        background-color: #f8f8f8;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        overflow-x: auto;
    }
    .copy-button {
        background-color: #26a69a;
        color: white;
        border: none;
        cursor: pointer;
        padding: 10px;
        margin-top: 10px;
        border-radius: 4px;
    }
    .copy-button:hover {
        opacity: 0.9;
    }
    #fetchedDataContainer {
        display: none;
    }
    .main::-webkit-scrollbar {
        width: 12px;
    }
    .main::-webkit-scrollbar-track {
        background: #f0f0f0;
    }
    .main::-webkit-scrollbar-thumb {
        background-color: #26a69a;
        border-radius: 10px;
        border: 3px solid #f0f0f0;
    }
</style>
</head>
<body>
<div class="navbar">
    <a href="index.php">Hacker Stories</a>
</div>

<div class="main">
    <h2>Get Idea</h2>
    <form action="idea.php" method="GET">
        <label for="url">Enter URL to fetch data from:</label>
        <input type="text" id="url" name="url" placeholder="http://example.com">
        <button type="submit">Fetch Data</button>
    </form>
    <div id="fetchedDataContainer">
        <?php
        if (isset($_GET['url'])) {
            if ($error) {
                echo '<div class="error">' . htmlspecialchars($error) . '</div>';
            } else {
                echo '<div><strong>Fetched Data:</strong></div>';
                echo '<pre><code id="fetchedData">' . htmlspecialchars($dataFetched) . '</code></pre>';
                echo '<button class="copy-button" onclick="copyToClipboard()">Copy</button>';
            }
        }
        ?>
    </div>
</div>
<script>
    function copyToClipboard() {
        var copyText = document.getElementById("fetchedData").innerText;
        navigator.clipboard.writeText(copyText).then(function() {
            alert("Copied to clipboard");
        }, function(err) {
            alert("Failed to copy: ", err);
        });
    }

    // Show fetched data container if data is fetched
    <?php if (isset($_GET['url']) && !$error): ?>
        document.getElementById('fetchedDataContainer').style.display = 'block';
    <?php endif; ?>
</script>
</body>
</html>
