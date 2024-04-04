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
    <div class="whiteBox">
        <h1>Are you sure you want to remove the following books?</h1>
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
            else if (empty($bookID))
            {
                header("Location: ../HTML + PHP/main.php?error=1&page=" . $_SESSION["page"]);
                exit();
            }
            
            echo "<form action='../HTML + PHP/removeReservation.php' method='post'>";
            echo "<table class='table'>";
            echo "<thead><tr><th>";
            echo "<b>Book Title</b></th>";
            echo "<th><b>Author</b></th>";
            echo "<th><b>Edition</b></th>";
            echo "<th><b>Category</b></th></tr></thead>";
            foreach ($bookID as $ID)
            {
                $query = "SELECT BookTitle, Author, Edition, categories.CategoryDescription, ISBN
                        FROM `books`
                        JOIN `categories` ON books.CategoryID = categories.CategoryID
                        WHERE ISBN = '$ID';";
                
                $result = $conn->query($query);

                if ($result->num_rows > 0)
                {
                    while ($row = $result->fetch_assoc())
                    {
                        echo "<tr><td>";
                        echo($row["BookTitle"]);
                        echo("</td><td>");
                        echo($row["Author"]);
                        echo("</td><td>");
                        echo($row["Edition"]);
                        echo("</td><td>");
                        echo($row["CategoryDescription"]);
                        echo '<input type="hidden" name="' . $row["ISBN"] . '">';
                        echo("</td></tr>");
                    }
                }
            }
            echo "</table><br />";
            echo '<input class="sureButton" type="submit" value="Remove">';
            echo '<a class="sureButton browseNow" href="../HTML + PHP/main.php?page=1">Go Back</a>';
            echo "</form>";
        ?>
    </div>
</body>
</html>