<?php
    require_once ("db_utils.php");
    require_once ("classes/Album.php");
    session_start();
    $database = new Database();

    if(isset($_POST["logout"]) || !$_SESSION["logged-in"]) {
        if(isset($_COOKIE["user"])) {
            setcookie("user", "", time() - 3600);
        }
        setcookie("PHPSESSID", "", time()-1000, "/");
        session_destroy();
        header("Location: index.php");
    }

    if(isset($_POST["remember"])) {
        $username = htmlspecialchars($_GET["username"]);
        setcookie("user", $username, time() + 60 * 60 * 24 * 365);
        header("Location: albumGrid.php?username=" . $username);
    }

    if(isset($_POST["clearCart"]) || isset($_GET["clear"])) {
        $_SESSION["items"] = array();

        $username="";
        if(!isset($_COOKIE["user"])) {
            $username =  $_GET["username"];
        } else {
            $username =  $_COOKIE["user"];
        }
        header("Location: albumGrid.php?username=" . $username);
    }

    if(isset($_SESSION["items"])) {
        $cart = $_SESSION["items"];
        //print_r($cart);
    } else {
        $cart = array();
    }

    if(isset($_POST["add"])) {
        if(!isset($_SESSION["items"])) {
            $_SESSION["items"] = array();
        }
        $username = $_GET["username"];
        $_SESSION["items"][] = $database->findAlbumById($_POST["idAlbum"]);
        header("Location: albumGrid.php?username=" . $_GET["username"]);
        //print_r($_SESSION["items"]);
    }

    if(isset($_POST["order"])) {
        $username = "";
        if(!isset($_COOKIE["user"])) {
            $username =  $_GET["username"];
        } else {
            $username =  $_COOKIE["user"];
        }

        if(count($cart) == 0) {
            header("Location: albumGrid.php?username=" . $username);
        } else {
            header("Location: saveOrder.php?username={$username}");
            exit();
        }
    }

    $albumName = isset($_GET["albumName"]) ? (htmlspecialchars($_GET["albumName"])) : "";
    $artist = isset($_GET["artist"]) ? (htmlspecialchars($_GET["artist"])) : "";
    $genre = isset($_GET["genre"]) ? (htmlspecialchars($_GET["genre"])) : "";
    $year = isset($_GET["year"]) ? (htmlspecialchars($_GET["year"])) : "";
    $query = "select * from album where 1 and brKomNastanju != 0 ";
    if(!empty($albumName)) {
        $query .= " and naziv like '{$albumName}%'";
    }
    if(!empty($artist)) {
        $query .= " and izvodjac like '{$artist}%'";
    }
    if(!empty($genre)) {
        $query .= " and zanr = '{$genre}'";
    }
    if(!empty($year)) {
        $query .= " and godIzdanja = {$year}";
    }

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Record store</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <?php
        if(!isset($_COOKIE["user"])) {
            $u = $_GET["username"];
        } else {
            $u = $_COOKIE["user"];
        }
        echo "<a id=\"beat-link\" href=\"beat_upload.php?username=$u\" style=\"float: right;\">Upload a beat</a>";
        echo "<p id=\"logged-info\"><b>Logged in as: " . $u . "</b></p>";
        echo "<form style=\"float: left;\" method=\"post\">";
        echo "<input type=\"submit\" value=\"Logout\" name=\"logout\" /> &nbsp;&nbsp;";
        echo "</form>";
        echo "<form method=\"post\">";
        echo "<input type=\"submit\" value=\"Remember me\" name=\"remember\" />";
        echo "</form> <br><br>";

        //prikaz sadrzaja korpe
        echo "<div id=\"cart\">";
        if(count($cart) > 0) {
            echo "Items in cart:<br>";
            foreach($cart as $item) {
                echo "<p>" . $item->toString() . "</p>";
            }
        } else {
            echo "<p><strong>Items in cart: none</strong></p>";
        }

        $albums = $database -> findAlbums($query);

        echo "<form style=\"float: left;\" method=\"post\">";
        echo "<input type=\"submit\" value=\"Clear cart\" name=\"clearCart\" /> &nbsp;&nbsp;";
        echo "</form>";
        echo "<form method=\"post\">";
        echo "<input type=\"submit\" value=\"Order\" name=\"order\" />";
        echo "</form>";
        echo "</div> <br>";

        echo "<p id=\"heading\">Explore albums</p>";
        //forma za pretrazivanje albuma
        echo "<div class=\"searchBar\">";
        echo "<form method=\"get\">";
        echo "<input type=\"hidden\" name=\"username\" value=\"{$_GET["username"]}\"/>";
        echo "Album: <input type=\"text\" name=\"albumName\" /> &nbsp;&nbsp;&nbsp;";
        echo "Artist: <input type=\"text\" name=\"artist\" /> &nbsp;&nbsp;&nbsp;";
        echo "Genre: <select name=\"genre\">";
        $genres = array();
        $allAlbumsCount = 0;
        foreach($database->getAllAlbums() as $a) {
            if(!isset($genres[$a->getZanr()])) {
                $genres[$a->getZanr()] = 1;
            } else {
                $genres[$a->getZanr()] += 1;
            }
            $allAlbumsCount += 1;
        }
        echo "<option value=\"\">All genres ($allAlbumsCount)</option>";
        foreach($genres as $key => $value) {
            echo "<option value=\"{$key}\">$key ($value)</option>";
        }
        echo "</select> &nbsp;&nbsp;&nbsp;";
        echo "Year: <input type=\"number\" name=\"year\" /> &nbsp;&nbsp;&nbsp;";
        echo "<input type=\"submit\" value=\"Search\" />";
        echo "</form>";
        echo "</div> <br>";



        foreach($albums as $album) {
            echo "<div class=\"album\">";
            echo "<img src=\"{$album->getAlbumArtPath()}\" style=\"witdh:500px; height:500px;\" alt=\"{$album->getNaziv()}\"> <br>";
            echo $album->getNaziv() . " by " . $album->getIzvodjac() . "<br>";
            echo "Price: " . $album->getCena() . " RSD<br>";
            echo "<a href=\"albumDetails.php?idAlbum={$album->getId()}\"><button>Show album details</button></a><br>";
            echo "<form method=\"post\">";
            echo "<input type=\"hidden\" name=\"idAlbum\" value=\"{$album->getId()}\"/>";
            echo "<input type=\"submit\" value=\"Add to cart\" name=\"add\"/>";
            echo "</form>";
            echo "</div>";
        }
    ?>
</body>
</html>