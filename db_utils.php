<?php
    require_once("constants.php");

    class Database {
        private $connection;

        public function __construct($configFile = "config.ini") {
            if($config = parse_ini_file($configFile)) {
                $host = $config["host"];
                $database = $config["database"];
                $username = $config["username"];
                $password = $config["password"];
                $this->connection = new PDO("mysql:host=$host;dbname=$database;", $username, $password);
            } else {
                exit("Ne postoji konfiguracioni fajl!");
            }
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        public function __destruct() {
            // TODO: Implement __destruct() method.
            $this->connection = null;
        }

        public function getAllAlbums()
        {
            $albumi = array();
            $query = "select * from ".TBL_ALBUM;
            try {
                $q_res = $this->connection->query($query);
                foreach($q_res as $q) {
                    $album = new Album($q[COL_ID_ALBUM], $q[COL_NAZIV_ALBUM], $q[COL_IZVODJAC_ALBUM], $q[COL_GODINA_ALBUM], $q[COL_ZANR_ALBUM],$q[COL_CENA_ALBUM], $q[COL_NA_STANJU_ALBUM], $q[COL_ART_ALBUM], $q[COL_SPOTIFY_ALBUM]);
                    $albumi[] = $album;
                }
            } catch (PDOException $e) {
                echo "Greska pri ucitavanju albuma iz baze!";
            }

            return $albumi;
        }

        public function findAlbumById($id)
        {
            $album = null;
            $query = "select * from " . TBL_ALBUM . " where idAlbum = :id";
            try {
                $st = $this->connection->prepare($query);
                $st->bindValue(":id", $id);
                $st->execute();
                $q = $st->fetch(PDO::FETCH_ASSOC);
                if($q !== false) {
                    $album = new Album($q[COL_ID_ALBUM], $q[COL_NAZIV_ALBUM], $q[COL_IZVODJAC_ALBUM], $q[COL_GODINA_ALBUM], $q[COL_ZANR_ALBUM],$q[COL_CENA_ALBUM], $q[COL_NA_STANJU_ALBUM], $q[COL_ART_ALBUM], $q[COL_SPOTIFY_ALBUM]);
                }
                //da li treba?
                //$q->free();
            } catch (PDOException $e) {
                echo "Exception u funkciji findUserByUsername";
            }
            return $album;
        }

        public function findUserByUsername($username)
        {
            $korisnik = null;
            $query = "select * from " . TBL_KORISNIK . " where username = :u";
            try {
                $st = $this->connection->prepare($query);
                $st->bindValue(":u", $username);
                $st->execute();
                $res = $st->fetch(PDO::FETCH_ASSOC);
                if($res !== false) {
                    $korisnik = new Korisnik($res[COL_IME_KORISNIK], $res[COL_PREZIME_KORISNIK], $res[COL_USERNAME_KORISNIK], $res[COL_PASSWORD_KORISNIK], $res[COL_ID_KORISNIK], $res[COL_ID_KORISNIK]);
                }
            } catch (PDOException $e) {
                echo "Exception u funkciji findUserByUsername";
            }
            return $korisnik;
        }

        //sto posto ce ovde biti neke greske, ako nesto ne valja uredi sa bind value za statement...
        public function insertNarudzbina($narudzbina) {
            $success = true;
            $query = "insert into narudzbina (idNarudzbina, brKartice, imeNaKartici, rokVazenjaKartice, cvv, iznos, adresa, kupac_fk)" .
                     " values ({$narudzbina->getID()}, '{$narudzbina->getBrKartice()}', '{$narudzbina->getImeNaKartici()}', '{$narudzbina->getRokVazenjaKartice()}', '{$narudzbina->getCvv()}', {$narudzbina->getIznos()}, '{$narudzbina->getAdresa()}', '{$narudzbina->getIdKorisnik()}')";
            try {
                $st = $this->connection->prepare($query);
                $st->execute();
                foreach($narudzbina->getListaStavki() as $stavka) {
                    if(!$this->insertStavka($stavka)) {
                        $success = false;
                        break;
                    }
                }
            } catch(PDOException $e) {
                $success = false;
                echo "Exception u funkciji insertNarudzbina <br>" . $e->getMessage();
            }
            return $success;
        }

        public function insertStavka($stavka) {
            $success = false;
            $query = "insert into stavkanarudzbina (idStavkaNarudzbina, kolicina, narudzbina_fk, album_fk)" .
                " values ({$stavka->getID()}, {$stavka->getKolicina()}, {$stavka->getIdNarudzbina()}, {$stavka->getIdAlbum()})";
            try {
                $st = $this->connection->prepare($query);
                $st->execute();
                //dodaj updatovanje kolicine albuma na lageru, oduzimanje kolicine od trenutne vrednosti...

                $success = true;
            } catch(PDOException $e) {

                echo "Exception u funkciji insertStavka <br>" . $e->getMessage();
            }
            return $success;
        }

        public function countNarudzbina() {
            $count = 0;
            $query = "select count(*) as br_narudzbina from " . TBL_NARUDZBINA;
            try {
                $q_res = $this->connection->query($query);
                if($q_res) {
                    $row = $q_res->fetch(PDO::FETCH_ASSOC);
                    $count = $row["br_narudzbina"];
                }
            } catch(PDOException $e) {
                echo "Exception u funkciji countNarudzbina <br>" . $e->getMessage();
            }
            return $count;
        }

        public function countStavka() {
            $count = 0;
            $query = "select count(*) as br_stavka from " . TBL_STAVKANARUDZBINA;
            try {
                $q_res = $this->connection->query($query);
                if($q_res) {
                    $row = $q_res->fetch(PDO::FETCH_ASSOC);
                    $count = $row["br_stavka"];
                }
            } catch(PDOException $e) {
                echo "Exception u funkciji countNarudzbina <br>" . $e->getMessage();
            }
            return $count;
        }

        public function insertKorisnik($korisnik) {
            $success = false;
            $query = "insert into " . TBL_KORISNIK . " (ime, prezime, username, password, role_fk)" .
                " values ('{$korisnik->getIme()}', '{$korisnik->getPrezime()}', '{$korisnik->getUsername()}', '{$korisnik->getPassword()}', {$korisnik->getRole()})";
            //echo $query;
            try {
                $st = $this->connection->prepare($query);
                $st->execute();
                $success = true;
            } catch(PDOException $e) {

                echo "Exception u funkciji insertKorisnik <br>" . $e->getMessage();
            }
            return $success;
        }

        public function findAlbums($query) {
            $albumi = array();
            try {
                $q_res = $this->connection->query($query);
                foreach($q_res as $q) {
                    $album = new Album($q[COL_ID_ALBUM], $q[COL_NAZIV_ALBUM], $q[COL_IZVODJAC_ALBUM], $q[COL_GODINA_ALBUM], $q[COL_ZANR_ALBUM],$q[COL_CENA_ALBUM], $q[COL_NA_STANJU_ALBUM], $q[COL_ART_ALBUM], $q[COL_SPOTIFY_ALBUM]);
                    $albumi[] = $album;
                }
            } catch (PDOException $e) {
                echo "Greska pri pretrazi albuma iz baze! <br>" . $e->getMessage();
            }
            return $albumi;
        }

        public function updateQuantity($idAlbum, $quantity) {
            $success = false;
            $query = "update album set brKomNaStanju = :q where idAlbum = :id";
            try {
                $st = $this->connection->prepare($query);
                $st->bindValue("q", $quantity);
                $st->bindValue("id", $idAlbum);
                $st->execute();
                $success = true;
            } catch (PDOException $e) {
                echo "Error during updating the albums! <br>" . $e->getMessage();
            }
            return $success;
        }

        public function insertBeat($beat) {
            $query = "insert into beat (beatPath, korisnik_fk) " .
                     "values('{$beat->getBeatPath()}', {$beat->getIdKorisnik()})";
            $success = false;
            try {
                $st = $this->connection->prepare($query);
                $st->execute();
                $success = true;
            } catch (PDOException $e){
                echo "Error during insertion of a beat in database! <br>" . $e->getMessage();
            }

            return $success;
        }


    }
?>