<?php
    class Narudzbina {
        private $id;
        private $brKartice;
        private $imeNaKartici;
        private $rokVazenjaKartice;
        private $cvv;
        private $iznos;
        private $adresa;
        private $idKorisnik;
        private $listaStavki;

        /**
         * @param $id
         * @param $brKartice
         * @param $imeNaKartici
         * @param $rokVazenjaKartice
         * @param $cvv
         * @param $iznos
         * @param $adresa
         * @param $idKorisnik
         */
        public function __construct($id, $brKartice, $imeNaKartici, $rokVazenjaKartice, $cvv, $iznos, $adresa, $idKorisnik)
        {
            $this->id = $id;
            $this->brKartice = $brKartice;
            $this->imeNaKartici = $imeNaKartici;
            $this->rokVazenjaKartice = $rokVazenjaKartice;
            $this->cvv = $cvv;
            $this->iznos = $iznos;
            $this->adresa = $adresa;
            $this->idKorisnik = $idKorisnik;
            $this->listaStavki = array();
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
        public function getBrKartice()
        {
            return $this->brKartice;
        }

        /**
         * @param mixed $brKartice
         */
        public function setBrKartice($brKartice)
        {
            $this->brKartice = $brKartice;
        }

        /**
         * @return mixed
         */
        public function getImeNaKartici()
        {
            return $this->imeNaKartici;
        }

        /**
         * @param mixed $imeNaKartici
         */
        public function setImeNaKartici($imeNaKartici)
        {
            $this->imeNaKartici = $imeNaKartici;
        }

        /**
         * @return mixed
         */
        public function getRokVazenjaKartice()
        {
            return $this->rokVazenjaKartice;
        }

        /**
         * @param mixed $rokVazenjaKartice
         */
        public function setRokVazenjaKartice($rokVazenjaKartice)
        {
            $this->rokVazenjaKartice = $rokVazenjaKartice;
        }

        /**
         * @return mixed
         */
        public function getCvv()
        {
            return $this->cvv;
        }

        /**
         * @param mixed $cvv
         */
        public function setCvv($cvv)
        {
            $this->cvv = $cvv;
        }

        /**
         * @return mixed
         */
        public function getIznos()
        {
            return $this->iznos;
        }

        /**
         * @param mixed $iznos
         */
        public function setIznos($iznos)
        {
            $this->iznos = $iznos;
        }

        /**
         * @return mixed
         */
        public function getAdresa()
        {
            return $this->adresa;
        }

        /**
         * @param mixed $adresa
         */
        public function setAdresa($adresa)
        {
            $this->adresa = $adresa;
        }

        /**
         * @return mixed
         */
        public function getIdKorisnik()
        {
            return $this->idKorisnik;
        }

        /**
         * @param mixed $idKorisnik
         */
        public function setIdKorisnik($idKorisnik)
        {
            $this->idKorisnik = $idKorisnik;
        }

        /**
         * @return array
         */
        public function getListaStavki()
        {
            return $this->listaStavki;
        }

        public function dodajStavku($stavka) {
            $this->listaStavki[] = $stavka;
        }
    }