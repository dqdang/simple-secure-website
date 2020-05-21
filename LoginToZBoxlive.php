<?php
    ob_start();
    session_start();

    $msg = "";
    $username = "";
    $password = "";
    $hash = "";
    $crypted = "";

    if (isset($_POST["login"]) && !empty($_POST["username"])
        && !empty($_POST["password"]))
    {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $hash = hash("sha256", $password);
        $open = fopen("privateKey" . $username, "r") or die("Unable to open file!");
        if ($open == FALSE)
        {
            header("Location: /LoginToZBoxlive.php");
        }
        $privateKey = fread($open, 8192);
        fclose($open);

        $res = openssl_get_privatekey($privateKey);
        openssl_private_encrypt($hash, $crypted, $res);
        $_SESSION['luser'] = $username;
        $_SESSION['start'] = time();
        $_SESSION['expire'] = $_SESSION['start'] + (30 * 60); // 30 min
        $_SESSION["password"] = $crypted;
        $msg = "Logged in at " .$_SESSION['start'];
    }
?>

<html>
    <head>
        <title>Login</title>
    </head>

    <body>
        <div class = "container form-signin">
        <h2>Login to ZBoxlive.com</h2>

        </div>

        <div class = "container">

            <form class = "form-signin" role = "form" method = "post">
            <h4 class = "form-signin-heading"><?php echo $msg; ?></h4>
                <input type = "text" class = "form-control"
                name = "username"><br/>
                <input type = "password" class = "form-control"
                name = "password"><br/>
                <button class = "btn btn-lg btn-primary btn-block" type = "submit"
                name = "login">Login</button>
            </form>
            <p>Go to <a href = "ZBoxlive.php">ZBoxlive.php</a>.</p>

        </div>

    </body>
</html>
