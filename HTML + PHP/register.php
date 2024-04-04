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
       
        $usernameError = $passwordError = $rePasswordError = "";
        $userErr = "registerInput";
        $passwordClass = "registerInput";
        $rePasswordClass = "registerInput";
        $passwordMsg = "Password must be exactly 6 characters long.";

        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            //Connection function
            $conn = connection("root", "");

            $usernameCheck = $conn->real_escape_string(trim($_POST["username"]));
            $password = $conn->real_escape_string(trim($_POST["password"]));
            $rePassword = $conn->real_escape_string(trim($_POST["rePassword"]));

            $query = "SELECT username FROM `users` WHERE username ='$usernameCheck'";
            
            $usernameExist = $conn->query($query);

            // Username validation
            if ($usernameExist->num_rows > 0)
            {
                $usernameError = "Username is taken";
                $userErr = "errorBox";
            }
            else if (strlen($usernameCheck) > 30)
            {
                
                $usernameError = "Username is too long";
                $userErr = "errorBox";
            }
            else if (empty($usernameCheck))
            {
                $usernameError = "Username is required";
                $userErr = "errorBox";
            }
            else
            {
                $_SESSION["username"] = $_POST["username"];
                $usernameError = "";
            }
            
            // Password validation
            if (strlen($password) === 6)
            {
                $_SESSION["password"] = $password;
            }
            else
            {
                $passwordError = "Password should be 6 characters long";
                $passwordClass = "errorBox";
                $passwordMsg = "";
            }

            if ($rePassword != $password)
            {
                $rePasswordError = "Passwords do not match";
                $passwordClass = "errorBox";
                $rePasswordClass = "errorBox";
            }
            else
            {
                $rePassword = $password;
            }

            //Send form data to 2nd part of registration
            if ($_SESSION["username"] === $_POST["username"] && $usernameError == "" && isset($_SESSION["password"]) && $rePassword == $password)
            {
                header("Location: ../HTML + PHP/registerPersonal.php");
            }
            $conn->close();
        }
    ?>
    <div class="registerForm">
        <h1>Library Registration</h1>
        <h2>Please enter your account details below</h2>
        <form method="post" id="accountRegister">
            <label for="username"><b>Username</b></label><br>
            <input class="<?php echo $userErr;?>" type="text" name="username" value="<?php echo htmlentities($username);?>" placeholder="E.g: library_user10"><br>
            <span class="error" id="usernameError"><?php echo $usernameError;?></span>
            <br><br>

            <label for="password"><b>Password</b></label><br>
            <input class="<?php echo $passwordClass;?>" id="password" type="password" name="password" value="<?php echo htmlentities($password);?>" placeholder="Must be 6 characters long"><br>
            <?php
                if ($passwordError == "")
                {
                    echo '<span class="info">' . $passwordMsg . '</span>';
                    echo '<span class="error">' . $passwordError . '</span>';
                }
                else
                {
                    echo '<span class="error">' . $passwordError . '</span>';
                }
            ?>
            <br><br>

            <label for="rePassword"><b>Re-Enter Password</b></label><br>
            <input class="<?php echo $rePasswordClass;?>" id="rePassword" type="password" name="rePassword" value="<?php echo htmlentities($rePassword);?>"><br>
            <span class="error" id="rePasswordError"><?php echo $rePasswordError?></span>
            <br><br>
            <input class="formButton" type="submit" value="Continue">
            <p>Already have an account?<a href="../HTML + PHP/login.php">Click here!</a><p>
        </form>
    </div>
    <footer>
        <p class="footerNote">©2023, TheLibrary</p>
    </footer> 
</body>
</html>