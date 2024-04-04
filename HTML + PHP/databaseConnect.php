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
        //This function will allow any other script to connect to
        //the librarydb web server. It also includes some error logging
        //that goes into apache/logs/error.logs for debugging
        function connection($username, $password)
        {
            try
            {
                $servername = "localhost";
                $dbname = "librarydb";
                $conn = new mysqli($servername, $username, $password, $dbname);
                
                return $conn;
            }
            catch (Exception $e)
            {
                error_log("Error: ". $e->getMessage(), 0);
            }
        }
    ?>
</body>
</html>