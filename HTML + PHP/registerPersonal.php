<?php
    session_start();
    error_reporting(0);
    include "../HTML + PHP/databaseConnect.php";

    // Redirect anyone trying to access page before registering a username
    if (isset($_SESSION["username"]) === false)
    {
        header("Location: ../HTML + PHP/register.php");
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
    <?php
        
        $fnameError = $lnameError = $ad1Error = $ad2Error = $cityError = $telError = $mobError = "";
        $fname = $lname = $ad1 = $ad2 = $city = $tel = $mob = "";
        $fnameClass = $lnameClass = $ad1Class = $ad2Class = $cityClass = $telClass = $mobClass = "registerInput";
        $fnameOld = $lnameOld = $ad1Old = $ad2Old = $cityOld = $telOld = $mobOld = "";
        $username = $_SESSION["username"];
        $password = $_SESSION["password"];
        $telMsg = "Telephone must be 10 digits long";
        $mobMsg = "Mobile must be 10 digits long";

        //Connection function
        $conn = connection("root", "");

        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            // First name validation
            if (strlen($_POST["fname"]) <= 30)
            {
                $fnameTest =  $conn->real_escape_string(trim($_POST["fname"]));

                if (empty($fnameTest))
                {
                    $fnameError = "First name is required";
                    $fnameClass = "errorBox";
                    $fnameOld =  $conn->real_escape_string($_POST["fname"]);
                }
                else
                {
                    $fname =  $conn->real_escape_string($_POST["fname"]);
                    $fnameOld =  $conn->real_escape_string($_POST["fname"]); 
                }
            }
            else
            {   
                $fnameError = "First name is too long";
                $fnameClass = "errorBox";
                $fnameOld =  $conn->real_escape_string($_POST["fname"]);
            }

            // Last name validation
            if (strlen($_POST["lname"]) <= 30)
            {
                $lnameTest =  $conn->real_escape_string(trim($_POST["lname"]));

                if (empty($lnameTest))
                {
                    $lnameError = "First name is required";
                    $lnameClass = "errorBox";
                    $lnameOld =  $conn->real_escape_string($_POST["lname"]);
                }
                else
                {
                    $lname =  $conn->real_escape_string($_POST["lname"]);
                    $lnameOld =  $conn->real_escape_string($_POST["lname"]); 
                }
                $lname =  $conn->real_escape_string($_POST["lname"]);
                $lnameOld =  $conn->real_escape_string($_POST["lname"]);
            }
            else
            {   
                $lnameError = "Last name is too long";
                $lnameClass = "errorBox";
                $lnameOld =  $conn->real_escape_string($_POST["lname"]);
            }

            //Address 1 validation
            if (strlen($_POST["ad1"]) <= 30)
            {
                $ad1Test = $conn->real_escape_string(trim($_POST["ad1"]));

                if (empty($ad1Test))
                {
                    $ad1Error = "Address 1 is required";
                    $ad1Class = "errorBox";
                    $ad1Old = $conn->real_escape_string($_POST["ad1"]);    
                }
                else
                {
                    $ad1 =  $conn->real_escape_string($_POST["ad1"]);
                    $ad1Old = $conn->real_escape_string($_POST["ad1"]); 
                }
            }
            else
            {   
                $ad1Error = "Address 1 is too long";
                $ad1Class = "errorBox";
                $ad1Old = $conn->real_escape_string($_POST["ad1"]);
            }

            //Address 2 validation
            if (strlen($_POST["ad2"]) <= 30)
            {
                $ad2Test = $conn->real_escape_string(trim($_POST["ad2"]));

                if (empty($ad2Test))
                {
                    $ad2Error = "Address 2 is required";
                    $ad2Class = "errorBox";
                    $ad2Old = $conn->real_escape_string($_POST["ad2"]);
                }
                else
                {
                    $ad2 = $conn->real_escape_string($_POST["ad2"]);
                    $ad2Old = $conn->real_escape_string($_POST["ad2"]); 
                }
            }
            else
            {   
                $ad2Error = "Address 2 is too long";
                $ad2Class = "errorBox";
                $ad2Old = $conn->real_escape_string($_POST["ad2"]);
            }

            //City validation
            if (strlen($_POST["city"]) <= 30)
            {
                $cityTest = $conn->real_escape_string(trim($_POST["city"]));

                if (empty($cityTest))
                {
                    $cityError = "City name is required";
                    $cityClass = "errorBox";
                    $cityOld = $conn->real_escape_string($_POST["city"]);
                }
                else
                {
                    $city = $conn->real_escape_string($_POST["city"]);
                    $cityOld = $conn->real_escape_string($_POST["city"]);
                }
            }
            else
            {   
                $cityError = "City name is too long";
                $cityClass = "errorBox";
                $cityOld = $conn->real_escape_string($_POST["city"]);
            }

            //Telephone validation
            if (is_numeric($_POST["tel"]))
            {
                if (strlen($_POST["tel"]) === 10)
                {
                    $tel =  $conn->real_escape_string($_POST["tel"]);
                    $telOld =  $conn->real_escape_string($_POST["tel"]);
                }
                else
                {
                    $telError = "Telephone should be exactly 10 digits";
                    $telClass = "errorBox";
                    $telMsg = "";
                    $telOld =  $conn->real_escape_string($_POST["tel"]);
                }
            }
            else
            {
                $telError = "Telephone should contain only numbers";
                $telClass = "errorBox";
                $telMsg = "";
                $telOld =  $conn->real_escape_string($_POST["tel"]);
            }

            //Mobile validation
            if (is_numeric($_POST["mob"]))
            {
                if (strlen($_POST["mob"]) === 10)
                {
                    $mob = $_POST["mob"];
                    $mobOld =  $conn->real_escape_string($_POST["mob"]);
                }
                else
                {
                    $mobError = "Mobile should be exactly 10 digits";
                    $mobClass = "errorBox";
                    $mobMsg = "";
                    $mobOld = $conn->real_escape_string($_POST["mob"]);
                }
            }
            else
            {
                $mobError = "Mobile should contain only numbers";
                $mobClass = "errorBox";
                $mobMsg = "";
                $mobOld = $conn->real_escape_string($_POST["mob"]);
            }

            //Combine all form data into registration queries
            if ($fname != "" && $lname != "" && $ad1 != "" && $ad2 != "" && $city != "" && $tel != "" && $mob != "")
            {

                $query2 = "CREATE USER '$username'@'localhost' IDENTIFIED BY '$password';";
                $query3 = "GRANT SELECT, INSERT, UPDATE ON librarydb.* TO '$username'@'localhost'";
                $query4 = "INSERT INTO `users` (Username, Password, FirstName, Surname, AddressLine1, AddressLine2, City, Telephone, Mobile) 
                VALUES ('$username', '$password', '$fname', '$lname', '$ad1', '$ad2', '$city', '$tel', '$mob');";

                $conn->query($query2);
                $conn->query($query3);
                $conn->query($query4);

                $_SESSION["username"] = $username;
                $_SESSION["password"] = $password;

                header("Location: ../HTML + PHP/registrationSuccess.php");
            }
        }
        $conn->close();
    ?>
    
    <div class="registerForm">
        <h1>Library Registration</h1>
        <h2>Please enter your personal details below</h2>
        <form method="post" id="personalRegister">
                <label for="fname" class="">First Name</label><br>
                <input class="<?php echo $fnameClass;?> fullName"  id="fname" type="text" name="fname" value="<?php echo htmlentities($fnameOld);?>" placeholder="John"><br>
                <span class="error"><?php echo $fnameError;?></span>
                <br><br>

                <label for="lname" class="">Last Name</label><br>
                <input class="<?php echo $lnameClass;?> fullName" id="lname" type="text" name="lname" value="<?php echo htmlentities($lnameOld);?>" placeholder="Smith"><br>
                <span class="error"><?php echo $lnameError;?></span>
                <br><br>

                <label for="ad1" class="">Address 1</label><br>
                <input class="<?php echo $ad1Class;?> fullAddress" id="ad1" type="text" name="ad1" value="<?php echo htmlentities($ad1Old);?>" placeholder="5 Waterloo Road"><br>
                <span class="error"><?php echo $ad1Error;?></span>
                <br><br>

                <label for="ad2" class="">Address 2</label><br>
                <input class="<?php echo $ad2Class;?> fullAddress" id="ad2" type="text" name="ad2" value="<?php echo htmlentities($ad2Old);?>" placeholder="Knocklyon"><br>
                <span class="error"><?php echo $ad2Error;?></span>
                <br><br>

                <label for="city">City</label><br>
                <input class="<?php echo $cityClass;?>" id="city" type="text" name="city" value="<?php echo htmlentities($cityOld);?>" placeholder="Dublin"><br>
                <span class="error"><?php echo $cityError;?></span>
                <br><br>

                <label for="tel">Telephone</label><br>
                <input class="<?php echo $telClass;?>" id="tel" type="tel" name="tel" value="<?php echo htmlentities($telOld);?>" placeholder="1234567890"><br>
                <?php
                    if ($telError == "")
                    {
                        echo '<span class="info">' . $telMsg . '</span>';
                        echo '<span class="error">' . $telError . '</span>';
                    }
                    else
                    {
                        echo '<span class="error">' . $telError . '</span>';
                    }
                ?>
                <br><br>

                <label for="mob">Mobile</label><br>
                <input class="<?php echo $mobClass;?>" id="mob" type="tel" name="mob" value="<?php echo htmlentities($mobOld);?>" placeholder="1234567890"><br>
                <?php
                    if ($mobError == "")
                    {
                        echo '<span class="info">' . $mobMsg . '</span>';
                        echo '<span class="error">' . $mobError . '</span>';
                    }
                    else
                    {
                        echo '<span class="error">' . $mobError . '</span>';
                    }
                ?>
                <br><br>
                <input class="formButton" type="submit" value="Register">
        </form>
    </div>
    <div class="separator"></div>
    <footer>
        <p class="footerNote">©2023, TheLibrary</p>
    </footer> 
</body>
</html>