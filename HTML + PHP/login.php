<?php
    session_start();
    error_reporting(0);
    include "../HTML + PHP/databaseConnect.php";
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
    <?php
        $passwordError = $accError = "";
        $PStyle = "loginInput";
        $UStyle = "loginInput";

        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            //Connection function
            $conn = connection("root", "");

            $username = $conn->real_escape_string($_POST["username"]);
            $password = $conn->real_escape_string($_POST["password"]);

            if ($conn)
            {
                $queryUser = "SELECT * FROM `users` WHERE username = '$username'";
                $queryPassword = "SELECT * FROM `users` WHERE password = '$password'";
                $user = $conn->query($queryUser);
                $pass = $conn->query($queryPassword);

                //Login + validation
                if ($user->num_rows > 0)
                {
                    if ($pass->num_rows > 0)
                    {
                        $row1 = $user->fetch_assoc();
                        $row2 = $pass->fetch_assoc();
                        $_SESSION['username'] = $row1['Username'];
                        $_SESSION['password'] = $row2['Password'];
                        header("Location: ../HTML + PHP/main.php");
                        exit();
                    }
                    else
                    {
                        $passwordError = "Incorrect password";
                        $PStyle = "errorBox";
                    }
                }
                else
                {
                    $accError = "Account doesn't exist";
                    $UStyle = "errorBox";
                    $PStyle = "errorBox";
                }
            }
            $conn->close();
        }
    ?>
    <div id="loginBox">
        <h1>Welcome to the Library!</h1>
        <h2>Please enter your account details</h2>
        <form method="post" class="formBig">
            <span class="error"><?php  echo $accError;?></span>
            <br><br>

            <label for="username"><b>Username</b></label><br>
            <input class="<?php echo $UStyle;?>" type="text" name="username" value="<?php echo htmlentities($username);?>"required>
            <br><br>

            <label for="password"><b>Password</b></label><br>
            <input class="<?php echo $PStyle;?>" type="password" name="password" value="<?php echo htmlentities($password);?>" required oninvalid="setCustomValidity('Please enter your password.')" oninput="setCustomValidity('')"><br>
            <span class="error"><?php echo $passwordError;?></span>
            <br><br>

            <input class="formButton" type="submit" value="Login">
        </form>
        <p>Not registered yet?<a href="../HTML + PHP/register.php">Click here!</a><p>
    </div>
    <footer>
        <p class="footerNote">©2023, TheLibrary</p>
    </footer> 
</body>
</html> 