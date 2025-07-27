<?php
    class Album {
        private $id;
        private $naziv;
        private $izvodjac;
        private $godinaIzdanja;
        private $zanr;
        private $cena;
        private $brKomNaStanju;
        private $albumArtPath;
        private $albumSpotifyPath;

        /**
         * @param $id
         * @param $naziv
         * @param $izvodjac
         * @param $godinaIzdanja
         * @param $zanr
         * @param $cena
         * @param $brKomNaStanju
         * @param $albumArtPath
         * @param $albumSpotifyPath
         */
        public function __construct($id, $naziv, $izvodjac, $godinaIzdanja, $zanr, $cena, $brKomNaStanju, $albumArtPath, $albumSpotifyPath)
        {
            $this->id = $id;
            $this->naziv = $naziv;
            $this->izvodjac = $izvodjac;
            $this->godinaIzdanja = $godinaIzdanja;
            $this->zanr = $zanr;
            $this->cena = $cena;
            $this->brKomNaStanju = $brKomNaStanju;
            $this->albumArtPath = $albumArtPath;
            $this->albumSpotifyPath = $albumSpotifyPath;
        }

        /**
         * @return mixed
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * @param mixed $id
         */
        public function setId($id)
        {
            $this->id = $id;
        }

        /**
         * @return mixed
         */
        public function getNaziv()
        {
            return $this->naziv;
        }

        /**
         * @param mixed $naziv
         */
        public function setNaziv($naziv)
        {
            $this->naziv = $naziv;
        }

        /**
         * @return mixed
         */
        public function getIzvodjac()
        {
            return $this->izvodjac;
        }

        /**
         * @param mixed $izvodjac
         */
        public function setIzvodjac($izvodjac)
        {
            $this->izvodjac = $izvodjac;
        }

        /**
         * @return mixed
         */
        public function getGodinaIzdanja()
        {
            return $this->godinaIzdanja;
        }

        /**
         * @param mixed $godinaIzdanja
         */
        public function setGodinaIzdanja($godinaIzdanja)
        {
            $this->godinaIzdanja = $godinaIzdanja;
        }

        /**
         * @return mixed
         */
        public function getZanr()
        {
            return $this->zanr;
        }

        /**
         * @param mixed $zanr
         */
        public function setZanr($zanr)
        {
            $this->zanr = $zanr;
        }

        /**
         * @return mixed
         */
        public function getCena()
        {
            return $this->cena;
        }

        /**
         * @param mixed $cena
         */
        public function setCena($cena)
        {
            $this->cena = $cena;
        }

        /**
         * @return mixed
         */
        public function getBrKomNaStanju()
        {
            return $this->brKomNaStanju;
        }

        /**
         * @param mixed $brKomNaStanju
         */
        public function setBrKomNaStanju($brKomNaStanju)
        {
            $this->brKomNaStanju = $brKomNaStanju;
        }

        /**
         * @return mixed
         */
        public function getAlbumArtPath()
        {
            return $this->albumArtPath;
        }

        /**
         * @param mixed $albumArtPath
         */
        public function setAlbumArtPath($albumArtPath)
        {
            $this->albumArtPath = $albumArtPath;
        }

        /**
         * @return mixed
         */
        public function getAlbumSpotifyPath()
        {
            return $this->albumSpotifyPath;
        }

        /**
         * @param mixed $albumSpotifyPath
         */
        public function setAlbumSpotifyPath($albumSpotifyPath)
        {
            $this->albumSpotifyPath = $albumSpotifyPath;
        }

        public function toString() {
            return "{$this->izvodjac} - {$this->naziv}, {$this->cena} RSD";
        }

    }