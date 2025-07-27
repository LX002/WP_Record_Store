<?php
    class Beat {
        private $idBeat;
        private $beatPath;
        private $idKorisnik;

        /**
         * @param $idBeat
         * @param $beatPath
         * @param $idKorisnik
         */
        public function __construct($beatPath, $idKorisnik)
        {
            $this->beatPath = $beatPath;
            $this->idKorisnik = $idKorisnik;
        }

        /**
         * @return mixed
         */
        public function getIdBeat()
        {
            return $this->idBeat;
        }

        /**
         * @param mixed $idBeat
         */
        public function setIdBeat($idBeat)
        {
            $this->idBeat = $idBeat;
        }

        /**
         * @return mixed
         */
        public function getBeatPath()
        {
            return $this->beatPath;
        }

        /**
         * @param mixed $beatPath
         */
        public function setBeatPath($beatPath)
        {
            $this->beatPath = $beatPath;
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

    }