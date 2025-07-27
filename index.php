<?php
    require_once ("classes/Korisnik.php");
    require_once ("db_utils.php");
    session_start();
    $message = "";
    $success = false;
    $database = new Database();
    $_SESSION["logged-in"] = false;
    function getSuccess()
    {
        global $success;
        return $success;
    }
    if(isset($_COOKIE["user"])) {
        $_SESSION["logged-in"] = true;
        header("Location: albumGrid.php?username=" . htmlspecialchars($_COOKIE["user"]));
        exit();
    }

    if(isset($_POST["login"])) {
        $username = htmlspecialchars($_POST["username"]);
        $password = htmlspecialchars($_POST["password"]);
        $korisnik = $database->findUserByUsername($username);
        if($korisnik != null) {
            if($korisnik->getPassword() !== $password) {
                $message = "<div class=\"fail\">Wrong password!</div>";
            } else {
                $success = true;
            }
        } else {
            $message = "<div class=\"fail\">Account with entered username doesn't exist!</div>";
        }
    }

    if(isset($_GET["register"])) {
        header("Location: register.php");
        exit();
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Record store - login</title>
</head>
<body>
    <div class="login">
        <form method="post" action="" id="login-form">
            <p id="heading">Welcome to record store!</p>
            <table>
                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" /></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password" /></td>
                </tr>
            </table>
            <br>
            <input type="submit" name="login" value="Login" />
        </form>
        <br>
        <a href="?register">Register</a> if you don't have an account
    </div>
    <?php
        //<input type="submit" name="remember" value="Remember me">
        if($success) {
            $_SESSION["logged-in"] = true;
            header("Location: albumGrid.php?username=" . htmlspecialchars($_POST["username"]));
        } else {
            echo $message;
        }
    ?>
</body>
</html>
