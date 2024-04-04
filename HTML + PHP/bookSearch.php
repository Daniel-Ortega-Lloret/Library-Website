<?php
    session_start();
    error_reporting(0);
    include "../HTML + PHP/databaseConnect.php";

    // Redirect anyone trying to access page before login
    if (isset($_SESSION["username"]) === false)
    {
        header("Location: ../HTML + PHP/login.php");
    }
    
    // Function to highlight specific letters that user entered in the table display
    function highlightSearchTerm($text, $searchTerm) 
    {
        //Variables to make sure letters stay how they were before highlighting
        $searchTermLower = strtolower($searchTerm);
        $searchTermUpper = strtoupper($searchTerm);
        
        //Function will match and replace any set pattern/s with a <mark> element for highlighting
        $text = preg_replace("/($searchTermLower|$searchTermUpper)/i", "<mark class='searchHighlight'>$0</mark>", $text);
    
        return $text;
    }

    $username = $_SESSION["username"];
    $password = $_SESSION["password"];

    //Connection function
    $conn = connection($username, $password);

    //If user clicked the search button set some session superglobal values
    //too keep track of user search through pagination
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $page = 1;
        if ($_POST["title/author"] != "")
        {
            $_SESSION["search"] = $conn->real_escape_string($_POST["title/author"]);
        }
        else
        {
            unset($_SESSION["search"]);
        }

        if ($_POST["genre"] != 0)
        {
            $_SESSION["genre"] = $conn->real_escape_string($_POST["genre"]); 
        }
        else
        {
            unset($_SESSION["genre"]);
        }

        if (empty($_SESSION["search"]) && empty($_SESSION["genre"]))
        {
            header("Location: ../HTML + PHP/bookSearch.php?error=3");
            exit();
        }
    }
    // Default page to 1 if search form not submitted
    else
    {
        $page = 0;
        if (isset($_GET["page"]))
        {
            $page = $_GET["page"];
        }
        else
        {
            $page = 1;
        }
    }
    
    
    
    if ($conn->connect_error) 
    {
        die("Connection failed". $conn->connect_error);
    }
    else
    {
        $rowLimit = 5;

        // SQL query constructor
        $where = "";
        if (isset($_SESSION["search"]) && isset($_SESSION["genre"])) 
        {
            $search = $_SESSION["search"];
            $genreSelect = $_SESSION["genre"];
            $where .= "(books.CategoryID = '$genreSelect' AND (BookTitle LIKE '$search%' OR BookTitle LIKE '%$search%'
                            OR BookTitle LIKE '%$search' OR Author LIKE '$search%' 
                            OR Author LIKE '%$search' OR Author LIKE '%$search%'))";
        } 
        else if (isset($_SESSION["search"]) && !isset($_SESSION["genre"])) 
        {
            $search = $_SESSION["search"];
            $where .= "(BookTitle LIKE '$search%' OR BookTitle LIKE '%$search%' 
                            OR BookTitle LIKE '%$search' OR Author LIKE '$search%' 
                            OR Author LIKE '%$search' OR Author LIKE '%$search%')";
        } 
        else if (!isset($_SESSION["search"]) && isset($_SESSION["genre"])) 
        {
            $genreSelect = $_SESSION["genre"];
            $where .= "(books.CategoryID = '$genreSelect')";
        }
        
        $query = "SELECT BookTitle, Author, Edition, categories.CategoryDescription, Reserved, ISBN
                    FROM `books`
                    JOIN `categories` ON books.CategoryID = categories.CategoryID";

        if ($where !== "")
        {
            $query .= " WHERE $where";
        }

        $result = $conn->query($query);

        // If search returns nothing, return this error
        if ($result->num_rows === 0)
        {
            header("Location: ../HTML + PHP/bookSearch.php?error=2");
            unset($_SESSION["search"]);
            unset($_SESSION["genre"]);
            exit();
        }

        // Store result into an array of arrays for pagination
        $rows = [];
        while ($row = $result->fetch_assoc())
        {
            $rows[] = $row;
        }

        $totalPages = ceil(count($rows) / $rowLimit);
        $offset = ($page - 1) * $rowLimit;
        $current = array_slice($rows, $offset, $rowLimit);
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
    <div class="stickNav">
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
    </div>
    <div id="searchBox">
        <h1>What book are you looking for today?</h1>
        <form method="post" action="../HTML + PHP/bookSearch.php?error = 0">
            <input type="text" class="searchInput" id="ftitle" name="title/author" placeholder="Title/Author">
            <select class="searchInput" id="genre" name="genre">
                <option value="0">Select a Genre</option>
                <?php
                    //Display category names from web server
                    $conn = connection("root", "");

                    if ($conn->connect_error) 
                    {
                        die("Connection failed". $conn->connect_error);
                    }
                    $query = "SELECT CategoryID, CategoryDescription FROM Categories";
                    $result = $conn->query($query);

                    if ($result->num_rows > 0) 
                    {
                        while ($row = $result->fetch_assoc()) 
                        {
                            echo "<option value='" . $row["CategoryID"] . "'>" . $row["CategoryDescription"] . "</option>";
                        }
                    }
                    $conn->close();
                ?>
            </select><br>
            <input id="searchButton" type="submit" value="Search">
        </form>
        <?php
            echo '<a class="pageButtons pageButton" href="../HTML + PHP/bookSearch.php?error=4">Clear Search</a>';

            if ($result->num_rows > 0)
            {
                // Error checking messages

                if ($_GET["error"] == 2)
                {
                    echo '<p class="info">0 results found</p><br>';
                }
                else
                {
                    if (!isset($_GET["error"]) or $_GET["error"] == 0)
                    {
                    echo "<p class='info'>Select the books you wish to reserve</p>";  
                    }
                    else if ($_GET["error"] == 1)
                    {
                        echo '<p class="error">You must select at least one reservation</p><br>';
                    }
                    else if ($_GET["error"] == 3)
                    {
                        echo '<p class="error">You must enter something before searching</p><br>';
                    }
                    else if ($_GET['error'] == 4)
                    {
                        unset($_SESSION["search"]);
                        unset($_SESSION["genre"]);
                        header("Location: ../HTML + PHP/bookSearch.php?error=0");
                    }

                    // Pagination buttons
                    echo "<div class='pageButtons'>";
                    if ($page > 1 && isset($_GET["error"]) == false)
                    {
                        echo '<br><a class="pageButton" href="../HTML + PHP/bookSearch.php?page=' . ($page - 1) . '">Previous</a>';
                    }
                    else if ($page > 1 && isset($_GET["error"]) == true)
                    {
                        echo '<br><a class="pageButton" href="../HTML + PHP/bookSearch.php?error=' . $_GET["error"] . '&page=' . ($page - 1) . '">Previous</a>';
                    } 

                    if ($page < $totalPages && isset($_GET["error"]) == false)
                    {
                        echo '<br><a class="pageButton" href="../HTML + PHP/bookSearch.php?page=' . ($page + 1) . '">Next</a>';
                    }
                    else if($page < $totalPages && isset($_GET["error"]) == true)
                    {
                        echo '<br><a class="pageButton" href="../HTML + PHP/bookSearch.php?error=' . $_GET["error"] . '&page=' . ($page + 1) . '">Next</a>';
                    }
                    echo "</div>";

                    // Search table display and reservation form hybrid
                    echo "<form action='../HTML + PHP/reservationShow.php' method='post'>";
                    echo "<table class='table'>";
                    echo "<thead><tr><th>";
                    echo "<b>Book Title</b></th>";
                    echo "<th><b>Author</b></th>";
                    echo "<th><b>Edition</b></th>";
                    echo "<th><b>Category</b></th>";
                    echo "<th><b>Reserve</b></th></tr></thead>";

                    foreach ($current as $row)
                    {
                        $bookID = strval($row["ISBN"]);
                        echo "<tr><td>";
                        $highlightTitle = highlightSearchTerm($row["BookTitle"], $search);
                        echo $highlightTitle;
                        echo("</td><td>");
                        $highlightAuthor = highlightSearchTerm($row["Author"], $search);
                        echo $highlightAuthor;
                        echo("</td><td>");
                        echo($row["Edition"]);
                        echo("</td><td>");
                        echo($row["CategoryDescription"]);
                        echo("</td><td>");
                        if ($row['Reserved'] == 'Y')
                        {
                            echo "<p>Unavailable</p>";
                        }
                        else
                        {
                            echo "<input type='checkbox' name='$bookID'>";
                        }
                        echo "</td></tr>";
                    } 

                    echo "</table><br />";
                    echo '<p>Page ' . $page . ' of ' . $totalPages . ' </p><br>';
                    echo "<input class='formButton' type='submit' value='Reserve'>";
                    echo "</form>";
                }
                
            }
            else 
            {
                header("Location: ../HTML + PHP/bookSearch.php?error=2");
            }
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
        else
        {
            echo "<footer class='mainFooter'>";
            echo "<p>©2023, TheLibrary</p>";
            echo "</footer>";
        }
    ?>
</body>
</html>
<?php
    $conn->close();
?>