<?php
    session_start();
    // Redirect anyone trying to access page before registration
    if (isset($_SESSION["username"]) === false)
    {
        header("Location: ../HTML + PHP/login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="icon" href="../Images/book-icon2.png" type="image/icon type">
    <title>The Library</title>
</head>
<body class="mainBody">
    <div id="successBox">
        <h1>Account Created Successfully!</h1>
        <br>
        <a class="formButton browseNow" href="../HTML + PHP/bookSearch.php?page=1">Start browsing</a>
    </div>
    <footer class="searchFooter">
        <p class="footerNote">©2023, TheLibrary</p>
    </footer> 
</body>
</html>