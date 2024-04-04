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
        session_start();
        
        // Redirect anyone trying to access page before login
        if (isset($_SESSION["username"]) === false)
        {
            header("Location: ../HTML + PHP/login.php");
        }
        
        include "../HTML + PHP/databaseConnect.php";
        $bookID = array_keys($_POST);
        
        //Connection function
        $conn = connection("root", "");

        if ($conn->connect_error) 
        {
            die("Connection Error". $conn->connect_error);
        }
        else if (empty($bookID)) //Empty deletion form validation
        {
            header('Location: ../HTML + PHP/main.php?error=1&page=' . $_SESSION["page"]);
            exit();
        }
        else
        {
            foreach ($bookID as $ID)
            {
                $query = "DELETE FROM `reservations` WHERE ISBN = '$ID';";
                $conn->query($query);

                $query2 = "UPDATE `books` SET Reserved = 'N' WHERE ISBN = '$ID';";
                $conn->query($query2);   
            }
            header("Location: ../HTML + PHP/main.php");
        }
        $conn->close();
    ?>
    <div class="separator"></div>
    <footer>
        <p class="footerNote">©2023, TheLibrary</p>
    </footer> 
</body>
</html>