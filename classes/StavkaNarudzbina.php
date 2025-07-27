<?php
    class StavkaNarudzbina {
        private $id;
        private $kolicina;
        private $idNarudzbina;
        private $idAlbum;

        /**
         * @param $id
         * @param $kolicina
         * @param $idNarudzbina
         * @param $idAlbum
         */
        public function __construct($id, $kolicina, $idNarudzbina, $idAlbum)
        {
            $this->id = $id;
            $this->kolicina = $kolicina;
            $this->idNarudzbina = $idNarudzbina;
            $this->idAlbum = $idAlbum;
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
        public function getKolicina()
        {
            return $this->kolicina;
        }

        /**
         * @param mixed $kolicina
         */
        public function setKolicina($kolicina)
        {
            $this->kolicina = $kolicina;
        }

        /**
         * @return mixed
         */
        public function getIdNarudzbina()
        {
            return $this->idNarudzbina;
        }

        /**
         * @param mixed $idNarudzbina
         */
        public function setIdNarudzbina($idNarudzbina)
        {
            $this->idNarudzbina = $idNarudzbina;
        }

        /**
         * @return mixed
         */
        public function getIdAlbum()
        {
            return $this->idAlbum;
        }

        /**
         * @param mixed $idAlbum
         */
        public function setIdAlbum($idAlbum)
        {
            $this->idAlbum = $idAlbum;
        }

    }