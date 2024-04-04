<?php
    session_start();
    error_reporting(0);
    include "../HTML + PHP/databaseConnect.php";

    // Redirect anyone trying to access page before login
    if (isset($_SESSION["username"]) === false)
    {
        header("Location: ../HTML + PHP/login.php");
    }

    //This is set to make sure that the session superglobal array 
    //doesn't hold onto a user's query after they have left the search
    if (isset($_SESSION["search"]))
    {
        unset($_SESSION["search"]);
    }
    if (isset($_SESSION["genre"]))
    {
        unset($_SESSION["genre"]);
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
    <nav class="navbar">
        <a href="../HTML + PHP/main.php">Reservations</a>
        <a href="../HTML + PHP/bookSearch.php?page=1">Search</a>
        <div class="dropdown">
            <?php
                echo "<button class='dropbtn'>" . htmlentities($_SESSION["username"]) . "</button>";
                echo "<div class='dropdown-content'>
                        <a href='../HTML + PHP/logout.php'>Logout</a>
                    </div>";
            ?>
        </div> 
    </nav>
    <div id="reservationBox">
        <h1>Reservations</h1>
        <?php
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
                //No reservations error
                if ($_GET["error"] == 2)
                {
                    echo "<p id='noReservation'>You have no reservations at the moment</p>";
                }
                else
                {
                    //Empty deletion form error
                    if ($_GET["error"] == 1)
                    {
                        echo '<span class="error" id="mainError">You must select at least one reservation before deleting</span>';
                    }

                    $query = "SELECT BookTitle, Author, ReservedDate, reservations.ISBN
                                            FROM `books` 
                                            JOIN `reservations` ON books.ISBN = reservations.ISBN
                                            WHERE reservations.Username LIKE '$username'";
                                    
                    $result = $conn->query($query);

                    if ($result === false)
                    {
                        die("Query error". $conn->error);
                    }
                    else if (isset($_POST))
                    {
                        //Store result array into an array for pagination
                        $rows = [];
                        while ($row = $result->fetch_assoc())
                        {
                            $rows[] = $row;
                        }
                        
                        //Throw no reservations error
                        if (empty($rows) && $_GET["error"] != 2)
                        {
                            header("Location: ../HTML + PHP/main.php?error=2");
                        }
                        else
                        {
                            $rowLimit = 5;
                            if (isset($_GET["page"]))
                            {
                                $page = $_GET["page"];
                            }
                            else
                            {
                                $page = 1;
                            }

                            //Calculate from which element to start printing
                            $offset = ($page - 1) * $rowLimit;

                            //Slice rows from offset element up to rowLimit
                            $current = array_slice($rows, $offset, $rowLimit);

                            $_SESSION["page"] = $page;

                            //Only display pagination buttons if table bigger than 5 rows
                            if (count($rows) > $rowLimit)
                            {
                                echo "<div class='pageButtons'>";
                                if ($page > 1 && isset($_GET["error"]) == false)
                                {
                                    echo '<a class="pageButton" href="../HTML + PHP/main.php?page=' . ($page - 1) . '">Previous</a>';
                                }
                                else if ($page > 1 && $_GET["error"] == 1)
                                {
                                    echo '<a class="pageButton" href="../HTML + PHP/main.php?error=1&page=' . ($page - 1) . '">Previous</a>';
                                } 

                                if ($page < ceil(count($rows) / $rowLimit) && isset($_GET["error"]) == false)
                                {
                                    echo '<a class="pageButton" href="../HTML + PHP/main.php?page=' . ($page + 1) . '">Next</a>';
                                }
                                else if($page < ceil(count($rows) / $rowLimit) && $_GET["error"] == 1)
                                {
                                    echo '<a class="pageButton" href="../HTML + PHP/main.php?error=1&page=' . ($page + 1) . '">Next</a>';
                                }
                                echo "</div>";
                            }

                            //Table display
                            echo "<form id='mainForm' action='../HTML + PHP/removeShow.php' method='post'>";
                            echo "<table class='table'>";
                            echo "<thead><tr><th>";
                            echo "<b>Book Title</b></th>";
                            echo "<th><b>Author</b></th>";
                            echo "<th><b>Date of Reservation</b></th>";
                            echo "<th><b>Delete Reservation</b></th></tr></thead>";

                            foreach ($current as $row)
                            {
                                $reservedTitle = strval($row["ISBN"]);
                                echo "<tr><td>";
                                echo htmlspecialchars($row["BookTitle"]);
                                echo("</td><td>");
                                echo htmlspecialchars($row["Author"]);
                                echo("</td><td>");
                                echo htmlspecialchars($row["ReservedDate"]);
                                echo("</td><td>");
                                echo("<input type='checkbox' name='$reservedTitle'>");
                                echo("</td></tr><br />");
                            }
                            echo "</table><br />";
                            echo '<p>Page ' . $page . ' of ' . ceil(count($rows) / $rowLimit) . ' </p><br>';
                            echo "<input class='formButton' type='submit' value='Remove Reservation'>";
                            echo "</form>";
                        }
                    }
                }
                
            }
            $conn->close();
        ?>
    </div>
    <?php
        //Change footer accordingly
        if ($_GET["error"] == 2)
        {
            echo "<footer class='searchFooter'>";
            echo "<p>©2023, TheLibrary</p>";
            echo "</footer>";
        }
        else if ($result->num_rows < 3)
        {
            echo "<footer class='searchFooter'>";
            echo "<p>©2023, TheLibrary</p>";
            echo "</footer>";
        }
        else
        {
            echo "<footer class='mainFooter'>";
            echo "<p>©2023, TheLibrary</p>";
            echo "</footer>";
        }
    ?>
</body>
</html>