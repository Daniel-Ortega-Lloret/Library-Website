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
            exit();
        }
        
        include "../HTML + PHP/databaseConnect.php";
        $bookID = array_keys($_POST);
        $username = $_SESSION["username"];
        $password = $_SESSION["password"];

        //Connection function
        $conn = connection($username, $password);
        
        if ($conn->connect_error) 
        {
            die("Connection failed". $conn->connect_error);
        }
        else
        {
            foreach ($bookID as $ID)
            {
                $query = "INSERT INTO `reservations` (ISBN, Username, ReservedDate) VALUES ('$ID', '$username', CURDATE());";
                
                $conn->query($query);

                $query1 = "UPDATE `books` SET Reserved = 'Y' WHERE ISBN = '$ID';";
                $conn->query($query1);   
            }
            header("Location: ../HTML + PHP/main.php");
        }
    ?>
</body>
</html>