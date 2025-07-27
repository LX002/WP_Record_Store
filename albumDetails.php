<?php
    require_once ("db_utils.php");
    require_once ("classes/Album.php");
    require_once ("classes/Korisnik.php");

    session_start();
    $database = new Database();
    $album = $database->findAlbumById(htmlspecialchars($_GET["idAlbum"]));
    if(isset($_SESSION["items"])) {
        echo "postavljen session items";
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
    <title>Album details for: <?php echo $album->getNaziv(); ?></title>
</head>
<body>
    <?php
    echo "<div class=\"album-details\">";
    echo "<img src=\"{$album->getAlbumArtPath()}\" style=\"witdh:500px; height:500px\" alt=\"{$album->getNaziv()}\"> <br>";
    echo $album->getNaziv() . " by ";
    echo $album->getIzvodjac() . "<br>";
    echo "Year of release: " . $album->getGodinaIzdanja() . "<br>";
    echo "Genre: " . $album->getZanr() . "<br>";
    echo "Number of units in stock: " . $album->getBrKomNaStanju() . "<br>";
    echo "Price: " . $album->getCena() . " RSD<br>";
    echo "</div>";
    echo "<iframe style=\"border-radius:12px\" src=\"{$album->getAlbumSpotifyPath()}\" width=\"532\" height=\"352\" frameBorder=\"0\" allowfullscreen=\"\" allow=\"autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture\" loading=\"lazy\"></iframe>";
    ?>
</body>
</html>