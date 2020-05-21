<?php
    ob_start();
    session_start();
    if (isset($_COOKIE["username"]))
    {
            unset($_COOKIE["username"]);
            setcookie("username", "", time() - 86313600, "/", "");
    }

    if (isset($_COOKIE["password"]))
    {
            unset($_COOKIE["password"]);
            setcookie("password", "", time() - 86313600, "/", "");
    }

    unset($_SESSION['start']);
    unset($_SESSION['expire']);
    session_destroy();
    echo "You have cleaned the session.";
?>

<html>

    <body>

        <br />
        <p><a href = "/">Back</a></p>

    </body>

</html>
