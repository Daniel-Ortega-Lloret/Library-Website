<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="icon" href="../Images/book-icon2.png" type="image/icon type">
    <title>The Library</title>
</head>
<body>
    <?php
        // Get rid of session superglobal
        session_start();
        session_destroy();
        header("Location: ../HTML + PHP/login.php");
    ?>
    <div class="separator"></div>
    <footer>
        <p class="footerNote">©2023, TheLibrary</p>
    </footer> 
</body>
</html>