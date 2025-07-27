<?php
    require_once ("db_utils.php");
    require_once ("classes\Korisnik.php");
    session_start();
    $message = "";
    $db = new Database();
    function validateData() {
        global $db, $message;
        if($_POST["name"] === "" || $_POST["surname"] === "" || $_POST["username"] === "" || $_POST["password"] === "" || $_POST["rePassword"] === "") {
            $message = "<div class=\"fail\">All fields need to be filled!</div>";
            return false;
        }

        if($_POST["password"] !== $_POST["rePassword"]) {
            $message = "<div class=\"fail\">Repeated password error - it's not equal to password!</div>";
            return false;
        }

        if($db->findUserByUsername($_POST["username"])) {
            $message = "<div class=\"fail\">Account with entered username already exists!</div>";
            return false;
        }

        return true;
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
</head>
<body>
    <div class="register">
        <p id="heading">Create account</p>
        <form method="post">
            <table>
                <tr>
                    <td>Name:</td>
                    <td>
                        <?php
                            $n = isset($_POST["name"]) ? "<input type=\"text\" name=\"name\" value=\"{$_POST["name"]}\" />" : "<input type=\"text\" name=\"name\" />";
                            echo $n;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Surname:</td>
                    <td>
                        <?php
                        $n = isset($_POST["surname"]) ? "<input type=\"text\" name=\"surname\" value=\"{$_POST["surname"]}\" />" : "<input type=\"text\" name=\"surname\" />";
                        echo $n;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td>
                        <?php
                        $n = isset($_POST["username"]) ? "<input type=\"text\" name=\"username\" value=\"{$_POST["username"]}\" />" : "<input type=\"text\" name=\"username\" />";
                        echo $n;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td>
                        <?php
                        $n = isset($_POST["password"]) ? "<input type=\"password\" name=\"password\" value=\"{$_POST["password"]}\" />" : "<input type=\"password\" name=\"password\" />";
                        echo $n;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Repeat password:</td>
                    <td>
                        <?php
                        $n = isset($_POST["rePassword"]) ? "<input type=\"password\" name=\"rePassword\" value=\"{$_POST["rePassword"]}\" />" : "<input type=\"password\" name=\"rePassword\" />";
                        echo $n;
                        ?>
                    </td>
                </tr>
            </table>
            <br>
            <input type="submit" name="register" value="Register" />
        </form>
    </div>
    <?php
        if(isset($_POST["register"])) {
            if(!validateData()) {
                echo $message;
            } else {
                $name = htmlspecialchars($_POST["name"]);
                $surname = htmlspecialchars($_POST["surname"]);
                $username = htmlspecialchars($_POST["username"]);
                $password = htmlspecialchars($_POST["password"]);
                $korisnik = new Korisnik($name, $surname, $username, $password, 1);
                if($db->insertKorisnik($korisnik)) {
                    $_SESSION["logged-in"] = true;
                    header("Location: albumGrid.php?username={$username}");
                } else {
                    $message = "<div class=\"fail\">Registration failed!</div>";
                    echo $message;
                }
            }
        }
    ?>
</body>
</html>