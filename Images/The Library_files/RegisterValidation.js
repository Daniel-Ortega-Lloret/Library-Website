function registerValidation()
{
    // var password = document.getElementsByName("password");
    // var rePassword = document.getElementsByName("rePassword");
    var fname = document.getElementsByName('fname')[0].value;
    // var lname = document.getElementsByName("lname");
    // var ad1 = document.getElementsByName("ad1");
    // var ad2 = document.getElementsByName("ad2");
    // var city = document.getElementsByName("city");
    // var tel = document.getElementsByName("tel");
    // var mob = document.getElementsByName("mob");

    // var passwordError = document.getElementById("passwordError");
    // var rePasswordError = document.getElementById("rePasswordError");
    var fnameError = document.getElementById('fnameError');
    // var lnameError = document.getElementById("lnameError");
    // var ad1Error = document.getElementById("ad1Error");
    // var ad2Error = document.getElementById("ad2Error");
    // var cityError = document.getElementById("cityError");
    // var telError = document.getElementById("telError");
    // var mobError = document.getElementById("mobError");

    if (fname === "")
    {
        fnameError.innerHTML = "Please enter your first name.";
        return false;
    }
    else if (fname.length() > 30)
    {
        fnameError.innerHTML = "* First name is too long.";
        return false;
    }
    else
    {
        fnameError.innerHTML = "";
    }
    return true;

}