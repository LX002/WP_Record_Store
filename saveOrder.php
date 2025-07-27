<?php
    require_once ("db_utils.php");
    require_once ("classes/Album.php");
    require_once ("classes/Narudzbina.php");
    require_once ("classes/StavkaNarudzbina.php");
    require_once ("classes/Korisnik.php");
    session_start();

//    $cart = array();
//    if(isset($_SESSION["items"])) {
//        $cart = $_SESSION["items"];
//    }
    $database = new Database();
    $cart = $_SESSION["items"];
    $username = htmlspecialchars($_GET["username"]);
    $korisnik = $database->findUserByUsername($username);
    $idNarudzbina = $database->countNarudzbina() + 1;
    $idStavka = $database->countStavka() + 1;
//    if(isset($_GET["back"])) {
//        $_SESSION["items"] = array();
//        header("Location: albumGrid.php?username={$username}");
//    }

    function validateData() {
        if($_POST["brKartice"] === "" || $_POST["imeNaKartici"] === "" || $_POST["rokVazenjaKartice"] === "" || $_POST["cvv"] === "" || $_POST["adresa"] === "") {
            return false;
        }
        return true;
    }

    function countOccurencesOf($item) {
        global $cart;
        $count = 0;
        foreach($cart as $c) {
            if($c->getId() == $item->getId()) {
                $count = $count + 1;
            }
        }
        return $count;
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Saving order for: <?php echo $username ?> </title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <?php
        echo "<div class=\"cart-items\">";
        echo "Items in cart:<br>";
        $iznos = 0;
//        foreach($cart as $item) {
//            $iznos = $iznos + $item->getCena();
//            echo "<p>" . $item->toString() . "</p>";
//        }
        $quantityMap = array();
        //prebrojavanje svakog albuma i stavljanje u mapu (asocijativni niz)
        //kljuc -> id albuma, vrednost -> broj ponavljanja albuma u korpi
        foreach($cart as $item) {
            if(!isset($quantityMap[$item->getId()])) {
                $quantityMap[$item->getId()] = 1;
            } else {
                $quantityMap[$item->getId()] = $quantityMap[$item->getId()] + 1;
            }
        }

        foreach($quantityMap as $key => $value) {
            $a = $database->findAlbumById($key);
            $iznos = $iznos + $a->getCena() * $value;
            echo "<p>" . $a->toString() . "  {$value}x</p>";
        }
        echo "Order price: {$iznos} RSD";
        echo "</div>";
        echo "<div class=\"order-info\">";
    ?>

    <form method="post">
        <table>
            <tr>
                <td>Card number:</td>
                <td>
                    <?php
                    $n = isset($_POST["brKartice"]) ? "<input type=\"text\" name=\"brKartice\" value=\"{$_POST["brKartice"]}\" />" : "<input type=\"text\" name=\"brKartice\" />";
                    echo $n;
                    ?>
                </td>
            </tr>
            <tr>
                <td>Card owner:</td>
                <td>
                    <?php
                    $n = isset($_POST["imeNaKartici"]) ? "<input type=\"text\" name=\"imeNaKartici\" value=\"{$_POST["imeNaKartici"]}\" />" : "<input type=\"text\" name=\"imeNaKartici\" />";
                    echo $n;
                    ?>
                </td>
            </tr>
            <tr>
                <td>Card expiration date:</td>
                <td>
                    <?php
                    $n = isset($_POST["rokVazenjaKartice"]) ? "<input type=\"text\" name=\"rokVazenjaKartice\" value=\"{$_POST["rokVazenjaKartice"]}\" />" : "<input type=\"text\" name=\"rokVazenjaKartice\" />";
                    echo $n;
                    ?>
                </td>
            </tr>
            <tr>
                <td>CVV:</td>
                <td>
                    <?php
                    $n = isset($_POST["cvv"]) ? "<input type=\"text\" name=\"cvv\" value=\"{$_POST["cvv"]}\" />" : "<input type=\"text\" name=\"cvv\" />";
                    echo $n;
                    ?>
                </td>
            </tr>
            <tr>
                <td>Delivery address:</td>
                <td>
                    <?php
                    $n = isset($_POST["adresa"]) ? "<input type=\"text\" name=\"adresa\" value=\"{$_POST["adresa"]}\" />" : "<input type=\"text\" name=\"adresa\" />";
                    echo $n;
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                </td>
                <td>
                    <input type="submit" name="save" value="Save" />
                </td>
            </tr>
        </table>
    </form>

    <?php
    echo "</div>";
        //dodati proveru kolicine svakog albuma u korpi, ako jedan ima vise komada nego sto ga ima na lageru, prekinuti narudzbinu...
        if(isset($_POST["save"])) {
            if(!validateData()) {
                echo "<div class=\"fail\">All fields need to be filled!</div>";
            } else {
                $narudzbina = new Narudzbina($idNarudzbina, htmlspecialchars($_POST["brKartice"]), htmlspecialchars($_POST["imeNaKartici"]),
                                             htmlspecialchars($_POST["rokVazenjaKartice"]), htmlspecialchars($_POST["cvv"]), $iznos,
                                             htmlspecialchars($_POST["adresa"]), $korisnik->getIdKorisnik());
                $success1 = true;
                $a = null;
                $q = null;
                foreach($quantityMap as $key => $value) {
                    $a = $database->findAlbumById($key);
                    if($a->getBrKomNaStanju() - $value < 0) {
                        $success1 = false;
                        $q = $value;
                        break;
                    }
                }

                if($success1) {
                    foreach($quantityMap as $key => $value) {
                        $a = $database->findAlbumById($key);
                        $narudzbina->dodajStavku(new StavkaNarudzbina($idStavka, $value, $narudzbina->getId(), $key));
                        $idStavka = $idStavka + 1;
                    }

                    if($database->insertNarudzbina($narudzbina)) {
                        $success2 = true;
//                        foreach($narudzbina->getListaStavki() as $stavka) {
//                            print_r($stavka);
//                        }
                        foreach($narudzbina->getListaStavki() as $stavka) {
                            $quantity = $database->findAlbumById($stavka->getIdAlbum())->getBrKomNaStanju() - $stavka->getKolicina();
                            //echo $quantity;
                            if(!$database->updateQuantity($stavka->getIdAlbum(), $quantity)) {
                                $success = false;
                                break;
                            }
                        }
                        if($success2) {
                            echo "<div class=\"success\">Order and it's items are successfully saved!<br>";
                            echo "<a href=\"albumGrid.php?username={$username}&clear\">Go back to the albums {$username}</a></div>";
                        } else {
                            echo "<div class=\"warning\">Order and it's items are successfully saved! (but, there was a problem with updating stock state...)<br>";
                            echo "<a href=\"albumGrid.php?username={$username}&clear\">Go back to the albums {$username}</a></div>";
                        }
                    } else {
                        echo "<div class=\"fail\">Order and its items are not saved! :(</div>";
                    }
                } else {
                    echo "<div class=\"fail\">Order is not saved!<br>You've added {$a->getIzvodjac()} - {$a->getNaziv()} {$q}x but there is only {$a->getBrKomNaStanju()} of them available! <br>";
                    echo "<a href=\"albumGrid.php?username={$username}&clear\">Go back to the albums {$username}</a></div>";
                }
//                if ($database->insertNarudzbina($narudzbina)) {
//                    //mapa kolicina za svaki album u korpi
//                    $quantityMap = array();
//                    //$kolicina = countOccurencesOf($item);
//                    //$narudzbina->dodajStavku(new StavkaNarudzbina($idStavka, $kolicina, $korisnik->getIdKorisnik(), $item->getId()));
//                    //inicijalizovanje brojaca
//                    foreach ($cart as $item) {
//                        $quantityMap[$item->getId()] = 0;
//                    }
//                    //prolazak kroz korpu i brojanje svakog ponavljanja za album
//                    foreach ($cart as $item) {
//                        $quantityMap[$item->getId()] = $quantityMap[$item->getId()] + 1;
//                    }
//                    //konacno dodavanje stavki u narudzbinu
//                    foreach ($quantityMap as $key => $value) {
//                        //dodati proveru da li stvarno postoji tolika kolicina odredjenog albuma na lageru, ako ne prekinuti unos stavki, ali i obrisati narudzbinu???
//                        $narudzbina->dodajStavku(new StavkaNarudzbina($idStavka, $value, $narudzbina->getId(), $key));
//                        $idStavka = $idStavka + 1;
//                    }
//                    //i dodavanje svake stavke u bazu
//                    $success = true;
//                    foreach ($narudzbina->getListaStavki() as $stavka) {
//                        if (!($database->insertStavka($stavka))) {
//                            $success = false;
//                            break;
//                        }
//                    }
//                    if ($success) {
//                        echo "Order and it's items are successfully saved!<br><br>";
//                        echo "<a href=\"albumGrid.php?username={$username}&clear\">Go back to the albums {$username}</a>";
//                    } else {
//                        echo "Order items are not successfully saved :(";
//                    }
//                } else {
//                    echo "An error occured! Order is not saved :(";
//                }
            }
        }

    ?>
</body>
</html>
